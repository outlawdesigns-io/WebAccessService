<?php

require_once __DIR__ . '/Libs/Api/Api.php';
require_once __DIR__ . '/Libs/JwksTokenValidator-PHP/JwksTokenValidator.php';
require_once __DIR__ . '/Models/Host.php';
require_once __DIR__ . '/Models/Client.php';
require_once __DIR__ . '/Models/Request.php';


class EndPoint extends API{

    const GETERR = 'Can only GET this endpoint';
    const POSTERR = 'Can only POST this endpoint';
    const REQERR = 'Malformed Request.';
    protected static $_authErrors = array(
      "headers"=>"Missing required headers.",
      "noToken"=>"Access Denied. No Token Present.",
      "badToken"=>"Access Denied. Invalid Token"
    );

    protected $_tokenValidator;
    protected $_jwksUri;
    protected $_cacheFile;
    protected $_cacheTtl;
    protected $_oauthAudience;
    protected $_token;
    protected $_user;    

    public function __construct($request,$origin)
    {
      parent::__construct($request);
      $this->_loadEnvSettings();
      $this->_tokenValidator = new JwksTokenValidator($this->_jwksUri, $this->_cacheFile, $this->_cacheTtl);
      if(!isset($this->headers['Authorization'])){
        throw new \Exception(self::$_authErrors['noToken']);
      }
      $token = explode(' ',$this->headers['Authorization'])[1] ?? null;
      if(!$token){
        throw new \Exception(self::$_authErrors['headers']);
      }
      $this->_token = $token;
      if(!$this->_verifyToken()){
        throw new \Exception(self::$_authErrors['badToken']);
      }
    }
    protected function example(){
      return array("endPoint"=>$this->endpoint,"verb"=>$this->verb,"args"=>$this->args,"request"=>$this->request);
    }
    private function _loadEnvSettings(){
      if(!$this->_jwksUri = getenv('OAUTH_JWKS_URI')){
        throw new \Exception('Unable to access environment variable: OAUTH_JWKS_URI');
      }
      if(!$this->_cacheFile = getenv('OAUTH_CACHE_PATH')){
        throw new \Exception('Unable to access environment variable: OAUTH_CACHE_PATH');
      }
      if(!$this->_cacheTtl = getenv('OATH_CACHE_TTL')){
        throw new \Exception('Unable to access environment variable: OATH_CACHE_TTL');
      }
      if(!$this->_oauthAudience = getenv('OATH_AUDIENCE')){
        throw new \Exception('Unable to access environment variable: OATH_AUDIENCE');
      }
    }
    private function _verifyToken(){
      try{
        $payload = $this->_tokenValidator->validateJwt($this->_token);
      }catch(\Exception $ex){
        return false;
      }
      if(!in_array($this->_oauthAudience,$payload['aud'])){
        return false;
      }
      $this->_user = $payload;
      return true;
    }
    protected function verify(){
      if(!$this->_verifyToken()){
        throw new \Exception('Token Rejected');
      }
      return $this->headers['auth_token'];
    }
    protected function host(){
      $data = null;
      if(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'POST'){ //create
        $data = new Host();
        $data->setFields($this->request)->create();
      }elseif(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'GET'){ //get all
        $data = Host::getAll();
      }elseif(!isset($this->verb) &&(int)$this->args[0] && $this->method == 'GET'){ //get by id
        $data = new Host($this->args[0]);
      }elseif((int)$this->args[0] && $this->method == 'PUT'){ //update by id
        $data = new Host($this->args[0]);
        $data->setFields($this->request)->update();
      }elseif(isset($this->verb)){
        $data = $this->_parseVerb();
      }else{
        throw new \Exception(self::REQERR);
      }
      return $data;
    }
    protected function request(){
      $data = null;
      if($this->method != "GET"){
        throw new \Exception(self::GETERR);
      }elseif(!isset($this->verb) && !isset($this->args[0])){
        $data = Request::getAll();
      }elseif(!isset($this->verb) && (int)$this->args[0]){
        $data = new Request($this->args[0]);
      }elseif(isset($this->verb)){
        $data = $this->_parseVerb();
      }else{
        throw new \Exception(self::REQERR);
      }
      return $data;
    }
    protected function client(){
      $data = null;
      if($this->method != 'GET'){
        throw new \Exception(self::GETERR);
      }elseif(!isset($this->verb) && !isset($this->args[0])){
        $data = Client::getAll();
      }elseif(!isset($this->verb) && (int)$this->args[0]){
        $data = new Client($this->args[0]);
      }elseif(isset($this->verb)){
        $data = $this->_parseVerb();
      }else{
        throw new \Exception(self::REQERR);
      }
      return $data;
    }
    protected function logMonitorRun(){
      $data = null;
      if($this->method != 'GET'){
        throw new \Exception(self::GETERR);
      }elseif(!isset($this->verb) && !isset($this->args[0])){
        $data = LogMonitorRun::getAll();
      }elseif(!isset($this->verb) && (int)$this->args[0]){
        $data = new LogMonitorRun($this->args[0]);
      }elseif(isset($this->verb)){
        $data = $this->_parseVerb();
      }else{
        throw new \Exception(self::REQERR);
      }
      return $data;
    }
    protected function _parseVerb(){
      $data = null;
      $key = ucwords($this->endpoint);
      if(strtolower($this->verb) == 'search'){
        if($key == 'Request'){
          $data = $this->_requestSearch();
        }else{
          $data = $key::search($this->args[0],$this->args[1]);
        }
      }elseif(strtolower($this->verb) == 'daily'){
        $data = $key::dailyCount($this->args[0]);
      }elseif(strtolower($this->verb) == 'extension'){
        $data = $key::docTypeCounts($this->args[0]);
      }elseif(strtolower($this->verb) == 'count'){
        $data = $key::count();
      }elseif(strtolower($this->verb) == 'group'){
        $data = $key::countOf($this->args[0]);
      }elseif(strtolower($this->verb) == 'recent'){
        $data = $key::recent($this->args[0]);
      }else{
        throw new \Exception('Invalid Verb.');
      }
      return $data;
    }
    protected function _requestSearch(){
      $data = null;
      $key = ucwords($this->endpoint);
      if(isset($this->args[2])){
        $data = $key::dateConstrainedSearch($this->args[0],$this->args[1],">",$this->args[2]);
      }else{
        $data = $key::search($this->args[0],$this->args[1]);
      }
      return $data;
    }
}

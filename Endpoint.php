<?php

require_once __DIR__ . '/Api/Api.php';
require_once __DIR__ . '/AccessLogParser/Models/Host.php';
require_once __DIR__ . '/AccessLogParser/Models/Client.php';
require_once __DIR__ . '/AccessLogParser/Models/Request.php';
require_once __DIR__ . '/AccessLogParser/Models/LogMonitorRun.php';


class EndPoint extends API{

    const ACCOUNTS = 'https://api.outlawdesigns.io:9661/';
    const GETERR = 'Can only GET this endpoint';
    const POSTERR = 'Can only POST this endpoint';
    const REQERR = 'Malformed Request.';
    protected static $_authErrors = array(
      "headers"=>"Missing required headers.",
      "noToken"=>"Access Denied. No Token Present.",
      "badToken"=>"Access Denied. Invalid Token"
    );

    public function __construct($request,$origin)
    {
        parent::__construct($request);
        if(isset($this->headers['request_token']) && ! isset($this->headers['password'])){
          throw new \Exception(self::$_authErrors['headers']);
        }elseif(!isset($this->headers['auth_token']) && !isset($this->headers['request_token'])){
          throw new \Exception(self::$_authErrors['noToken']);
        }elseif(!$this->_verifyToken() && !isset($this->headers['request_token'])){
          throw new \Exception(self::$_authErrors['badToken']);
        }
    }
    private function _verifyToken(){
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL,self::ACCOUNTS . "verify/");
      curl_setopt($ch,CURLOPT_HTTPHEADER,array('auth_token: ' . $this->headers['auth_token']));
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      $output = json_decode(curl_exec($ch));
      curl_close($ch);
      if(isset($output->error)){
        return false;
      }
      $this->user = $output;
      return true;
    }
    private function _authenticate(){
      $headers = array('request_token: ' . $this->headers['request_token'],'password: ' . $this->headers['password']);
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL,self::ACCOUNTS . "authenticate/");
      curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      $output = json_decode(curl_exec($ch));
      curl_close($ch);
      if(isset($output->error)){
        throw new \Exception($output->error);
      }
      $this->headers['auth_token'] = $output->token;
      $this->_verifyToken();
      return $output;
    }
    protected function example(){
      return array("endPoint"=>$this->endpoint,"verb"=>$this->verb,"args"=>$this->args,"request"=>$this->request);
    }
    protected function authenticate(){
      return $this->_authenticate();
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
        $data = $key::search($this->args[0],$this->args[1]);
      }elseif(strtolower($this->verb) == 'daily'){
        $data = $key::dailyCount($this->args[0]);
      }elseif(strtolower($this->verb) == 'songs'){
        $data = $key::SongCounts();
      }elseif(strtolower($this->verb) == 'movies' || strtolower($this->verb) == 'tv'){
        $data = $key::videoCounts(ucwords($this->verb));
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
}

<?php

require_once __DIR__ . '/../Libs/Record/Record.php';

class Client extends Record{

  const DB = 'web_access';
  const TABLE = 'Client';
  const PRIMARYKEY = 'Id';

  public $Id;
  public $IpAddress;
  public $StreetAddress;
  public $City;
  public $Country;
  public $CountryCode;
  public $Isp;
  public $lat;
  public $lon;
  public $Org;
  public $Region;
  public $RegionName;
  public $TimeZone;
  public $Zip;
  public $Malevolent;

  public function __construct($Id = null){
    parent::__construct(self::DB,self::TABLE,self::PRIMARYKEY,$Id);
  }
  public static function getAll(){
    $data = array();
    $ids = parent::_getAll(self::DB,self::TABLE,self::PRIMARYKEY);
    foreach($ids as $id){
      $data[] = new self($id);
    }
    return $data;
  }
  public static function exists($IpAddress){
    $results = $GLOBALS['db']
        ->database(self::DB)
        ->table(self::TABLE)
        ->select(self::PRIMARYKEY)
        ->where("IpAddress","=","'" . $IpAddress . "'")
        ->get();
    if(!mysqli_num_rows($results)){
      return false;
    }
    return true;
  }
  public static function search($key,$value){
    $data = array();
    $ids = parent::_search(self::DB,self::TABLE,self::PRIMARYKEY,$key,$value);
    foreach($ids as $id){
        $data[] = new self($id);
    }
    return $data;
  }
  public static function count(){
    return parent::_count(self::DB,self::TABLE);
  }
  public static function countOf($key){
    return parent::_countOf(self::DB,self::TABLE,$key);
  }
  public static function recent($limit){
    $data = array();
    $ids = parent::_getRecent(self::DB,self::TABLE,self::PRIMARYKEY,$limit);
    foreach($ids as $id){
      $data[] = new self($id);
    }
    return $data;
  }
}

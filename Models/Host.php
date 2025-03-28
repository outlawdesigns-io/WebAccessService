<?php

require_once __DIR__ . '/../Libs/Record/Record.php';

class Host extends Record{

  const DB = 'web_access';
  const TABLE = 'hosts';
  const PRIMARYKEY = 'id';

  public $id;
  public $label;
  public $friendlyLabel;
  public $port;
  public $log_path;
  public $active;

  public function __construct($id = null){
    parent::__construct(self::DB,self::TABLE,self::PRIMARYKEY,$id);
  }
  public static function getAll(){
    $data = array();
    $ids = parent::_getAll(self::DB,self::TABLE,self::PRIMARYKEY);
    foreach($ids as $id){
        $data[] = new self($id);
    }
    return $data;
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

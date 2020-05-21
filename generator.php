<?php

require('db.php');

abstract class AbstractGenerator {
  protected $mdb;
  protected $data;
  function __construct() {
    $this->mdb = new StatDB();
    $this->data = array();
  }
  
  abstract public function generate();
  
  public function emit($key) {
     return $this->data[$key];
  }

}
?>

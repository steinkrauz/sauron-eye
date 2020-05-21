<?php 

class Test1 {
  protected $count = -1;
  function __construct() {
    $this->count=0;
  }

  function getD() {
   $this->count++;
   return $this->count;
  } 
}

$g = new Test1();

include 'test.tpl'
?>
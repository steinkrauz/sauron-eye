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

echo $test->getD();
//echo $g->getD;
//print "$g->getD()\n";
include 'test.tpl'



?>
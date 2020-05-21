<?php 

require('repgens.php');

$module = $_GET["type"];
switch ($module) {
  case "modules": $g = new ModulesGenerator(); break;
  case "users":   $g = new UsersGenerator(); break;
  case "period":  $g = new PeriodGenerator(); break;
  default: $g = new ModulesGenerator(); 
}

$g->generate();
include 'main.html'
?>

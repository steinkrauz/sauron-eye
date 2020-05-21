<?php 

require('tbl.php');
require('generator.php');
require('menu.php');

class QueryGenerator extends AbstractGenerator{

      private $tc_user;
      private $module;
      private $days;

function makeOptions($field, $current) {
	$values = $this->mdb->getFieldValues($field);
	$opts = "<option value=\"\"></option>";
	foreach ($values as $val) {
		$opts .= "<option value=\"$val[0]\" ";
		if ($val[0]==$current) $opts .= "selected=\"selected\"";
		$opts .= ">$val[0]</option>";	
	}
	return $opts;
      }
      
function generate() {
     $this->data["title"]="Статистика ПО";
     $this->data["menu"]=makeMenu();

     if (isset($_GET["tc_user"]) ){
	$tc_user = $_GET["tc_user"];
     } else {
	$tc_user="";
     }

     if (isset($_GET["module"])) {
	$module =  $_GET["module"];
     } else {
	$module = "";
     }

     if (isset($_GET["days"])) {
	$days = $_GET["days"];
     } else {
	$days = 30;
     }

     $this->data["users"] = $this->makeOptions("tc_user",$tc_user);
     $this->data["modules"] = $this->makeOptions("module",$module);
     $this->data["days"] = "value=$days";


     $cont = "";
     $clause = new ClauseGenerator();
     if ($tc_user!="" || $module!="") {
	     if ($tc_user!="") $clause->field("tc_user",$tc_user);
	     if ($module!="") $clause->field("module",$module);
     }
     
     if ($days>0) {
	     $clause->expr("run_date BETWEEN CURDATE() - INTERVAL $days DAY AND NOW()");
     }
     $clause->order_desc("run_date");
     $rows = $this->mdb->getRowsWithClause($clause->get());
     $tr = new TableRenderer();
     $tr->setHeaders(array("Дата","Модуль","Пользователь"));
     $tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont .= $tr->makeTable($rows);
     $this->data["content"]=$cont;
  }

}

$g = new QueryGenerator();
$g->generate();
include 'query.html'
?>

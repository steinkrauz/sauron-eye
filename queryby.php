<?php 

require('tbl.php');
require('generator.php');
require('menu.php');

class QueryByGenerator extends AbstractGenerator{
  
      private $days;
      private $mode;
      private $field_val;
      private $field_wh;
      private $field_sl;


      function makeOptions($field, $current) {
	$values = $this->mdb->getFieldValues($field);
	$opts = "<option value=\"\"></option>";
	foreach ($values as $val) {
		$optval = htmlentities($val[0]);
		$opts .= "<option value=\"$optval\" ";
		if ($val[0]==$current) $opts .= "selected=\"selected\"";
		$opts .= ">$val[0]</option>";	
	}
	return $opts;
      }
      
function generate() {
	$this->data["menu"]=makeMenu();

    if (isset($_GET["mode"]) ){
	$mode = $_GET["mode"];
     } else {
	$mode="u";
     }
     $this->data["mode"] = "<input type=hidden name=mode value=$mode />";

     if (isset($_GET["field_val"]) ){
	$field_val =  html_entity_decode($_GET["field_val"]);
     } else {
	$field_val="";
     }

     if (isset($_GET["days"])) {
	$days = $_GET["days"];
     } else {
	$days = 30;
     }

     if ($mode=="u") {
	     $this->field_wh = "tc_user";
	     $this->field_sl = "module";
	     $this->data["head"] = "Пользователь";
	     $this->data["col1"] = "Модуль";
	     $this->data["title"] = "Использование модулей по пользователям";
     } else if ($mode=="m") {
	     $this->field_wh = "module";
	     $this->field_sl = "tc_user";
	     $this->data["head"] = "Модуль";
	     $this->data["col1"] = "Пользователь";
	     $this->data["title"] = "Использование модуля пользователями";
     }

     $this->data["values"] = $this->makeOptions($this->field_wh,$field_val);
     $this->data["days"] = "value=$days";

     $cont = "";
     $clause = new ClauseGenerator(); 
     if ($field_val!="") {
	     $clause->field($this->field_wh,$field_val);
     }
     
     if ($days>0) {
	     $clause->expr("run_date BETWEEN CURDATE() - INTERVAL $days DAY AND NOW()");
     }

     if ($field_val!="") {
	$clause->group_order($this->field_sl);
	$rows = $this->mdb->getCountedRowsForValueWithClause($this->field_sl, $clause->get());
     } else {
	 $rows = array();
     }

     $tr = new TableRenderer();
     $tr->setHeaders(array($this->data["col1"], "Запусков"));
     $tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont .= $tr->makeTable($rows);
     $this->data["content"]=$cont;
  }

}

$g = new QueryByGenerator();
$g->generate();
include 'queryby.html'
?>

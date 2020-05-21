<?php 

require('tbl.php');
require('generator.php');
require('menu.php');

abstract class RepGen extends AbstractGenerator {
	protected $tr;
	protected $field;
	protected $head_style = "rep_tbl_head";
	function makeTable($head, $range) {
	     $cont = "";
	     $cont .= "<p class=\"$this->head_style\">$head</p>";
	     $rows = $this->mdb->getFieldStat($this->field,$range);
	     $cont .= $this->tr->makeTable($rows);
	     return $cont;
	}

}

class ModulesGenerator extends RepGen{
      
function generate() {
     $this->data["title"]="���������� �� �� �������";
     $this->data["menu"]=makeMenu();
     $this->field = "module";
     $this->tr = new TableRenderer();
     $this->tr->setHeaders(array("������","���������� ��������"));
     $this->tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont = "";

     $cont .= $this->makeTable("������� �������","day");
     $cont .= $this->makeTable("������� �� ������","week");
     $cont .= $this->makeTable("������� �� ������� �����","month");
     $cont .= $this->makeTable("������� �� 30 ����","30days");
     $cont .= $this->makeTable("������� �� ���","year");
     $cont .= $this->makeTable("������� �� �� �����","");

     $this->data["content"]=$cont;
  }

}

class UsersGenerator extends RepGen{
      
function generate() {
     $this->data["title"]="���������� �� �� �������������";
     $this->data["menu"]=makeMenu();
     $this->field = "tc_user";
     $this->tr = new TableRenderer();
     $this->tr->setHeaders(array("������������","���������� ��������"));
     $this->tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont = "";

     $cont .= $this->makeTable("������� �������","day");
     $cont .= $this->makeTable("������� �� ������","week");
     $cont .= $this->makeTable("������� �� ������� �����","month");
     $cont .= $this->makeTable("������� �� 30 ����","30days");
     $cont .= $this->makeTable("������� �� ���","year");
     $cont .= $this->makeTable("������� �� �� �����","");

     $this->data["content"]=$cont;
  }

}

class PeriodGenerator extends RepGen {
function generate() {
     $this->data["title"]="���������� �� �� ��������";
     $this->data["menu"]=makeMenu();
     $this->tr = new TableRenderer();

     $this->tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont = "";

     $cont .= "<p class=\"$this->head_style\">������������� �� ������� ����</p>";
     $this->tr->setHeaders(array("������","���������� ��������"));
     $rows = $this->mdb->getRunsByWeek();
     $cont .= $this->tr->makeTable($rows);

     $cont .= "<p class=\"$this->head_style\">������������� �� �������</p>";     
     $this->tr->setHeaders(array("�����","���������� ��������"));
     $rows = $this->mdb->getRunsByMonth();
     $cont .= $this->tr->makeTable($rows);


     $this->data["content"]=$cont;
  }

}

?>

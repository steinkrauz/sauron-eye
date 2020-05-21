<?php 

require('tbl.php');
require('generator.php');
require('menu.php');

class IndexGenerator extends AbstractGenerator{
      
	function generate() {
     $this->data["title"]="���������� ��";
     $this->data["menu"]=makeMenu();

     $numTotal = $this->mdb->getFullCount();
     $numToday = $this->mdb->getTodayCount();
     $numMonth = $this->mdb->getLastMonthCount();
     $numUser = $this->mdb->getFieldCount("tc_user");
     $numModule = $this->mdb->getFieldCount("module");
     $cont = "<font size=\"+1\"><b>����� ��������: $numTotal </b></font><br>";
     $cont .= "�������� �������: $numToday <br>";
     $cont .= "�������� �� ������� �����: $numMonth <br>";
     $cont .= "���������� �������������: $numUser ���.<br>";
     $cont .= "������������ �������: $numModule";
     $rows = $this->mdb->getLast30DaysRecords();
     $tr = new TableRenderer();
     $tr->setHeaders(array("����","������","������������"));
     $tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont .= $tr->makeTable($rows);
     $this->data["content"]=$cont;
  }

}

$g = new IndexGenerator();
$g->generate();
include 'main.html'
?>

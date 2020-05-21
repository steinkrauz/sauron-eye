<?php 

require('tbl.php');
require('generator.php');
require('menu.php');

class IndexGenerator extends AbstractGenerator{
      
	function generate() {
     $this->data["title"]="Статистика ПО";
     $this->data["menu"]=makeMenu();

     $numTotal = $this->mdb->getFullCount();
     $numToday = $this->mdb->getTodayCount();
     $numMonth = $this->mdb->getLastMonthCount();
     $numUser = $this->mdb->getFieldCount("tc_user");
     $numModule = $this->mdb->getFieldCount("module");
     $cont = "<font size=\"+1\"><b>Всего запусков: $numTotal </b></font><br>";
     $cont .= "Запусков сегодня: $numToday <br>";
     $cont .= "Запусков за текущий месяц: $numMonth <br>";
     $cont .= "Количество пользователей: $numUser чел.<br>";
     $cont .= "Используется модулей: $numModule";
     $rows = $this->mdb->getLast30DaysRecords();
     $tr = new TableRenderer();
     $tr->setHeaders(array("Дата","Модуль","Пользователь"));
     $tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont .= $tr->makeTable($rows);
     $this->data["content"]=$cont;
  }

}

$g = new IndexGenerator();
$g->generate();
include 'main.html'
?>

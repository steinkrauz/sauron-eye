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
     $this->data["title"]="Статистика ПО по модулям";
     $this->data["menu"]=makeMenu();
     $this->field = "module";
     $this->tr = new TableRenderer();
     $this->tr->setHeaders(array("Модуль","Количество запусков"));
     $this->tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont = "";

     $cont .= $this->makeTable("Запуски сегодня","day");
     $cont .= $this->makeTable("Запуски за неделю","week");
     $cont .= $this->makeTable("Запуски за текущий месяц","month");
     $cont .= $this->makeTable("Запуски за 30 дней","30days");
     $cont .= $this->makeTable("Запуски за год","year");
     $cont .= $this->makeTable("Запуски за всё время","");

     $this->data["content"]=$cont;
  }

}

class UsersGenerator extends RepGen{
      
function generate() {
     $this->data["title"]="Статистика ПО по пользователям";
     $this->data["menu"]=makeMenu();
     $this->field = "tc_user";
     $this->tr = new TableRenderer();
     $this->tr->setHeaders(array("Пользователь","Количество запусков"));
     $this->tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont = "";

     $cont .= $this->makeTable("Запуски сегодня","day");
     $cont .= $this->makeTable("Запуски за неделю","week");
     $cont .= $this->makeTable("Запуски за текущий месяц","month");
     $cont .= $this->makeTable("Запуски за 30 дней","30days");
     $cont .= $this->makeTable("Запуски за год","year");
     $cont .= $this->makeTable("Запуски за всё время","");

     $this->data["content"]=$cont;
  }

}

class PeriodGenerator extends RepGen {
function generate() {
     $this->data["title"]="Статистика ПО по периодам";
     $this->data["menu"]=makeMenu();
     $this->tr = new TableRenderer();

     $this->tr->setClasses("tbstat","treven","trodd","tdstat"); 
     $cont = "";

     $cont .= "<p class=\"$this->head_style\">Использование по неделям года</p>";
     $this->tr->setHeaders(array("Неделя","Количество запусков"));
     $rows = $this->mdb->getRunsByWeek();
     $cont .= $this->tr->makeTable($rows);

     $cont .= "<p class=\"$this->head_style\">Использование по месяцам</p>";     
     $this->tr->setHeaders(array("Месяц","Количество запусков"));
     $rows = $this->mdb->getRunsByMonth();
     $cont .= $this->tr->makeTable($rows);


     $this->data["content"]=$cont;
  }

}

?>

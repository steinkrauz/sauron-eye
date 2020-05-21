<?php 

require('config.php');
require('clause.php');

class StatDB {
  private $wh_last30 = "run_date BETWEEN CURDATE() - INTERVAL 30 DAY AND NOW()";
  private $wh_lastMonth = "run_date >= DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY)";

  protected $mdb;
  protected $tbl;
  public function __construct() {
	global $cfg;
	$this->tbl = 'stats';
	$this->mdb = mysqli_connect($cfg['DB_HOST'],$cfg['DB_USER'],$cfg['DB_PASS'],$cfg['DB_SCHEMA']);
        if ($this->mdb==null) die(mysqli_error($this->mdb));
	mysqli_set_charset($this->mdb,$cfg['DB_CHARSET']);
  }

  public function __destruct() {
	mysqli_close($this->mdb);
  }

  public function add_record($os_user, $tc_user, $run_date, $module) {
	if (!mysqli_query($this->mdb,"insert into $this->tbl (os_user, tc_user, run_date, module) values('$os_user','$tc_user',FROM_UNIXTIME($run_date),'$module')")) die(mysqli_error($this->mdb));
  }

  protected function _countQuery($query) {
	$res = mysqli_query($this->mdb, $query);
	if ($res===FALSE) die(mysqli_error($this->mdb));
	$rows = mysqli_fetch_row($res);
	mysqli_free_result($res);
	return $rows[0];
  }

  public function getFullCount() {
	  $query = "select count(*) from $this->tbl";
	  return $this->_countQuery($query);
  }

   public function getFieldCount($field) {
	  $query = "select count(distinct $field) from $this->tbl";
	  return $this->_countQuery($query);
   }

  public function getFieldValues($field) {
	  $query = "select distinct $field from $this->tbl order by $field";
	  return $this->getQueryRows($query);
  }


  public function getTodayCount() {
      $where = new ClauseGenerator();
      $where->expr("run_date >= CURDATE()");
      $query="select count(*) from $this->tbl {$where->get()} ";
      return $this->_countQuery($query);
  }
  public function getLastMonthCount() {
      $where = new ClauseGenerator();
      $where->expr($this->wh_lastMonth);
      $query="select count(*) from $this->tbl {$where->get()}";
      return $this->_countQuery($query);
  }

  private  function getQueryRows($query) {
    	$res = mysqli_query($this->mdb, $query);
	if ($res===FALSE) die(mysqli_error($this->mdb));
	$rows = mysqli_fetch_all($res);
	mysqli_free_result($res);
	return $rows;
  }

  public function getLastRecords($count) {
        return $this->getQueryRows("select run_date, module, tc_user from $this->tbl order by run_date desc limit $count");
  }

  public function getLast30DaysRecords() {
      $where = new ClauseGenerator();
      $where->expr($this->wh_last30);
      $where->order_desc('run_date');
      return $this->getQueryRows("select run_date, module, tc_user from $this->tbl {$where->get()}");
  }

  public function getRowsWithClause($clause) {
        return $this->getQueryRows("select run_date, module, tc_user from $this->tbl $clause");
  }

  public function getCountedRowsForValueWithClause($col, $clause) {
        return $this->getQueryRows("select $col, count($col) from $this->tbl $clause");
  }

  
  public function getFieldStat($field, $range = "") {
	  $where = new ClauseGenerator();
	  switch ($range) {
	  case "year":	    $where->expr('year(run_date)=year(curdate())'); break;
	  case "month":	    $where->expr($this->wh_lastMonth); break;
	  case "30days":    $where->expr($this->wh_last30); break;
	  case "week":	    $where->expr('yearweek(run_date) = yearweek(curdate())'); break;
	  case "day" :	    $where->expr('run_date >= CURDATE()');
	  }
	  $where->group($field);
	  $where->order_desc('runs');
	 return $this->getQueryRows("select $field, count($field) as runs from $this->tbl {$where->get()}");
  }

  public function getRunsByMonth() {
      $where = new ClauseGenerator();
      $where->expr('year(run_date)=year(curdate())');
      $where->group('month(run_date)');
      $where->order_desc('month(run_date)');
	return $this->getQueryRows("select ELT( month(run_date), 'Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь') as month, count(*) from $this->tbl {$where->get()}");
  }
  
    public function getRunsByWeek() {
	$where = new ClauseGenerator();
	$where->expr('year(run_date)=year(curdate())');
	$where->group('week');
	$where->order_desc('week');
	return $this->getQueryRows("select week(run_date) as 'week', count('week') from $this->tbl {$where->get()}");
  }

}

?>

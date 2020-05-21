<?php
class ClauseGenerator {
    protected $clause = "";

    function __construct() {
	$this->clause = " WHERE tc_user NOT IN (SELECT username FROM skip_users)";
    }

    protected function _and() {
	$this->clause .= " AND ";
    }

    public function field($fname, $fval) {
	$this->_and();
	$this->clause .= "$fname='$fval'";
    }

    public function expr($expression) {
	$this->_and();
	$this->clause .= $expression;
    }

    public function group($fname) {
	$this->clause .= " group by $fname";
    }

    public function group_order($fname) {
	$this->clause .= " group by $fname order by $fname";
    }

    public function order_desc($fname) {
	$this->clause .= " order by $fname desc";
    }

    public function get() {
	return $this->clause;
    }
}

?>

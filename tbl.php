<?php

class TableRenderer {
	private $table_class;
	private $row_class_odd;
	private $row_class_even;
	private $cell_class;
	private $table_style;
	private $row_style_odd;
	private $row_style_even;
	private $cell_style;
	private $headers;
	private $row_num;

	public function __construct() {
		$this->table_class = "";
		$this->row_class_even = "";
		$this->row_class_odd = "";
		$this->cell_class = "";
		$this->table_style = "";
		$this->row_style_even = "";
		$this->row_style_odd = "";
		$this->cell_style = "";
		$this->row_num = 1;
		$this->headers = array();
	}

	public function setClasses($t, $re, $ro, $c) {
		$this->table_class = $t;
		$this->row_class_even = $re;
		$this->row_class_odd = $ro;
		$this->cell_class = $c;
	}

	public function setStyles($t, $re, $ro, $c) {
		$this->table_style = $t;
		$this->row_style_even = $re;
		$this->row_style_odd = $ro;
		$this->cell_style = $c;
	}
	
	private function getTableTag() {
		$attr = "<table ";
		if ($this->table_class!="") {
			$attr .= "class=\"$this->table_class\""; 
		} else if ($this->table_style!="") {
			$attr .= "style=\"$this->table_style\""; 
		}
		$attr .= " >";
		return $attr;
	}

	private function getRowClass() {
		if ($this->row_num % 2 == 0) {
			return $this->row_class_even;
		} else {
			return $this->row_class_odd;
		}
	}

	private function getRowStyle() {
		if ($this->row_num % 2 == 0) {
			return $this->row_style_even;
		} else {
			return $this->row_style_odd;
		}
	}

	private function getRowTag() {
		$attr = "<tr ";
		if ($this->getRowClass()!="") {
			$attr .= "class=\"{$this->getRowClass()}\"";
		} else if ($this->getRowStyle()!="") {
			$attr .= "style=\"{$this->getRowStyle()}\"";
		} 
		$attr .= " >";
		return $attr;
	}

	private function getCellTag() {
		$attr = "<td ";
		if ($this->cell_class!="") {
			$attr .= "class=\"{$this->cell_class}\""; 
		} else if ($this->cell_style!="") {
			$attr .= "style=\"{$this->cell_style}\""; 
		}
		$attr .= " >";
		return $attr;
	}

	public function setHeaders($h) {
		$this->headers = $h;
	}

	private function addHeaders() {
		if ($this->headers!=array()) {
			$attr = $this->getRowTag();
			foreach ($this->headers as $head) {
				$attr .= "<th>$head</th>";
			}
			$attr .= "</tr>";
			return $attr;
		}
		return "";
	}
	public function nextRow() {
		$this->row_num++;
	}

	public function makeTable($rows) {
		$tbl = $this->getTableTag();
		$tbl .= $this->addHeaders();
		foreach ($rows as $row) {
			$tbl .= $this->getRowTag();
			foreach($row as $cell) {
				$tbl .= $this->getCellTag();
				$tbl .= "$cell</td>";
			}
			$tbl .= "</tr>";
			$this->nextRow();
		}
		$tbl .= "</table>";
		return $tbl;
	}

 }

?>

<?php

$menu_elems = array (
	"modules"=>"�������",
	"users"=>"�������������",
	"period"=>"��������"
);

function makeMenu() {
	global $menu_elems;
	$menu = "<ul type=\"circle\">";
	$menu .= "<li><a href=\"index.php\">������</a></li>";
	$menu .= "<li><a href=\"query.php\">�����</a></li>";
	$menu .= "<li>���������� ��:</li>";
	$menu .= "<ul type=\"dot\">";
	foreach ($menu_elems as $key => $val) {
		$menu .= "<li><a href=\"report.php?type=$key\">$val</a></li>";
	}
	$menu .= "<li><a href=\"queryby.php?mode=u\">������� �������������</a></li>";
	$menu .= "<li><a href=\"queryby.php?mode=m\">������������� �������</a></li>";
	$menu .= "</ul>";
	$menu .= "</ul>";	
	return $menu;
}

?>

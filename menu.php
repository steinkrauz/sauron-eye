<?php

$menu_elems = array (
	"modules"=>"Модулям",
	"users"=>"Пользователям",
	"period"=>"Периодам"
);

function makeMenu() {
	global $menu_elems;
	$menu = "<ul type=\"circle\">";
	$menu .= "<li><a href=\"index.php\">Начало</a></li>";
	$menu .= "<li><a href=\"query.php\">Поиск</a></li>";
	$menu .= "<li>Статистика по:</li>";
	$menu .= "<ul type=\"dot\">";
	foreach ($menu_elems as $key => $val) {
		$menu .= "<li><a href=\"report.php?type=$key\">$val</a></li>";
	}
	$menu .= "<li><a href=\"queryby.php?mode=u\">Модулям пользователей</a></li>";
	$menu .= "<li><a href=\"queryby.php?mode=m\">Пользователям модулей</a></li>";
	$menu .= "</ul>";
	$menu .= "</ul>";	
	return $menu;
}

?>

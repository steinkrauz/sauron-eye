<?php 
require('db.php');

$args_goods = true;

$os_user = '';
if (array_key_exists('os_user',$_POST)) $os_user = $_POST['os_user']; else $args_goods = false;

$tc_user = '';
if (array_key_exists('tc_user',$_POST)) $tc_user= $_POST['tc_user']; else  $args_goods = false;

$run_date = '';
if (array_key_exists('run_date',$_POST)) $run_date= $_POST['run_date']; else $args_goods = false;

$module = '';
if (array_key_exists('module',$_POST)) $module= $_POST['module']; else $args_goods = false; 

header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Expires: " . date("r"));

if ($args_goods==false) {
	http_response_code(400);
	exit();
}

/*print "OS User: $os_user\n";
print "TC User: $tc_user\n";
print "Timestamp: ".date("l, F jS Y, H:i:s",$run_date)."\n";
print "Module: $module\n";*/

$db = new StatDB();
$db->add_record($os_user, $tc_user, $run_date, $module);

?>

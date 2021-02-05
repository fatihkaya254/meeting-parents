<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['fin']) && $_POST['fin'] == '1') {

	$who = $_POST['who'];
	$recordID = $_POST['recordID'];
	$wpdb->query("UPDATE {$wpdb->prefix}mp_lesson_records SET sms_ok = '1' WHERE lr_id = '$recordID'"); 

	$returning = [];
	$returning['success'] = 1;
	$returning['who'] = $who;
	echo json_encode($returning);

}
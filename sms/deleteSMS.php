<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['delete']) && $_POST['delete'] == '1') {

    $recordID = $_POST['recordID'];
    
	$wpdb->query("UPDATE {$wpdb->prefix}mp_lesson_records SET sms_ok = '0' WHERE lr_id = '$recordID'"); 
	$wpdb->query("DELETE FROM {$wpdb->prefix}mp_sms WHERE lr_id = '$recordID'"); 

	$returning = [];
	$returning['success'] = 1;
	$returning['who'] = $recordID;
	echo json_encode($returning);

}
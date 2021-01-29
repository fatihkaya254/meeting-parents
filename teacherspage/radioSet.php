<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['radioSet']) && $_POST['radioSet'] == '1') {

	$homeworkStatus = $_POST['homeworkStatus'];
	$who = $_POST['who'];
	$recordID = $_POST['recordID'];
	$content ='';

	$wpdb->query("UPDATE {$wpdb->prefix}mp_lesson_records SET homework_status = '$homeworkStatus' WHERE lr_id = '$recordID'"); 

	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE lr_id = '$recordID';", ARRAY_A);
	foreach ($wholeexams as $we){
		$content = $we['homework_status'];
	}


	$returning = [];
	$returning['success'] = 1;
	$returning['who'] = $who;
	$returning['content'] = $content;
	echo json_encode($returning);

}
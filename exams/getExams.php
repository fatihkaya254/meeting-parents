<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['getExam']) && $_POST['getExam'] == '1') {

	global $wpdb;
	$content = '';




	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_exams ORDER BY exam_date DESC;", ARRAY_A);
	foreach ($wholeexams as $we){
		$content .= '<tr>';
		$content .= '<td>'.$we["exam_name"].'</td>';
		$content .= '<td>'.$we["exam_date"].'</td>';
		$content .= '<td>'.$we["exam_type"].'</td>';
		$content .= '<td>'.$we["exam_id"].'</td>';
		$content .= '</tr>';
	}

	$returning = [];
	$returning['success'] = 1;
	$returning['content'] = $content;
	echo json_encode($returning);
} 






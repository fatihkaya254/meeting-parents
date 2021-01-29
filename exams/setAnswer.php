<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['setAnswer']) && $_POST['setAnswer'] == '1') {

	$answer = $_POST['answer'];
	$type = $_POST['type'];
	$queid = $_POST['queid'];
	$answer = strtoupper($answer);
	$content ='';


	if ($type == 'b') {
		$wpdb->query("UPDATE {$wpdb->prefix}ex_questions SET question_answer_b = '$answer' WHERE question_id = '$queid'"); 

		$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_questions WHERE question_id = '$queid';", ARRAY_A);
		foreach ($wholeexams as $we){
			$content = $we['question_answer_b'];
		}
	}else{
		$wpdb->query("UPDATE {$wpdb->prefix}ex_questions SET question_answer = '$answer' WHERE question_id = '$queid'"); 
		$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_questions WHERE question_id = '$queid';", ARRAY_A);
		foreach ($wholeexams as $we){
			$content = $we['question_answer'];
		}

	}

	$returning = [];
	$returning['success'] = 1;
	$returning['content'] = $content;
	echo json_encode($returning);

}
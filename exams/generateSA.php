<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");
$getSAURL = site_url().'/wp-content/plugins/meeting-parents/exams/getStudentAnswers.php';


$content = '';

if (isset($_POST['genSA']) && $_POST['genSA'] == '1') {
	
	$examinfo = $_POST['exam'];
	$stuid = $_POST['student'];
	$examArray = explode("-", $examinfo);
	$examID = $examArray[0];
	$examType = $examArray[1];

	$wholeBranch = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_questions WHERE exam_id = '$examID' ORDER BY exbranch_id, question_rating ASC;", ARRAY_A);
	foreach ($wholeBranch as $wb ) {

		$queid = $wb['question_id'];
		
		$wpdb->query("INSERT INTO {$wpdb->prefix}ex_student_answers (sa_id, student_id, question_id, sa_answer) VALUES (null,'$stuid','$queid','')"); 
	}
	




	$returning = [];
	$returning['success'] = 1;
	$returning['url'] = $getSAURL;
	$returning['content'] = $content;
	$returning['name'] = $_POST['nameinfo']  . ' ' . $_POST['exam'] ;

	echo json_encode($returning);
}


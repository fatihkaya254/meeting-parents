<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

$content = '';

if (isset($_POST['setSA']) && $_POST['setSA'] == '1') {
	
	$examid = $_POST['examID'];
	$stuid = $_POST['studentID'];
	$braid = $_POST['branchID'];
	$booktype = $_POST['booktype'];

	$allAnswers = $_POST['answers'];
	$answerArray = str_split($allAnswers);
	$questionsAmound = count($answerArray);

	$wholeQuestions = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}ex_questions` WHERE exam_id = '$examid' AND exbranch_id = '$braid' ORDER BY question_rating ASC", ARRAY_A);
	foreach ($wholeQuestions as $wq) {
		$querat = $wq['question_rating'] - 1 ;
		$answer = $answerArray[$querat];
		$queid = $wq['question_id']; 

		$wpdb->query("UPDATE {$wpdb->prefix}ex_student_answers SET sa_answer = '$answer', book_type = '$booktype' WHERE question_id = '$queid'"); 

	}
	$returning = [];
	$returning['success'] = 1;
	$returning['content'] = $content;

	echo json_encode($returning);
}

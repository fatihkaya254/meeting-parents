<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");



if (isset($_POST['selectPhoto']) && $_POST['selectPhoto'] == '1') {
	$postphoto = $_POST['photo'];
	$getphoto = $_FILES['photo']['tmp_name'];
	$photo = addslashes(file_get_contents($getphoto));
	$queid = $_POST['queid'];
	$answer = strtoupper($answer);
	$wpdb->query("UPDATE {$wpdb->prefix}ex_questions SET question_pic = '$photo' WHERE question_id = '$queid'"); 

	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_questions WHERE question_id = '$queid';", ARRAY_A);
	foreach ($wholeexams as $we){
		$content .= base64_encode($we["question_pic"]);
	}
	$returning = [];
	$returning['success'] = 1;
	$returning['queid'] = $_POST['queid'];
	$returning['content'] = $content;
	echo json_encode($returning);

}
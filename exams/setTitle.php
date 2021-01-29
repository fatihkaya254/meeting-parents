<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");


$content ='';
$returning = [];
if (isset($_POST['setTitle']) && $_POST['setTitle'] == '1') {
	$wt = $_POST['wt'];
	$titleID = $_POST['titleb'];
	$queid = $_POST['queid'];
	$wpdb->query("UPDATE {$wpdb->prefix}ex_questions SET question_title_$wt = '$titleID' WHERE question_id = '$queid'"); 

	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_questions, {$wpdb->prefix}ex_titles WHERE {$wpdb->prefix}ex_questions.question_id = '$queid' AND {$wpdb->prefix}ex_questions.question_title_$wt = {$wpdb->prefix}ex_titles.title_id", ARRAY_A);
	foreach ($wholeexams as $we){
		$content .= $we["title_name"];
	}
	$returning['success'] = 1;
	$returning['queid'] = $_POST['queid'];
	$returning['wt'] = $_POST['wt'];
	$returning['content'] = $content;

}



echo json_encode($returning);
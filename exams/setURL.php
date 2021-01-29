
<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");


$content ='';

if (isset($_POST['setURL']) && $_POST['setURL'] == '1') {
	$solvelink = $_POST['solvelink'];
	$queid = $_POST['queid'];
	$wpdb->query("UPDATE {$wpdb->prefix}ex_questions SET question_solvelink = '$solvelink' WHERE question_id = '$queid'"); 

	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_questions WHERE question_id = '$queid'", ARRAY_A);
	foreach ($wholeexams as $we){
		$content .= $we['question_solvelink'];
	}


}
$returning = [];
$returning['content'] = $content;
$returning['success'] = 1;
$returning['queid'] = $_POST['queid'];

echo json_encode($returning);
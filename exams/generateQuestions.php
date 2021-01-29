
<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['generateQuestions']) && $_POST['generateQuestions'] == '1') {

	global $wpdb;
	$content = '';
	$content .= '<p>'.$_POST['examtype'].'<p>';

	$examtype = $_POST['examtype'];
	$examid = $_POST['examid'];

	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_branch WHERE branch_type = '$examtype';", ARRAY_A);
	foreach ($wholeexams as $we){
		$exbraid = $we['exbranch_id'];
		$qa = $we['question_amound'];
		for ($sayac=1; $sayac < $qa+1 ; $sayac++) { 
			$wpdb->query("INSERT INTO `wp_ex_questions` (`exam_id`, `question_rating`, `exbranch_id`) VALUES ('$examid', '$sayac', '$exbraid')");
			$content .= '"INSERT INTO `wp_ex_questions` (`exam_id`, `question_rating`, `exbranch_id`) VALUES ('.$examid.', '.$sayac.', '.$exbraid.')" <br>';
		}
	}

	$returning = [];
	$returning['success'] = 1;
	$returning['content'] = $content;
	echo json_encode($returning);
} 

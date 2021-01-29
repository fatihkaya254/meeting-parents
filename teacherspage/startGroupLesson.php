<?php 
 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['startLesson']) && $_POST['startLesson'] == '1') {

	global $wpdb;
	$content = '';
	$branch = $_POST['branch'];
	$studentName = $_POST['studentName'];
	$teaid = $_POST['teaid'];
	$who = $_POST['who'];
	$hangisaat = $_POST['hangisaat'];
	$content .= '<p>';
	$content .= $branch;
	$content .= '</p><p>';
	$content .= $studentName;
	$content .= '</p><p>';
	$content .= $teaid;
	$content .= '</p><p>';
	$content .= $hangisaat;
	$content .= '</p>';

	$groupStudents = array();

	$wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group WHERE group_name = '$studentName'", ARRAY_A);
	foreach ($wholerecords as $wr){ 
		for ($i=1; $i < 7 ; $i++) { 
			if ($wr[$i.'_student_id'] != "0") {
				$groupStudents[$i] = $wr[$i.'_student_id'];
			}

		}
	}

	foreach ($groupStudents as $gs) {
		$wpdb->query("INSERT INTO `{$wpdb->prefix}mp_lesson_records` (`lr_id`, `student_id`, `teacher_id`, `hangiders`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `next_homework`, `branch_id`, `sms_ok`, `lesson_url`) VALUES (NULL, '$gs', '$teaid', '$hangisaat', '09:00:00', '00:00:00', '0', '0', '2021-01-10', '0', '$branch', '0', NULL)"); 
	}


	$returning = [];

	$returning['success'] = 1;
	$returning['content'] = $content;
	$returning['who'] = $who;
	echo json_encode($returning);
}
?>
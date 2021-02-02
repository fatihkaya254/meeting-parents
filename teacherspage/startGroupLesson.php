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
	$records = array();

	$wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group WHERE group_name = '$studentName'", ARRAY_A);
	foreach ($wholerecords as $wr){ 
		for ($i=1; $i < 7 ; $i++) { 
			if ($wr[$i.'_student_id'] != "0") {
				$groupStudents[$i-1] = $wr[$i.'_student_id'];
			}

		}
	}

	foreach ($groupStudents as $gs) {
		$wpdb->query("INSERT INTO `{$wpdb->prefix}mp_lesson_records` (`lr_id`, `student_id`, `teacher_id`, `hangiders`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `next_homework`, `branch_id`, `sms_ok`, `lesson_url`) VALUES (NULL, '$gs', '$teaid', '$hangisaat', '09:00:00', '00:00:00', '0', '0', '2021-01-10', '0', '$branch', '0', NULL)"); 
	}

	for ($i=0; $i < 6 ; $i++) { 
		$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE student_id = '$groupStudents[$i]' AND teacher_id = '$teaid' AND hangiders = '$hangisaat' AND date_info = '2021-01-10';", ARRAY_A);
		foreach ($wholeexams as $we){
			$records[$i] = $we['lr_id'];
		}	
	}


	$returning = [];

	$returning['success'] = 1;
	$returning['content'] = $content;
	$returning['g'] = 1;
	$returning['a'] = $records[0];
	$returning['b'] = $records[1];
	$returning['c'] = $records[2];
	$returning['d'] = $records[3];
	$returning['e'] = $records[4];
	$returning['f'] = $records[5];
	$returning['who'] = $who;
	echo json_encode($returning);
}
?>
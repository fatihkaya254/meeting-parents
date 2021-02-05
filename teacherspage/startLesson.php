<?php 

 
$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");
require_once dirname(__FILE__, 2) . '/teacherspage/timeTime.php';

if (isset($_POST['startLesson']) && $_POST['startLesson'] == '1') {
    $tT = new timeTime;
    $time = $tT->getCurrentTime('');
    $date = $tT->getCurrentDate('');

	global $wpdb;
	$content = '';
	$branch = $_POST['branch'];
	$stuid = $_POST['stuid'];
	$teaid = $_POST['teaid'];
	$who = $_POST['who'];
	$hangisaat = $_POST['hangisaat'];
	$content .= '<p>';
	$content .= $branch;
	$content .= '</p><p>';
	$content .= $stuid;
	$content .= '</p><p>';
	$content .= $teaid;
	$content .= '</p><p>';
	$content .= $hangisaat;
	$content .= '</p>';



	$wpdb->query("INSERT INTO `{$wpdb->prefix}mp_lesson_records` (`lr_id`, `student_id`, `teacher_id`, `hangiders`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `next_homework`, `branch_id`, `sms_ok`, `lesson_url`) VALUES (NULL, '$stuid', '$teaid', '$hangisaat', '$time', '00:00:00', '0', '0', '$date', '0', '$branch', '0', NULL)"); 


	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE student_id = '$stuid' AND teacher_id = '$teaid' AND hangiders = '$hangisaat' AND date_info = '$date';", ARRAY_A);
	foreach ($wholeexams as $we){
		$lrid = $we['lr_id'];
	}



	$returning = [];

	$returning['success'] = 1;
	$returning['lrid'] = $lrid;
	$returning['content'] = $content;
	$returning['who'] = $who;
	echo json_encode($returning);
}
?>



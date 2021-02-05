<?php 
 
$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['startLesson']) && $_POST['startLesson'] == '1') {

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



	$wpdb->query("INSERT INTO `{$wpdb->prefix}mp_qprecords` (`qpr_id`, `student_id`, `teacher_id`, `hangiders`, `start_time`, `finish_time`, `s_asked`, `t_asked`, `date_info`, `branch_id`) VALUES (NULL, '$stuid', '$teaid', '$hangisaat', '09:00:00', '00:00:00', '0', '0', '2021-01-10', '$branch')"); 


	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_qprecords WHERE student_id = '$stuid' AND teacher_id = '$teaid' AND hangiders = '$hangisaat' AND date_info = '2021-01-10';", ARRAY_A);
	foreach ($wholeexams as $we){
		$lrid = $we['qpr_id'];
	}



	$returning = [];

	$returning['success'] = 1;
	$returning['lrid'] = $lrid;
	$returning['content'] = $content;
	$returning['who'] = $who;
	echo json_encode($returning);
}
?>



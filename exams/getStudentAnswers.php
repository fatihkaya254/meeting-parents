<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");
$setSAURL = site_url().'/wp-content/plugins/meeting-parents/exams/setSA.php';

$mainTitle = '
<tr>
<th>Öğrenci</th>
<th>Cevaplar</th>
</tr>
';

$content = '';

if (isset($_POST['getSA']) && $_POST['getSA'] == '1') {
	
	$examinfo = $_POST['exam'];
	$stuid = $_POST['student'];
	$examArray = explode("-", $examinfo);
	$examID = $examArray[0];
	$examType = $examArray[1];
	$braid = 0;
	$counter = 0;
	$sAnswers = '';
	$braname = '';
	$wholeBranch = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}ex_questions`, `{$wpdb->prefix}ex_branch`, {$wpdb->prefix}ex_student_answers,  {$wpdb->prefix}mp_student WHERE `{$wpdb->prefix}ex_questions`.`exam_id` = '$examID' AND `{$wpdb->prefix}ex_questions`.`question_id` = {$wpdb->prefix}ex_student_answers.question_id AND `{$wpdb->prefix}ex_questions`.exbranch_id = `{$wpdb->prefix}ex_branch`.exbranch_id AND  {$wpdb->prefix}ex_student_answers.student_id = {$wpdb->prefix}mp_student.student_id ORDER BY {$wpdb->prefix}mp_student.name, {$wpdb->prefix}mp_student.surname, {$wpdb->prefix}ex_questions.question_id ASC ", ARRAY_A);
	foreach ($wholeBranch as $wb ) {

		if ($braid != $wb['exbranch_id']) {
			if ($braid !=0) {				
				$content .= '<tr>';
				$content .= '<td>'.$studentName.'</td>';
				$content .= '<td>'.$braname.' <input type="text" onfocusout="setSA(\''.$setSAURL.'\','.$braid.','.$stuid.','.$examID.')" name="'.$braid.'-'.$stuid.'" id="'.$braid.'-'.$stuid.'" value="'.$sAnswers.'">';
				$content .= '<input style="width:50px; margin:20px;" type="text" name="'.$braid.'-'.$stuid.'booktype" id="'.$braid.'-'.$stuid.'booktype" value="'.$booktype.'"></td>';
				$content .= '</tr>';
			}
			$braid = $wb['exbranch_id'];
			$booktype = $wb['book_type'];
			$braname = $wb['exbranch_name'];
			$studentName = $wb["name"].' '.$wb["surname"].' '.$wb["number"];
			$stuid = $wb["student_id"];
			if ($wb["sa_answer"] == '') {				
				$sAnswers = ' ';
			}else{
				$sAnswers = $wb["sa_answer"];
			}		
		}else{
			if ($wb["sa_answer"] == '') {				
				$sAnswers .= ' ';
			}else{
				$sAnswers .= $wb["sa_answer"];
			}
		}
		if (next($wholeBranch) == null) {
			$content .= '<tr>';
			$content .= '<td>'.$studentName.'</td>';
			$content .= '<td>'.$braname.'<input type="text" onfocusout="setSA(\''.$setSAURL.'\','.$braid.','.$stuid.','.$examID.')" name="'.$braid.'-'.$stuid.'" id="'.$braid.'-'.$stuid.'" value="'.$sAnswers.'">';
			$content .= '<input style="width:50px; margin:20px;" type="text" name="'.$braid.'-'.$stuid.'booktype" id="'.$braid.'-'.$stuid.'booktype" value="'.$booktype.'"></td>';
			$content .= '</tr>';
			
		}
	}
	




	$returning = [];
	$returning['success'] = 1;
	$returning['content'] = $content;
	$returning['mainTitle'] = $mainTitle;

	echo json_encode($returning);
}


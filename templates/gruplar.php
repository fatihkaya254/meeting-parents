<form method="POST">
	<input type="submit" name="senk" id="senk" value="Eski listeden oluştur">
</form>

<?php
global $wpdb;
$sql = "SELECT * FROM  {$wpdb->prefix}mp_group_matches, {$wpdb->prefix}mp_lesson_group, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_group_matches.group_id = {$wpdb->prefix}mp_lesson_group.group_id AND {$wpdb->prefix}mp_group_matches.student_id = {$wpdb->prefix}mp_student.student_id";
$asd = $wpdb->get_results($sql, ARRAY_A);
foreach ($asd as $da) {
	echo $da['group_name'] . ' ' . $da['name'] . ' ' . $da['surname'] . '<br>';
}

if (isset($_POST['senk'])) {

	$wholebranch = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group ", ARRAY_A);
	foreach ($wholebranch as $wb) {
		$groupid = $wb['group_id'];

		$student_id = $wb['1_student_id'];
		if ($student_id != 0) $wpdb->query("INSERT INTO {$wpdb->prefix}mp_group_matches (`student_id`, `group_id`) VALUES ('$student_id', '$groupid')");

		$student_id = $wb['2_student_id'];
		if ($student_id != 0) $wpdb->query("INSERT INTO {$wpdb->prefix}mp_group_matches (`student_id`, `group_id`) VALUES ('$student_id', '$groupid')");

		$student_id = $wb['3_student_id'];
		if ($student_id != 0) $wpdb->query("INSERT INTO {$wpdb->prefix}mp_group_matches (`student_id`, `group_id`) VALUES ('$student_id', '$groupid')");

		$student_id = $wb['4_student_id'];
		if ($student_id != 0) $wpdb->query("INSERT INTO {$wpdb->prefix}mp_group_matches (`student_id`, `group_id`) VALUES ('$student_id', '$groupid')");

		$student_id = $wb['5_student_id'];
		if ($student_id != 0) $wpdb->query("INSERT INTO {$wpdb->prefix}mp_group_matches (`student_id`, `group_id`) VALUES ('$student_id', '$groupid')");

		$student_id = $wb['6_student_id'];
		if ($student_id != 0) $wpdb->query("INSERT INTO {$wpdb->prefix}mp_group_matches (`student_id`, `group_id`) VALUES ('$student_id', '$groupid')");
	}
}



?>
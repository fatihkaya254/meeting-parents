<?php 
global $wpdb;

$st = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE active = 1 ", ARRAY_A);
foreach ($st as $key) {
	$stuid = $key['student_id'];
	$name = $key['name']." ".$key['surname'];
	?>
	<p><?php echo $name; ?></p>
	<?php 
	$numbers = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_smsnumber WHERE student_id = '$stuid' ", ARRAY_A);
	foreach ($numbers as $row) {
		$number = $row['sms_number'];
		$smsid = $row['smsn_id'];
		?>

		<form method="POST">
			<input type="hidden" name="smsid" value="<?php echo $smsid; ?>">
			<input type="text" name="phonenumber" value="<?php echo $number; ?>">
			<button name="degistir" id="degistir">Değiştir</button>
		</form>

		<?php 

	}
}

if (isset($_POST['degistir'])) {
	$id = $_POST['smsid'];
	$pn = $_POST['phonenumber'];

	$wpdb->query
	("UPDATE `wp_mp_smsnumber` SET `sms_number` = '$pn' WHERE `wp_mp_smsnumber`.`smsn_id` = '$id'");



}
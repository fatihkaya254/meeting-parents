<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . "wp-load.php");
require_once dirname(__FILE__, 2) . '/teacherspage/timeTime.php';
$returning = [];
$returning['url'] = site_url() . '/wp-content/plugins/meeting-parents/sms/iletimerkezi.php/';

if (isset($_POST['send']) && $_POST['send'] == '1') {
	$tT = new timeTime;
	$date = $tT->getCurrentDate('');
	$kontrol = 0;
	$gr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_sms WHERE is_sent = '0' AND date_info = '$date';", ARRAY_A);
	foreach ($gr as $ggr) {

		$smsText = $ggr['sms_text'];
		$number = $ggr['parent_num'];
		$smsid = $ggr['sms_id'];
		$lrid = $ggr['lr_id'];

		$returning[$kontrol] = ["sms" => $smsText, "lrid" => $lrid, "number" => $number, "smsid" => $smsid];
		$kontrol++;
	}



	$returning['success'] = 1;
	$returning['kontrol'] = $kontrol;
	echo json_encode($returning);
}

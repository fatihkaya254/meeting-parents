<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);

require_once($path."wp-load.php");

date_default_timezone_set('Europe/Istanbul');


$saaat=date('H:i:s');
$t=date('d-m-Y');
$today = date("D",strtotime($t));
$bugun = "bugun";
$tarih = date("Y-m-d",strtotime($t));

$smsSendURL = site_url().'/wp-content/plugins/meeting-parents/sms/iletimerkezi.php';



if (isset($_POST['smsgonder']) && $_POST['smsgonder'] == "1") {
	$stuid = $_POST['stuid'];
	$numbernumber = $_POST['numara'];
	$texttext = $_POST['mesaj'];
	$smssmsid = $_POST['smsid'];
	global $wpdb;
	$wpdb -> query ("UPDATE `wp_mp_sms` SET `is_sent` ='1', `parent_num` = '$numbernumber', `sms_text` = '$texttext', `date_info` = '$tarih' WHERE `sms_id` = '$smssmsid'");

	$return = [];
	$return['success'] = 1;
	$return['message'] = 'SMS Gonderildi';
	$return['stuid'] = $stuid;
	$return['refresh'] = $smsgetURL;
	$return['numara'] = $numbernumber;
	$return['mesaj'] = $texttext;
	$return['iletimerkezi'] = 1;
	$return['sendsmsurl'] = $smsSendURL;

	echo json_encode($return);



}
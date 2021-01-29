<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['renewlr']) && $_POST['renewlr'] == '1' ) {

	global $wpdb;

	$lrid = $_POST['lrid'];
	$hders = $_POST['hders'];
	$link = $_POST['link'];

	$sql = "UPDATE `wp_mp_lesson_records` SET `hangiders` = '".$hders."', `lesson_url` = '".$link."' WHERE `wp_mp_lesson_records`.`lr_id` = ".$lrid ."";
	$wpdb -> query($sql);



}
<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['setQP']) && $_POST['setQP'] == '1') {

	$tque = $_POST['tque'];
	$sque = $_POST['sque'];
	$who = $_POST['who'];
	$recordID = $_POST['recordID'];
	$sasked ='';
	$tasked ='';
    $kontrol = $_POST['kontrol'];
    
	$wpdb->query("UPDATE {$wpdb->prefix}mp_qprecords SET s_asked = '$sque', t_asked = '$tque' WHERE qpr_id = '$recordID'"); 

	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_qprecords WHERE qpr_id = '$recordID';", ARRAY_A);
	foreach ($wholeexams as $we){
		$sasked = $we['s_asked'];
		$tasked = $we['t_asked'];
	}


	$returning = [];
	$returning['success'] = 1;
	$returning['who'] = $who;
	$returning['kontrol'] = $kontrol;
	$returning['sasked'] = $sasked;
	$returning['tasked'] = $tasked;
	echo json_encode($returning);

}
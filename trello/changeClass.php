<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once $path . "wp-load.php";


if (isset($_POST['change']) && $_POST['change'] == '1') {

    global $wpdb;
	$id = $_POST['id'];
	$day = $_POST['day'];
	$type = $_POST['type'];
	$classroom = $_POST['classroom'];
	$classroom = strtoupper($classroom);
    if ($classroom == "") {
        $classroom = "N404";
    }
    if ($type == "l") {
        $where = $day . "_c";
        $wpdb->query("UPDATE {$wpdb->prefix}mp_virtualweek SET $where = '$classroom' WHERE vw_id = '$id'"); 
    }elseif ($type == "q") {
        $where = "qp_class";
        $wpdb->query("UPDATE {$wpdb->prefix}mp_questionprocess SET $where = '$classroom' WHERE qp_id = '$id'"); 
    }

	$returning = [];
	$returning['success'] = 1;
	$returning['id'] = $id;
	$returning['day'] = $day;
	$returning['classroom'] = $classroom;
	echo json_encode($returning);

}
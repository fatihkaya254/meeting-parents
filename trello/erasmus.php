<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once $path . "wp-load.php";


if (isset($_POST['exchange']) && $_POST['exchange'] == '1') {
    global $wpdb;
	$buyer = $_POST['buyer'];
	$good = $_POST['good'];
	$hangiSaat = $_POST['hangisaat'];

    $exGood = explode("|", $good);
    $shop = $exGood[0]; //lr or qp
    $good = $exGood[1];
    $exBuyer = explode("-", $buyer);
    $teaid = $exBuyer[0];
    $day = $exBuyer[1];
    $vwid = $exBuyer[2];
    $hangiDers = $exBuyer[3];

    //$wpdb->query("UPDATE {$wpdb->prefix}mp_virtualweek SET $day = '0' WHERE vw_id = '$vwid'"); 
    if ($shop == "lr") {
      //  $wpdb->query("UPDATE {$wpdb->prefix}mp_virtualweek SET $day = '$good' WHERE vw_id = '$vwid'");
        $buyer = "UPDATE {$wpdb->prefix}mp_virtualweek SET $day = '$good' WHERE vw_id = '$vwid'";
    }    
    elseif ($shop == "qp") {
        $qpHour = $exGood[2];
        //$wpdb->query("DELETE FROM {$wpdb->prefix}mp_questionprocess WHERE qp_student_id = '$good' AND qp_day = '$day' AND qp_hour ='$qpHour'"); 
        //$wpdb->query("UPDATE {$wpdb->prefix}mp_questionprocess SET qp_student_id = '$good' WHERE qp_teacher_id = '$teaid' AND qp_day = '$day' AND qp_hour ='$hangiDers$hangiSaat'"); 
        $buyer ="DELETE FROM {$wpdb->prefix}mp_questionprocess WHERE qp_student_id = '$good' AND qp_day = '$day' AND qp_hour ='$qpHour'";
        $good ="UPDATE {$wpdb->prefix}mp_questionprocess SET qp_student_id = '$good' WHERE qp_teacher_id = '$teaid' AND qp_day = '$day' AND qp_hour ='$hangiDers$hangiSaat'";
    }
	$returning = [];
	$returning['success'] = 1;
	$returning['id'] = $id;
	$returning['buyer'] = $buyer;
	$returning['good'] = $good;
	echo json_encode($returning);

}
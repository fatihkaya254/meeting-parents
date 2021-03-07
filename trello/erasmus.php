<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once $path . "wp-load.php";


if (isset($_POST['exchange']) && $_POST['exchange'] == '1') {
    global $wpdb;
    $buyer = $_POST['buyer'];
    $hangiSaat = $_POST['hangisaat'];
    $classroom = $_POST['classroom'];

    $good = $_POST['good'];
    $exGood = explode("|", $good);
    $shop = $exGood[0]; //lr or qp
    $good = $exGood[1];
    $goodS = explode(" ", $good);
    $gName = $goodS[3];
    $gID = $goodS[2];
    $exBuyer = explode("-", $buyer);
    $teaid = $exBuyer[0];
    $day = $exBuyer[1];
    $vwid = $exBuyer[2];
    $hangiDers = $exBuyer[3];
    $hour = $hangiDers;
    $student = $good;
    $newClass = "";
    $wpdb->query("UPDATE {$wpdb->prefix}mp_virtualweek SET $day = '0' WHERE vw_id = '$vwid'");
    if ($shop == "lr") {
        $student =  $gID;
        $wpdb->query("UPDATE {$wpdb->prefix}mp_virtualweek SET $day = '$good' WHERE vw_id = '$vwid'");
        $buyer = "UPDATE {$wpdb->prefix}mp_virtualweek SET $day = '$good' WHERE vw_id = '$vwid'";
        $wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE vw_id = '$vwid';", ARRAY_A);
        foreach ($wholeexams as $we) {
            $newClass = $we[$day.'_c'];
        }
    } elseif ($shop == "qp") {
        $hour .= $hangiSaat;
        $student = $good;
        $wpdb->query("DELETE FROM {$wpdb->prefix}mp_questionprocess WHERE qp_teacher_id = '$teaid' AND qp_day = '$day' AND qp_hour ='$hangiDers$hangiSaat'");
        $wpdb->query("INSERT INTO {$wpdb->prefix}mp_questionprocess (qp_student_id, qp_teacher_id, qp_day, qp_hour, qp_class ) VALUES('$good','$teaid','$day','$hangiDers$hangiSaat','$classroom')");
        $wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess WHERE AND qp_student_id = '$good'  AND qp_teacher_id = '$teaid'  AND qp_day = '$day' AND qp_hour = '$hangiDers$hangiSaat' ;", ARRAY_A);
        foreach ($wholeexams as $we) {
            $newClass = $we['qp_class'];
        }
    } else {
        $wpdb->query("DELETE FROM {$wpdb->prefix}mp_questionprocess WHERE qp_teacher_id = '$teaid' AND qp_day = '$day' AND qp_hour ='$hangiDers$hangiSaat'");
    }
    if ($gID == "G") {
        $student = $gName;
    }

    $returning = [];
    $returning['success'] = 1;
    $returning['vwid'] = $vwid;
    $returning['shop'] = $shop;
    $returning['newClass'] = $newClass;
    $returning['teacher'] = $teaid;
    $returning['day'] = $day;
    $returning['hour'] = $hour;
    $returning['student'] = $student;
    echo json_encode($returning);
}

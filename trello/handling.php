<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once $path . "wp-load.php";


if (isset($_POST['handling']) && $_POST['handling'] == '1') {
    global $wpdb;
    $goodK = $_POST['knowledge'];
    $buyer = $_POST['where'];
    $day = $_POST['day'];
    $whatCanIDo = $_POST['whatCanIDo'];
    $popHour = $_POST['popHour'];
    $popNew = $_POST['popNew'];
    $popBranch = $_POST['popBranch'];
    $changeBranchId = $_POST['changeBranchId'];
    $name = $_POST['name'];
    $teacher = $_POST['teacher'];

    $yeni =  ' ' . $popBranch . ' ' . $popNew . ' ' . $name;
    $exGood = explode("|", $goodK);
    $shop = $exGood[0]; //lr or qp
    $good = $exGood[1];
    $goodS = explode(" ", $good);
    $gName = $goodS[3];
    $gID = $goodS[2];
    $emptyLi = "";

    if ($whatCanIDo == "delete") {
        if ($shop == "lr") {
            $wpdb->query("UPDATE {$wpdb->prefix}mp_virtualweek SET $day = '0' WHERE vw_id = '$buyer'");
        } elseif ($shop == "qp") {
            $wpdb->query("DELETE FROM {$wpdb->prefix}mp_questionprocess WHERE qp_id = '$buyer'");
        }
    } else if ($whatCanIDo == "change") {
        if ($shop == "lr") {
            $wpdb->query("UPDATE {$wpdb->prefix}mp_virtualweek SET $day = '$yeni' WHERE vw_id = '$buyer'");
        } elseif ($shop == "qp") {
            if ($changeBranchId == 0) {
                $wpdb->query("UPDATE {$wpdb->prefix}mp_questionprocess SET qp_student_id = '$popNew' WHERE qp_id = '$buyer'");
            } else {
                $wpdb->query("UPDATE {$wpdb->prefix}mp_questionprocess SET qp_student_id = '$popNew', qp_branch = '$popBranch' WHERE qp_id = '$buyer'");
            }
        }
    } elseif ($whatCanIDo == "lr") {
        $wpdb->query("UPDATE {$wpdb->prefix}mp_virtualweek SET $day = '$yeni' WHERE vw_id = '$buyer'");
    } elseif ($whatCanIDo == "qp-1") {
        $popHour = $popHour."1";
        $wpdb->query("INSERT INTO {$wpdb->prefix}mp_questionprocess (`qp_id`, `qp_day`, `qp_student_id`, `qp_branch`, `qp_hour`, `qp_teacher_id`, `qp_class`) VALUES (NULL, '$day', '$popNew', '$popBranch', '$popHour', '$teacher', 'N404')");
        $wholequestion = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess WHERE qp_teacher_id = '$teacher' AND qp_day = '$day' AND qp_hour = '$qphour' AND qp_student_id = '$popNew';", ARRAY_A);
        foreach ($wholequestion as $wq) {
            $buyer = $wq['qp_id'];
        }
    } elseif ($whatCanIDo == "qp-2") {
        $popHour = $popHour."2";
        $wpdb->query("INSERT INTO {$wpdb->prefix}mp_questionprocess (`qp_id`, `qp_day`, `qp_student_id`, `qp_branch`, `qp_hour`, `qp_teacher_id`, `qp_class`) VALUES (NULL, '$day', '$popNew', '$popBranch', '$popHour', '$teacher', 'N404')");
        $wholequestion = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess WHERE qp_teacher_id = '$teacher' AND qp_day = '$day' AND qp_hour = '$qphour' AND qp_student_id = '$popNew';", ARRAY_A);
        foreach ($wholequestion as $wq) {
            $buyer = $wq['qp_id'];
        }
    }
    
    $returning = [];
    $returning['success'] = 1;
    $returning['neekle'] = $neekle;
    $returning['goodK'] = $goodK;
    $returning['buyer'] = $buyer;
    $returning['changeBranchId'] = $changeBranchId;
    $returning['day'] = $day;
    $returning['shop'] = $shop;
    $returning['whatCanIDo'] = $whatCanIDo;
    $returning['gID'] = $popNew;
    $returning['name'] = $name;
    $returning['branch'] = $popBranch;
    echo json_encode($returning);
}

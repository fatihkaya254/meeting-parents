<?php
require_once dirname(__FILE__, 2) . '/teacherspage/lrGet.php';
require_once dirname(__FILE__, 2) . '/teacherspage/timeTime.php';

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once $path . "wp-load.php";

if (isset($_POST['getSMS']) && $_POST['getSMS'] == "1") {
    global $wpdb;
    $tT = new timeTime;
    $hours = $tT->getLesssonHours('');
    $teacherid = 0;
    $stuid = 0;
    $tarih = $_POST['tarih'];
    $bugun = $_POST['bugun'];
    $content = "";
    $branchID = 0;
    $groupStudents = array(0, 0, 0, 0, 0, 0);
    $wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek, {$wpdb->prefix}mp_teacher WHERE {$wpdb->prefix}mp_virtualweek.teacher_id = {$wpdb->prefix}mp_teacher.teacher_id ", ARRAY_A);
    foreach ($wholeexams as $we) {
        if ($we[$bugun] == "0") {
            continue;
        }
        $teacherid = $we['teacher_id'];
        $getir = new lrGet();
        $vwname = $we['vw_name'];
        $vwid = $we['vw_id'];
        $vwnamear = explode(" - ", $vwname);
        $hangiders = $vwnamear[1];
        $hangidersar = explode(".", $hangiders);
        $hangisaat = $hangidersar[0];
        $lessoninfo = $we[$bugun];
        $lessonExp = explode(' ', $lessoninfo);
        $lessonBranch = $lessonExp[1];
        $recordID = 0;
        if (isset($lessonExp[2])) {
            $studentID = $lessonExp[2];
        }
        $studentName = "";
        for ($dizi = 3; $dizi < count($lessonExp); $dizi++) {
            $studentName .= $lessonExp[$dizi] . ' ';
        }
        if ($studentID == "G") {
            $groupStudents = $getir->getGroupStudents($studentName);
        }
        $smsOk = 0;
        $wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE teacher_id = '$teacherid' AND hangiders = '$hangisaat' AND student_id = '$studentID' AND date_info = '$tarih' ORDER BY date_info ASC LIMIT 0,1;", ARRAY_A);
        foreach ($wholerecords as $wr) {
            $recordID = $wr['lr_id'];
            $smsOk = $wr['sms_ok'];
        }
        $class = 'sms-content';

        if ($studentID == "G") {
            for ($ogr = 0; $ogr < 6 ; $ogr++) {
                $gr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE teacher_id = '$teacherid' AND hangiders = '$hangisaat' AND student_id = '$groupStudents[$ogr]' AND date_info = '$tarih' ORDER BY date_info ASC LIMIT 0,1;", ARRAY_A);
                foreach ($gr as $ggr) {
                    $recordID = $ggr['lr_id'];
                    $smsOk = $ggr['sms_ok'];

                    if ($smsOk) {
                        $class = 'sms-content ready';
                    }
                    $content .= '<div class="' . $class . '">';
                    $content .= '<input type="hidden" id="recordID' . $vwid . $ogr .'" name="recordID' . $vwid . $ogr . '" value="' . $recordID . '">';
                    $content .= $hours[$hangisaat] . ' G ' . $we['name'] . ' ' . $we['surname'];
                    $content .= '</div>';
                }
            }
        } else {
            $content .= '<div class="' . $class . '">';
            $content .= '<input type="hidden" id="recordID' . $vwid . '" name="recordID' . $vwid . '" value="' . $recordID . '">';
            $content .= $hours[$hangisaat] . ' ' . $we['name'] . ' ' . $we['surname'];
            $content .= '</div>';

            if ($smsOk) {
                $class = 'sms-content ready';
            }
        }
    }
    $return = [];
    $return['success'] = 1;
    $return['content'] = $content;

    echo json_encode($return);
}

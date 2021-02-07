<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . "wp-load.php");
require_once dirname(__FILE__, 2) . '/teacherspage/timeTime.php';

if (isset($_POST['generate']) && $_POST['generate'] == '1') {
    $returning = [];
    $tT = new timeTime;
    $time = $tT->getCurrentTime('');
    $date = $tT->getCurrentDate('');
    $bugun = $tT->getCurrentDay('');
    $smsText = '';
    $lrid = 0;
    $kontrol = 0;
    $number = 'Veli Numarası Bulunamadı';
    $wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_lesson_records.date_info = '$date' AND {$wpdb->prefix}mp_lesson_records.sms_ok = '1' AND {$wpdb->prefix}mp_lesson_records.student_id = {$wpdb->prefix}mp_student.student_id;", ARRAY_A);
    foreach ($wholerecords as $we) {
        $nextHomework = $we['next_homework'];
        $lessonStatus =  $we['lesson_status'];
        $homeworkStatus =  $we['homework_status'];
        $hangiders = $we['hangiders'];
        $hours = $tT->getLesssonHours($hours);
        $hour = $hours[$hangiders];
        $name = $we['name'] . ' ' . $we['surname'];
        $stuid = $we['student_id'];
        $lrid = $we['lr_id'];
        $smsText = $name . ", " . $hour . ", ";
        if ($homeworkStatus == "tam") {
            $smsText .= "konu: " . $lessonStatus . ". Önceki derste verilen ödev tam yapıldı. Bir sonraki ödev: " . $nextHomework;
        } else if ($homeworkStatus == "eksik") {
            $smsText .= "konu: " . $lessonStatus . ". Önceki derste verilen ödev eksik/özensiz yapıldı. Bir sonraki ödev: " . $nextHomework;
        } else if ($homeworkStatus == "yok") {
            $smsText .= "konu: " . $lessonStatus . ". Önceki derste verilen ödev yapılmadı. Bir sonraki ödev: " . $nextHomework;
        } else if ($homeworkStatus == "verilmedi") {
            $smsText .= "konu: " . $lessonStatus . ". Bir sonraki ödev: " . $nextHomework;
        } else if ($homeworkStatus == "katilmadi") {
            $smsText .= "Öğrenci derse katılmadı. Bir sonraki ödev: " . $nextHomework;
        }
        $smsText .= " İşleyen Zihinler ";

        $number = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_smsnumber WHERE student_id = '$stuid';", ARRAY_A);
        foreach ($number as $wn) {
            $number = $wn['sms_number'];
            $wpdb->query("INSERT INTO `{$wpdb->prefix}mp_sms` (`sms_id`, `parent_num`, `sms_text`, `is_sent`, `student_id`, `lr_id`, `date_info`) VALUES (NULL, '$number', '$smsText', '0', '$stuid', '$lrid', '$date')");

            $smss = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_sms WHERE lr_id = '$lrid';", ARRAY_A);
            foreach ($smss as $ws) {
                $smsText = $ws['sms_text'];
                $smsid = $ws['sms_id'];
            }
        }

        $returning[$kontrol] = ["sms" => $smsText, "id" => $lrid, "number" => $number, "smsid" => $smsid];
        $kontrol++;
    }

    $returning['success'] = 1;
    $returning['kontrol'] = $kontrol;
    echo json_encode($returning);
}

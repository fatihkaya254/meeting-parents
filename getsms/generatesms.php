<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);

require_once($path."wp-load.php");


$saatler = array('11','12','13','14','15','16','17','18','19');

date_default_timezone_set('Europe/Istanbul');
$saaat=date('H:i:s');
$t=date('d-m-Y');

$today = date("D",strtotime($t));

$bugun = "<br>bugun<br>";
$tarih = date("Y-m-d",strtotime($t));


if ($today == "Mon") {
    $bugun = "pts";
    ?> <div> <h4><?php echo "Pazartesi"."<br>";; ?></h4></div> <?php
    $saatler = array('11','12','13','14','15','16','17','18','19');
}
if ($today == "Tue") {
    $bugun = "sal";
    ?> <div> <h4><?php echo "Salı"."<br>"; ?></h4></div> <?php
    $saatler = array('11','12','13','14','15','16','17','18','19');
}

if ($today == "Wed") {
    $bugun = "car";
    ?> <div> <h4><?php echo "Çarşamba"."<br>"; ?></h4></div> <?php
    $saatler = array('11','12','13','14','15','16','17','18','19');
}

if ($today == "Thu") {
    $bugun = "per";
    ?> <div> <h4><?php echo "Perşembe"."<br>"; ?></h4></div> <?php
    $saatler = array('11','12','13','14','15','16','17','18','19');
}

if ($today == "Fri") {
    $bugun = "cum";
    ?> <div> <h4><?php echo "Cuma"."<br>"; ?></h4></div> <?php
    $saatler = array('11','12','13','14','15','16','17','18','19');
}

if ($today == "Sat") {
    $bugun = "cts";
    ?> <div> <h4><?php echo "Cumartesi"."<br>"; ?></h4></div> <?php
    $saatler = array('9','10','11','12','13','14','15','16','17');
}

if ($today == "Sun") {
    $bugun = "paz";
    ?> <div> <h4><?php echo "Pazar"."<br>"; ?></h4></div> <?php
    $saatler = array('9','10','11','12','13','14','15','16','17');
}


$i = 1;
if (isset($_POST['generate']) && $_POST['generate'] == 1) {
    $getlr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records, {$wpdb->prefix}mp_student, {$wpdb->prefix}mp_smsnumber WHERE {$wpdb->prefix}mp_lesson_records.student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_lesson_records.`date_info` = '$tarih' AND {$wpdb->prefix}mp_student.student_id = {$wpdb->prefix}mp_smsnumber.student_id;", ARRAY_A);
    foreach ($getlr as $glrow){
        $lrid = $glrow['lr_id'];
        $lrstuid = $glrow['student_id'];
        $lrtopic = $glrow['lesson_status'];
        $lrhomework = $glrow['homework_status'];
        $lrnexthw = $glrow['next_homework'];
        $lrsaat = $glrow['hangiders'];
        $lrstuname = $glrow['name']." ".$glrow['surname'];
        $lrnumber = $glrow['sms_number'];
        $lrhomeworkst = "";
        if ($lrhomework == 'tam') {
            $lrhomeworkst = "Önceki derste verilen ödev tam yapıldı";
        }elseif ($lrhomework == 'eksik') {
            $lrhomeworkst = "Önceki derste verilen ödev eksik/özensiz yapıldı";
        }elseif ($lrhomework == 'yok') {
            $lrhomeworkst = "Önceki derste verilen ödev yapılmadı";
        }

        $smstext = $lrstuname.", ";
        $smstext .= $saatler[$lrsaat-1].":00".", ";
        $smstext .= "Konu: ".$lrtopic.", ";
        $smstext .= $lrhomeworkst.". ";
        if ($lrnexthw != '' && $lrnexthw != ' ' && $lrnexthw != 'verilmedi' && $lrnexthw != 'verilmedi.' && $lrnexthw != 'yok' && $lrnexthw != 'yok.') {
            $smstext .= "Bir sonraki ödev: ".$lrnexthw;
        }       
        $smstext .= " İşleyen Zihinler";

        $i++;
        if ($lrtopic != '0') {
            $wpdb -> query ("
                INSERT INTO `{$wpdb->prefix}mp_sms` (`sms_id`, `parent_num`, `sms_text`, `is_sent`, `student_id`, `lr_id`) VALUES (NULL, '$lrnumber', '$smstext', '0', '$lrstuid', '$lrid')
                ");
        }

    }
}
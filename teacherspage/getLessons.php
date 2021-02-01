<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once $path . "wp-load.php";
require_once plugin_dir_path(__FILE__) . "lrGet.php";
$startLessonURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/startLesson.php/';
$startGroupLessonURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/startGroupLesson.php/';
$radioSetURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/radioSet.php/';
$setLessonStatusURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/setLessonStatus.php/';
$setNextHomeworkURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/setNextHomework.php/';
$hours = array("11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00");

if (isset($_POST['getLessons']) && $_POST['getLessons'] == '1') {

   

    global $wpdb;
    $processLR = '';
    $content = '';
    $teacherid = $_POST['teacher'];
    $wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE teacher_id = '$teacherid';", ARRAY_A);
    foreach ($wholeexams as $we) {
        $getir = new lrGet();
        $rI = array();
        $rI['cssClassL'] = 'lesson_cont l';
        $rI['cssClassR'] = 'lesson_cont r';
        $rI['cssClasslist'] = '';
        $rI['recordID'] = 0;
        $rI['lessonTopic'] = "";
        $rI['nextHomework'] = "";
        $rI['homeworkStatus'] = "";

        $gRI = array();
        $gRI['cssClassL'] = 'lesson_cont l';
        $gRI['cssClassR'] = 'lesson_cont r';
        $gRI['cssClasslist'] = '';
        $gRI['recordID'] = array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
        $gRI['lessonTopic'] = array(0 => "", 1 => "", 2 => "", 3 => "", 4 => "", 5 => "");
        $gRI['nextHomework'] = array(0 => "", 1 => "", 2 => "", 3 => "", 4 => "", 5 => "");
        $gRI['homeworkStatus'] = array(0 => "", 1 => "", 2 => "", 3 => "", 4 => "", 5 => "");

        $branchID = 0;
        $vwname = $we['vw_name'];
        $vwnamear = explode(" - ", $vwname);
        $hangiders = $vwnamear[1];

        $hangidersar = explode(".", $hangiders);
        $hangisaat = $hangidersar[0];
        $lessoninfo = $we['sal'];
        $lessonExp = explode(' ', $lessoninfo);
        $lessonBranch = $lessonExp[1];
        $url = $startLessonURL;
        if (isset($lessonExp[2])) {
            $studentID = $lessonExp[2];
        }

        if ($lessoninfo == "0") {
            continue;
        } else {

            $branchID = $getir->getBranchID($lessonBranch); //branş ID bilgisi alınır

            $studentName = "";
            for ($dizi = 3; $dizi < count($lessonExp); $dizi++) {
                $studentName .= $lessonExp[$dizi] . ' ';
            }
            if ($studentID != 'G') {

                $rI = $getir->getRI($teacherid, $studentID, '2021.01.10', $rI); //ders bilgileri alınır

                $exhomework = $getir->getExHomework('2021.01.09', $teacherid, $studentID); // bir önceki ödev bilgisi alınır

                $processLR .= '<li class="' . $rI['cssClasslist'] . '">'.$hours[$hangisaat].'</li>';
                $content .= '<div class="lesson_cont">

					<div class="' . $rI['cssClassR'] . ' ' . $we['vw_id'] . 'a">
					<h1>'.$hours[$hangisaat].'</h1>
					<h2>' . $studentName . '</h2>
					<p>Bir Önceki Ödev: ' . $exhomework . '</p>
					<input type="submit" id="gola" name="gonder" value="Başlat" onclick="startLesson(\'' . $url . '\',\'' . $we['vw_id'] . '\')">
					<input type="hidden" id="branch' . $we['vw_id'] . '" name="branch' . $we['vw_id'] . '" value="' . $branchID . '">
					<input type="hidden" id="stuid' . $we['vw_id'] . '" name="stuid' . $we['vw_id'] . '" value="' . $studentID . '">
					<input type="hidden" id="teaid' . $we['vw_id'] . '" name="teaid' . $we['vw_id'] . '" value="' . $teacherid . '">
					<input type="hidden" id="hangisaat' . $we['vw_id'] . '" name="hangisaat' . $we['vw_id'] . '" value="' . $hangisaat . '">
					<input type="hidden" id="recordID' . $we['vw_id'] . '" name="recordID' . $we['vw_id'] . '" value="' . $rI['recordID'] . '">
					<input type="hidden" id="studentName' . $we['vw_id'] . '" name="studentName' . $we['vw_id'] . '" value="' . $studentName . '">

					</div>

					<div id="a" class="' . $rI['cssClassL'] . ' ' . $we['vw_id'] . 'b">
					<label>İşlenen Konu </label>
					<input type="text" onfocusout="setLessonStatus(\'' . $setLessonStatusURL . '\',\'' . $we['vw_id'] . '\')" name="lessonStatus' . $we['vw_id'] . '" id="lessonStatus' . $we['vw_id'] . '" placeholder="Örn. Permütasyon ve Kombinasyon" value = "' . $rI['lessonTopic'] . '">
					</div>';

                $content .= $getir->homeworkStatus($radioSetURL, $rI['cssClassL'], $we['vw_id'], $rI['homeworkStatus'], ''); //ödev chechboxları

                $content .= '<div class="' . $rI['cssClassL'] . ' ' . $we['vw_id'] . 'b">
					<label>Bir Sonraki Ödev</label>
					<input type="text" name="nextHomework' . $we['vw_id'] . '" id="nextHomework' . $we['vw_id'] . '" onfocusout="setNextHomework(\'' . $setNextHomeworkURL . '\',\'' . $we['vw_id'] . '\')" placeholder="Örn. Karekök 7. Ünite Tamamen Bitecek" value = "' . $rI['nextHomework'] . '">
					</div>
					</div>';
            } else if ($studentID == 'G') {

                $groupStudents = $getir->getGroupStudents($studentName);
                $gRI = $getir->getGRI($teacherid, $groupStudents, '2021.01.10', $gRI); //ders bilgileri alınır
                $url = $startGroupLessonURL; //ders başlatma urlini grup dersi başlatma urli ile değiştir
                $processLR .= '<li class="' . $gRI['cssClasslist'] . '">'.$hours[$hangisaat].'</li>';
                $content .= '<div class="lesson_cont">
					<div class="' . $gRI['cssClassR'] . ' ' . $we['vw_id'] . 'a">
					<h1>'.$hours[$hangisaat].'</h1>
					<h2>' . $studentName . '</h2>
					<p>Bir Önceki Ödev: ' . $exhomework . '</p>
					<input type="submit" id="gola" name="gonder" onclick="startLesson(\'' . $url . '\',\'' . $we['vw_id'] . '\')">
					<input type="hidden" id="branch' . $we['vw_id'] . '" name="branch' . $we['vw_id'] . '" value="' . $branchID . '">
					<input type="hidden" id="stuid' . $we['vw_id'] . '" name="stuid' . $we['vw_id'] . '" value="' . $studentID . '">
					<input type="hidden" id="teaid' . $we['vw_id'] . '" name="teaid' . $we['vw_id'] . '" value="' . $teacherid . '">
					<input type="hidden" id="hangisaat' . $we['vw_id'] . '" name="hangisaat' . $we['vw_id'] . '" value="' . $hangidersar[0] . '">
					<input type="hidden" id="recordID' . $we['vw_id'] . '" name="hangisaat' . $we['vw_id'] . '" value="' . $rI['recordID'] . '">
					<input type="hidden" id="studentName' . $we['vw_id'] . '" name="studentName' . $we['vw_id'] . '" value="' . $studentName . '">

					</div>

					<div id="a" class="' . $gRI['cssClassL'] . ' ' . $we['vw_id'] . 'b">
					<label>İşlenen Konu </label>
					<input type="text" onfocusout="setLessonStatus(\'' . $setLessonStatusURL . '\',\'' . $we['vw_id'] . '\')" name="lessonStatus' . $we['vw_id'] . '" id="lessonStatus' . $we['vw_id'] . '" placeholder="Örn. Permütasyon ve Kombinasyon" value = "' . $rI['lessonTopic'] . '">
					</div>';

                $content .= '<div class="' . $gRI['cssClassL'] . ' ' . $we['vw_id'] . 'b">
					<label>Bir Sonraki Ödev</label>
					<input type="text" name="nextHomework' . $we['vw_id'] . '" id="nextHomework' . $we['vw_id'] . '" onfocusout="setNextHomework(\'' . $setNextHomeworkURL . '\',\'' . $we['vw_id'] . '\')" placeholder="Örn. Karekök 7. Ünite Tamamen Bitecek" value = "' . $rI['nextHomework'] . '">
					';
                for ($i = 0; $i < 6; $i++) {
                    $content .= $getir->homeworkStatus($radioSetURL, $gRI['cssClassL'], $we['vw_id'], $gRI['homeworkStatus'][$i], ''); //ödev chechboxları
                }
                $content .= '</div></div>';

            }
        }
    }
    $returning = [];
    $returning['success'] = 1;
    $returning['content'] = $content;
    $returning['processLR'] = $processLR;
    echo json_encode($returning);
}

<?php
require_once dirname(__FILE__, 2) . '/teacherspage/timeTime.php';

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once $path . "wp-load.php";
require_once plugin_dir_path(__FILE__) . "lrGet.php";
$startQuestionProcessURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/startQuestionProcess.php/';
$setQPURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/setQP.php/';
$finishURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/finish.php/';
$finishGURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/finishGroup.php/';
$startLessonURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/startLesson.php/';
$startGroupLessonURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/startGroupLesson.php/';
$radioSetURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/radioSet.php/';
$setLessonStatusURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/setLessonStatus.php/';
$setNextHomeworkURL = site_url() . '/wp-content/plugins/meeting-parents/teacherspage/setNextHomework.php/';
$hours;

if (isset($_POST['getLessons']) && $_POST['getLessons'] == '1') {
    $tT = new timeTime;
    $time = $tT->getCurrentTime('');
    $date = $tT->getCurrentDate('');
    $bugun = $tT->getCurrentDay('');
    $hours = $tT->getLesssonHours('');
    $kacinciID = 0;
    $first = 0;
    $last = 0;
    $exhomework = '';
    $smsText = '';
    global $wpdb;
    $processLR = '';
    $content = '';
    $teacherid = $_POST['teacher'];
    $wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE teacher_id = '$teacherid';", ARRAY_A);
    foreach ($wholeexams as $we) {
        $getir = new lrGet();
        $kacinciID++;

        if ($kacinciID == 1) {
            $first = $we['vw_id'];
        }
        if ($kacinciID == 9) {
            $last = $we['vw_id'];
        }
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
        $gRI['names'] = array(0 => "", 1 => "", 2 => "", 3 => "", 4 => "", 5 => "");

        $branchID = 0;
        $vwname = $we['vw_name'];
        $vwnamear = explode(" - ", $vwname);
        $hangiders = $vwnamear[1];

        $hangidersar = explode(".", $hangiders);
        $hangisaat = $hangidersar[0];
        $lessoninfo = $we[$bugun];
        $lessonExp = explode(' ', $lessoninfo);
        $lessonBranch = $lessonExp[1];
        $url = $startLessonURL;
        if (isset($lessonExp[2])) {
            $studentID = $lessonExp[2];
        }

        if ($lessoninfo == "0") {
            $content .= $getir->getLessonProcess($date, $bugun, $hangisaat . '1', $hours[$hangisaat], '00', $teacherid, '', $startQuestionProcessURL, $setQPURL);
            $content .= $getir->getLessonProcess($date, $bugun, $hangisaat . '2', $hours[$hangisaat], '25', $teacherid, '', $startQuestionProcessURL, $setQPURL);
        } else {

            $branchID = $getir->getBranchID($lessonBranch); //branş ID bilgisi alınır

            $studentName = "";
            for ($dizi = 3; $dizi < count($lessonExp); $dizi++) {
                $studentName .= $lessonExp[$dizi] . ' ';
            }
            if ($studentID != 'G') {

                $rI = $getir->getRI($teacherid, $studentID, $hangisaat, $date, $rI); //ders bilgileri alınır

                $exhomework = $getir->getExHomework($date, $teacherid, $studentID); // bir önceki ödev bilgisi alınır

                $baslat = "";
                $bitir = "display: none;";
                $duzenle = "display: none; color: #1B3BF2; background-color: #FEC8CF;";
                $kapat = "display: none; color: #1B3BF2; background-color: #FEC8CF;";
                if ($rI['cssClassR'] == 'lesson_cont ra') {
                    $baslat = "display: none;";
                    $duzenle = "display: none;";
                    $bitir = "";
                } elseif ($rI['cssClassR'] == 'lesson_cont rk') {
                    $baslat = "display: none;";
                    $bitir = "display: none; color: ";
                  //  $duzenle = "color: #1B3BF2; background-color: #FEC8CF;";
                }
                // $processLR .= '<li class="' . $rI['cssClasslist'] . '">' . $hours[$hangisaat] . '</li>';
                $content .= '<div class="lesson_cont">

					<div class="' . $rI['cssClassR'] . ' ' . $we['vw_id'] . 'a">
					<h1 id="hour' . $we['vw_id'] . '">' . $hours[$hangisaat] . '</h1>
					<h2 id="name' . $we['vw_id'] . '">' . $studentName . '</h2>
					<p>Bir Önceki Ödev: ' . $exhomework . '</p>
					<p class="sms" id="sms' . $we['vw_id'] . '"></p>
                    <input style="' . $kapat . '" type="submit" id="kapat' . $we['vw_id'] . '" name="kapat' . $we['vw_id'] . '" value="Düzenlemeyi Bitir" onclick="closeChange(\'' . $we['vw_id'] . '\')">
					<input style="' . $baslat . '" type="submit" id="baslat' . $we['vw_id'] . '" name="baslat' . $we['vw_id'] . '" value="Başlat" onclick="startLesson(\'' . $url . '\',\'' . $we['vw_id'] . '\')">
					<input style="' . $bitir . '" type="submit" id="bitir' . $we['vw_id'] . '" name="bitir' . $we['vw_id'] . '" value="SMS\'i Onayla ve Bitir" onclick="finishLesson(\'' . $finishURL . '\',\'' . $we['vw_id'] . '\' ,\'\')">
					<input style="' . $duzenle . '" type="submit" id="duzenle' . $we['vw_id'] . '" name="duzenle' . $we['vw_id'] . '" value="Düzenle" onclick="changeStatus(\'' . $we['vw_id'] . '\')">
					<input type="hidden" id="branch' . $we['vw_id'] . '" name="branch' . $we['vw_id'] . '" value="' . $branchID . '">
					<input type="hidden" id="stuid' . $we['vw_id'] . '" name="stuid' . $we['vw_id'] . '" value="' . $studentID . '">
					<input type="hidden" id="teaid' . $we['vw_id'] . '" name="teaid' . $we['vw_id'] . '" value="' . $teacherid . '">
					<input type="hidden" id="hangisaat' . $we['vw_id'] . '" name="hangisaat' . $we['vw_id'] . '" value="' . $hangisaat . '">
					<input type="hidden" id="recordID' . $we['vw_id'] . '" name="recordID' . $we['vw_id'] . '" value="' . $rI['recordID'] . '">
					<input type="hidden" id="studentName' . $we['vw_id'] . '" name="studentName' . $we['vw_id'] . '" value="' . $studentName . '">

					</div>

					<div id="a" class="' . $rI['cssClassL'] . ' ' . $we['vw_id'] . 'b">
					<label>İşlenen Konu </label>
					<input type="text" onfocusout="setLessonStatus(\'' . $setLessonStatusURL . '\',\'' . $we['vw_id'] . '\',\' \')" name="lessonStatus' . $we['vw_id'] . '" id="lessonStatus' . $we['vw_id'] . '" placeholder="Örn. Permütasyon ve Kombinasyon" value = "' . $rI['lessonTopic'] . '">
					</div>';

                $content .= $getir->homeworkStatus($radioSetURL, $rI['cssClassL'], $we['vw_id'], $rI['homeworkStatus'], ''); //ödev chechboxları

                $content .= '<div class="' . $rI['cssClassL'] . ' ' . $we['vw_id'] . 'b">
					<label>Bir Sonraki Ödev</label>
					<input type="text" name="nextHomework' . $we['vw_id'] . '" id="nextHomework' . $we['vw_id'] . '" onfocusout="setNextHomework(\'' . $setNextHomeworkURL . '\',\'' . $we['vw_id'] . '\',\' \')" placeholder="Örn. Karekök 7. Ünite Tamamen Bitecek" value = "' . $rI['nextHomework'] . '">
					</div>
					</div>';
            } else if ($studentID == 'G') {

                $groupStudents = $getir->getGroupStudents($studentName);

                for ($exhomgr = 0; $exhomgr < 6; $exhomgr++) {
                    if ($groupStudents[$exhomgr] == 0) {
                        continue;
                    }

                    $exhomework = $getir->getExHomework($date, $teacherid, $groupStudents[$exhomgr]); // bir önceki ödev bilgisi alınır
                }

                for ($gsg = 0; $gsg < 6; $gsg++) {
                    $gRI['names'][$gsg] = $getir->getStudentNames($groupStudents[$gsg]);
                }
                $gRI = $getir->getGRI($teacherid, $groupStudents, $hangisaat, $date, $gRI); //ders bilgileri alınır

                $homework = "";
                $lesson = "";
                for ($setLH = 0; $setLH < 6; $setLH++) {
                    if ($gRI['lessonTopic'][$setLH] != "") {
                        $lesson = $gRI['lessonTopic'][$setLH];
                    }
                    if ($gRI['nextHomework'][$setLH] != "") {
                        $homework = $gRI['nextHomework'][$setLH];
                    }
                }

                $url = $startGroupLessonURL; //ders başlatma urlini grup dersi başlatma urli ile değiştir
                // $processLR .= '<li class="' . $gRI['cssClasslist'] . '">' . $hours[$hangisaat] . '</li>';
                $content .= '<div class="lesson_cont">';
                $content .= '<div class="' . $gRI['cssClassR'] . ' ' . $we['vw_id'] . 'a">';
                $content .= '<h1 id="hour' . $we['vw_id'] . '">' . $hours[$hangisaat] . '</h1>';
                $content .= '<h2>' . $studentName . '</h2>';
                $content .= '<p>Bir Önceki Ödev: ' . $exhomework . '</p>';
                $content .= '<input type="hidden" id="branch' . $we['vw_id'] . '" name="branch' . $we['vw_id'] . '" value="' . $branchID . '">';
                $content .= '<input type="hidden" id="stuid' . $we['vw_id'] . '" name="stuid' . $we['vw_id'] . '" value="' . $studentID . '">';
                $content .= '<input type="hidden" id="teaid' . $we['vw_id'] . '" name="teaid' . $we['vw_id'] . '" value="' . $teacherid . '">';
                $content .= '<input type="hidden" id="hangisaat' . $we['vw_id'] . '" name="hangisaat' . $we['vw_id'] . '" value="' . $hangidersar[0] . '">';

                for ($ret = 0; $ret < 6; $ret++) {
                    if ($groupStudents[$ret] == 0) {
                        continue;
                    }

                    $content .= '<input type="hidden" id="recordID' . $we['vw_id'] . $ret . '" name="recordID' . $we['vw_id'] . $ret . '" value="' . $gRI['recordID'][$ret] . '">';
                    $content .= '<p class="sms" id="sms' . $we['vw_id'] . $ret . '"></p>';
                }
                $baslat = "";
                $bitir = "display: none;";
                $duzenle = "display: none; color: #1B3BF2; background-color: #FEC8CF;";
                $kapat = "display: none; color: #1B3BF2; background-color: #FEC8CF;";
                if ($gRI['cssClassR'] == 'lesson_cont ra') {
                    $baslat = "display: none;";
                    $bitir = "";
                    $duzenle = "display: none;";
                } elseif ($gRI['cssClassR'] == 'lesson_cont rk') {
                    $baslat = "display: none;";
                    $bitir = "display: none;";
            //        $duzenle = "color: #1B3BF2; background-color: #FEC8CF;";
                }
                $content .= '<input style="' . $kapat . '" type="submit" id="kapat' . $we['vw_id'] . '" name="kapat' . $we['vw_id'] . '" value="Düzenlemeyi Bitir" onclick="closeChange(\'' . $we['vw_id'] . '\')">';
                $content .= '<input style="' . $baslat . '" type="submit" id="baslat' . $we['vw_id'] . '" name="baslat' . $we['vw_id'] . '" value="Başlat" onclick="startLesson(\'' . $url . '\',\'' . $we['vw_id'] . '\')">';
                $content .= '<input style="' . $duzenle . '" type="submit" id="duzenle' . $we['vw_id'] . '" name="duzenle' . $we['vw_id'] . '" value="Düzenle" onclick="changeStatus(\'' . $we['vw_id'] . '\')">';
                $content .= '<input style="' . $bitir . '" type="submit" id="bitir' . $we['vw_id'] . '" name="bitir' . $we['vw_id'] . '" value="SMS\'i Onayla ve Bitir" onclick="';

                for ($btn = 0; $btn < 6; $btn++) {
                    $content .= 'finishLesson(\'' . $finishGURL . '\',\'' . $we['vw_id'] . '\',\'' . $btn . '\');';
                }

                $content .= '">';
                $content .= '<input type="hidden" id="studentName' . $we['vw_id'] . '" name="studentName' . $we['vw_id'] . '" value="' . $studentName . '">';

                $content .= '</div>';

                $content .= '<div id="a" class="' . $gRI['cssClassL'] . ' ' . $we['vw_id'] . 'b">';
                $content .= $getir->beforeSunrise($lessoninfo, $hangisaat, $teacherid, '', $we['vw_id'], site_url(), $bugun);
                $content .= '<br /><br /><label>İşlenen Konu </label>';
                $content .= '<input type="text" onfocusout="';
                for ($sett = 0; $sett < 6; $sett++) {
                    $content .= 'setLessonStatus(\'' . $setLessonStatusURL . '\',\'' . $we['vw_id'] . '\',\'' . $sett . '\');';
                }
                $content .= '" name="lessonStatus' . $we['vw_id'] . '" id="lessonStatus' . $we['vw_id'] . '" placeholder="Örn. Permütasyon ve Kombinasyon" value = "' . $lesson . '">';
                $content .= '</div>';

                $content .= '<div class="' . $gRI['cssClassL'] . ' ' . $we['vw_id'] . 'b">';
                $content .= '<label>Bir Sonraki Ödev</label>';
                $content .= '<input type="text" name="nextHomework' . $we['vw_id'] . '" id="nextHomework' . $we['vw_id'] . '" onfocusout="';

                for ($seth = 0; $seth < 6; $seth++) {
                    $content .= 'setNextHomework(\'' . $setNextHomeworkURL . '\',\'' . $we['vw_id'] . '\',\'' . $seth . '\');';
                }

                $content .= '" placeholder="Örn. Karekök 7. Ünite Tamamen Bitecek" value = "' . $homework . '">';
                $content .= '</div>';
                for ($i = 0; $i < 6; $i++) {
                    if ($groupStudents[$i] == 0) {
                        continue;
                    }

                    $content .= $getir->homeworkStatusG($radioSetURL, $gRI['cssClassL'], $we['vw_id'], $gRI['homeworkStatus'][$i], '', $gRI, $i); //ödev chechboxları
                }
                $content .= '</div>';


            }
        }
    }
    $content .= '<script>jQuery( document ).ready(function() {
        for (let ders = '.$first.'; ders < '.$last.'; ders++) {
            setSms(ders, "");
            for (let group = 0; group < 6; group++) {
                setSms(ders, group);

            }

        }
    });</script>';
    $returning = [];
    $returning['success'] = 1;
    $returning['content'] = $content;
    $returning['processLR'] = $processLR;
    echo json_encode($returning);
}

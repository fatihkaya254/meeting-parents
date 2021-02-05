<?php

class lrGet
{

    private $wpdb;
    public $branchID = 0;
    private $wholebranch;
    private $name;
    public $groupStudents = array(0, 0, 0, 0, 0, 0);
    public $exHomework = 'Önceki ödev bilgisi yok';
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function getBranchID($branchName): int
    {
        global $wpdb;
        $this->wholebranch = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_branch WHERE name = '$branchName';", ARRAY_A);
        foreach ($this->wholebranch as $wb) {
            $this->branchID = $wb['branch_id'];
        }
        return $this->branchID;
    }

    public function getStudentNames($studentID)
    {
        global $wpdb;
        $this->wholebranch = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$studentID';", ARRAY_A);
        foreach ($this->wholebranch as $wb) {
            $this->name = $wb['name'] . ' ' . $wb['surname'];
        }
        return $this->name;
    }

    public function getGroupStudents($groupName)
    {
        global $wpdb;
        $this->wholebranch = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group WHERE group_name = '$groupName';", ARRAY_A);
        foreach ($this->wholebranch as $wb) {
            $this->groupStudents[0] = $wb['1_student_id'];
            $this->groupStudents[1] = $wb['2_student_id'];
            $this->groupStudents[2] = $wb['3_student_id'];
            $this->groupStudents[3] = $wb['4_student_id'];
            $this->groupStudents[4] = $wb['5_student_id'];
            $this->groupStudents[5] = $wb['6_student_id'];
        }
        return $this->groupStudents;
    }

    public function getExHomework($tarih, $teacherid, $studentID)
    {
        global $wpdb;
        $this->wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE teacher_id = '$teacherid' AND student_id = '$studentID' AND date_info < '$tarih' ORDER BY date_info DESC LIMIT 0,1;", ARRAY_A);
        foreach ($this->wholerecords as $wr) {
            $this->exHomework = $wr['next_homework'];
        }
        return $this->exHomework;
    }

    public function getRI($teacherid, $studentID, $hangisaat, $dateInfo, $rI)
    {
        global $wpdb;

        $this->wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE teacher_id = '$teacherid' AND hangiders = '$hangisaat' AND student_id = '$studentID' AND date_info = '$dateInfo' ORDER BY date_info ASC LIMIT 0,1;", ARRAY_A);
        foreach ($this->wholerecords as $tr) {
            $rI['cssClassL'] = 'lesson_cont la';
            $rI['cssClassR'] = 'lesson_cont ra';
            $rI['recordID'] = $tr['lr_id'];
            $rI['cssClasslist'] = 'active';
            if ($tr['sms_ok'] == "1") {
                $rI['cssClassL'] = 'lesson_cont lk';
                $rI['cssClassR'] = 'lesson_cont rk';
            }
            if ($tr['lesson_status'] != "0") {
                $rI['lessonTopic'] = $tr['lesson_status'];
            }
            if ($tr['next_homework'] != "0") {
                $rI['nextHomework'] = $tr['next_homework'];
            }
            if ($tr['homework_status'] != "0") {
                $rI['homeworkStatus'] = $tr['homework_status'];
            }
        }
        return $rI;
    }

    public function getGRI($teacherid, $studentID, $hangisaat, $dateInfo, $gRI)
    {
        global $wpdb;

        for ($i = 0; $i < 6; $i++) {

            $this->wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE teacher_id = '$teacherid' AND hangiders = '$hangisaat' AND student_id = '$studentID[$i]' AND date_info = '$dateInfo' ORDER BY date_info ASC LIMIT 0,1;", ARRAY_A);
            foreach ($this->wholerecords as $tr) {
                $gRI['cssClassL'] = 'lesson_cont la';
                $gRI['cssClassR'] = 'lesson_cont ra';
                $gRI['cssClasslist'] = 'active';

                $gRI['recordID'][$i] = $tr['lr_id'];
                if ($tr['sms_ok'] == "1") {
                    $gRI['cssClassL'] = 'lesson_cont lk';
                    $gRI['cssClassR'] = 'lesson_cont rk';
                }
                if ($tr['lesson_status'] != "0") {
                    $gRI['lessonTopic'][$i] = $tr['lesson_status'];
                }
                if ($tr['next_homework'] != "0") {
                    $gRI['nextHomework'][$i] = $tr['next_homework'];
                }
                if ($tr['homework_status'] != "0") {
                    $gRI['homeworkStatus'][$i] = $tr['homework_status'];
                }
            }
        }

        return $gRI;

    }

    public function homeworkStatus($url, $styleClass, $vwid, $homeworkStatus, $content)
    {

        $content .= '<div class="' . $styleClass . ' ' . $vwid . 'b">';
        $content .= '<label>Önceki Derste Verilen Ödev</label><br>';
        $content .= '<label class="container">Tam Yaptı';

        if ($homeworkStatus == 'tam') {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" checked="checked" name="radiobtn' . $vwid . '" id="tam' . $vwid . '" value="tam">';
        } else {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" name="radiobtn' . $vwid . '" id="tam' . $vwid . '" value="tam">';
        }

        $content .= '<span class="checkmark"></span>';
        $content .= '</label>';
        $content .= '<label class="container">Eksik/Özensiz';

        if ($homeworkStatus == 'eksik') {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" checked="checked" id="eksik' . $vwid . '" name="radiobtn' . $vwid . '" value="eksik">';
        } else {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" name="radiobtn' . $vwid . '" id="eksik' . $vwid . '" value="eksik">';
        }

        $content .= '<span class="checkmark"></span>';
        $content .= '</label>';
        $content .= '<label class="container">Yapmadı';

        if ($homeworkStatus == 'yok') {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" checked="checked" id="yok' . $vwid . '" name="radiobtn' . $vwid . '" value="yok">';
        } else {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" name="radiobtn' . $vwid . '" id="yok' . $vwid . '" value="yok">';
        }

        $content .= '<span class="checkmark"></span>';
        $content .= '</label>';
        $content .= '<label class="container">Verilmemişti';

        if ($homeworkStatus == 'verilmedi') {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" checked="checked" id="verilmedi' . $vwid . '" name="radiobtn' . $vwid . '" value="verilmedi">';
        } else {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" name="radiobtn' . $vwid . '" id="verilmedi' . $vwid . '" value="verilmedi">';
        }

        $content .= '<span class="checkmark"></span>';
        $content .= '</label>';
        $content .= '<label class="container">Katılmadı';

        if ($homeworkStatus == 'katilmadi') {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" checked="checked" id="katilmadi' . $vwid . '" name="radiobtn' . $vwid . '" value="katilmadi">';
        } else {
            $content .= '<input type="radio" onclick="radioFunction(\'' . $url . '\',\'' . $vwid . '\')" name="radiobtn' . $vwid . '" id="katilmadi' . $vwid . '" value="katilmadi">';
        }

        $content .= '<span class="checkmark"></span>
		</label>
		</div>';

        return $content;
    }

    public function homeworkStatusG($url, $styleClass, $vwid, $homeworkStatus, $content, $gRI, $i)
    {
        // tüm butonların isimlerine ve idlerine $i ekle
        $content .= '<div class="' . $styleClass . ' ' . $vwid . 'b">';
        $content .= '<label id="name' . $vwid . $i . '">' . $gRI['names'][$i] . '</label><br>';
        //$content .= '<label name="lTG'.$vwid.$i.'" id="lTG'.$vwid.$i.'">'.$gRI['lessonTopic'][$i].'</label><br>';
        //$content .= '<label name="nHG'.$vwid.$i.'" id="nHG'.$vwid.$i.'">'.$gRI['nextHomework'][$i].'</label><br>';
        $content .= '<label class="container">Tam Yaptı';

        if ($homeworkStatus == tam) {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" checked="checked" name="radiobtn' . $vwid . $i . '" id="tam' . $vwid . $i . '" value="tam">';
        } else {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" name="radiobtn' . $vwid . $i . '" id="tam' . $vwid . $i . '" value="tam">';
        }

        $content .= '<span class="checkmark"></span>';
        $content .= '</label>';
        $content .= '<label class="container">Eksik/Özensiz';

        if ($homeworkStatus == eksik) {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" checked="checked" id="eksik' . $vwid . $i . '" name="radiobtn' . $vwid . $i . '" value="eksik">';
        } else {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" name="radiobtn' . $vwid . $i . '" id="eksik' . $vwid . $i . '" value="eksik">';
        }

        $content .= '<span class="checkmark"></span>';
        $content .= '</label>';
        $content .= '<label class="container">Yapmadı';

        if ($homeworkStatus == yok) {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" checked="checked" id="yok' . $vwid . $i . '" name="radiobtn' . $vwid . $i . '" value="yok">';
        } else {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" name="radiobtn' . $vwid . $i . '" id="yok' . $vwid . $i . '" value="yok">';
        }

        $content .= '<span class="checkmark"></span>';
        $content .= '</label>';
        $content .= '<label class="container">Verilmemişti';

        if ($homeworkStatus == verilmedi) {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" checked="checked" id="verilmedi' . $vwid . $i . '" name="radiobtn' . $vwid . $i . '" value="verilmedi">';
        } else {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" name="radiobtn' . $vwid . $i . '" id="verilmedi' . $vwid . $i . '" value="verilmedi">';
        }

        $content .= '<span class="checkmark"></span>';
        $content .= '</label>';
        $content .= '<label class="container">Katılmadı';

        if ($homeworkStatus == katilmadi) {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" checked="checked" id="katilmadi' . $vwid . $i . '" name="radiobtn' . $vwid . $i . '" value="katilmadi">';
        } else {
            $content .= '<input type="radio" onclick="radioFunctionG(\'' . $url . '\',\'' . $vwid . '\',\'' . $i . '\')" name="radiobtn' . $vwid . $i . '" id="katilmadi' . $vwid . $i . '" value="katilmadi">';
        }

        $content .= '<span class="checkmark"></span>
		</label>
		</div>';

        return $content;
    }
	public function beforeSunrise($lessonInfo, $hangisaat, $teacherid, $content, $vwid, $path){
		global $wpdb;
		$hangisaat = $hangisaat -1;
		$ders = $teacherid. ' - '.$hangisaat.'. ' . Saat;
        $this->wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE vw_name = '$ders' AND sal = '$lessonInfo'", ARRAY_A);
        foreach ($this->wholerecords as $tr) {
			$content .= '<input style="color: #000; background-color: #F29BAB;" type="submit" id="esitle' . $tr['qp_id'] . '" name="esitle' . $tr['qp_id'] . '" value="Bir Önceki Dersin Bilgilerini Getir" onclick="beforeSunrise(\'' . $vwid . '\',\'' . $path . '\')">';
		}	
		return $content;
	}
    public function getLessonProcess($date, $day, $hour, $lessonhour, $min, $teacherid, $content, $url, $setQPURL)
    {
        global $wpdb;

        $this->wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$teacherid' AND {$wpdb->prefix}mp_questionprocess.qp_day = '$day' AND {$wpdb->prefix}mp_questionprocess.qp_hour = '$hour'  AND {$wpdb->prefix}mp_questionprocess.qp_student_id = {$wpdb->prefix}mp_student.student_id;", ARRAY_A);
        foreach ($this->wholerecords as $tr) {
            $lrid = 0;
            $classr = 'lesson_cont r ';
            $classl = 'lesson_cont l ';
            $studentID = $tr['student_id'];
            $this->wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_qprecords WHERE student_id = '$studentID' AND teacher_id = '$teacherid' AND hangiders = '$hour' AND date_info = '2021-01-10';", ARRAY_A);
            foreach ($this->wholeexams as $we) {
                $lrid = $we['qpr_id'];
                $classr = 'lesson_cont ra ';
                $classl = 'lesson_cont la ';
				$sass = $we['s_asked'];
				$tass = $we['t_asked'];

                if ($sass != 0 || $tass != 0) {
                    $classr = 'lesson_cont rk ';
                    $classl = 'lesson_cont lk ';
                }
            }
            $baslat = "";
            $kapat = "display: none;";
            $duzenle = "display: none; background-color: #FEC8CF; color: #1B3BF2;";
            if ($classr == 'lesson_cont ra ') {
                $baslat = "display: none;";
                $kapat = "";
            }elseif ($classr == 'lesson_cont rk ') {
                $baslat = "display: none;";
				$duzenle = "background-color: #FEC8CF; color: #1B3BF2;";
			}
            $expLessonhour = explode(':', $lessonhour);
            $lh = $expLessonhour[0] . ":" . "$min";
            $branchID = $this->getBranchID(trim($tr['qp_branch']));
            $name = $tr['name'] . ' ' . $tr['surname'];

            $content .= '<div class="lesson_cont">';
            $content .= '<div class="' . $classr . $tr['qp_id'] . 'qpa">';
            $content .= '<h1 id="qphour' . $tr['qp_id'] . '">' . $lh . '</h1>';
            $content .= '<h2 id="qpname' . $tr['qp_id'] . '">' . $name . '</h2>';
            $content .= '<p>Soru Çözümü</p>';
            $content .= '<input style="' . $duzenle . '" type="submit" id="qpduzenle' . $tr['qp_id'] . '" name="qpduzenle' . $tr['qp_id'] . '" value="Düzenle" onclick="changeQP(\'' . $tr['qp_id'] . '\')">';
            $content .= '<input style="' . $kapat . '" type="submit" id="qpkapat' . $tr['qp_id'] . '" name="qpkapat' . $tr['qp_id'] . '" value="Düzenlemeyi Bitir" onclick="closeQP(\'' . $tr['qp_id'] . '\')">';
            $content .= '<input style="' . $baslat . '" type="submit" id="qpbaslat' . $tr['qp_id'] . '" name="qpbaslat' . $tr['qp_id'] . '" value="Başlat" onclick="startQuestionProcess(\'' . $url . '\',\'' . $tr['qp_id'] . '\')">';
            $content .= '<input type="hidden" id="qpbranch' . $tr['qp_id'] . '" name="qpbranch' . $tr['qp_id'] . '" value="' . $branchID . '">';
            $content .= '<input type="hidden" id="qpstuid' . $tr['qp_id'] . '" name="qpstuid' . $tr['qp_id'] . '" value="' . $studentID . '">';
            $content .= '<input type="hidden" id="qpteaid' . $tr['qp_id'] . '" name="qpteaid' . $tr['qp_id'] . '" value="' . $teacherid . '">';
            $content .= '<input type="hidden" id="qphangisaat' . $tr['qp_id'] . '" name="qphangisaat' . $tr['qp_id'] . '" value="' . $hour . '">';
            $content .= '<input type="hidden" id="qprecordID' . $tr['qp_id'] . '" name="qprecordID' . $tr['qp_id'] . '" value="' . $lrid . '">';

            $content .= '</div>';

            $content .= '<div id="a" class="' . $classl . $tr['qp_id'] . 'qpb">';
            $content .= '<label>Öğrenci Kaç Soru Sordu? </label>';
            $content .= '<input type="text" onfocusout="setQP(\'' . $setQPURL . '\',\'' . $tr['qp_id'] . '\')" id="sque' . $tr['qp_id'] . '" placeholder="Örn. 5" value = "'.$sass.'">';
            $content .= '</div>';
            $content .= '<div id="a" class="' . $classl . $tr['qp_id'] . 'qpb">';
            $content .= '<label>Öğretmen Kaç Soru Sordu? </label>';
            $content .= '<input type="text" onfocusout="setQP(\'' . $setQPURL . '\',\'' . $tr['qp_id'] . '\')" id="tque' . $tr['qp_id'] . '" placeholder="Örn. 5" value = "'.$tass.'">';
            $content .= '</div>';
            $content .= '</div>';
        }
        return $content;
    }

}

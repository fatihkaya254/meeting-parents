<?php
$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once $path . "wp-load.php";
$content = '';
if (isset($_POST['getLessons']) && $_POST['getLessons'] == '1') {
    $day = $_POST['teacher'];
    /** sınıflar ve sınıf eşleşmeleri */
    $classRooms = [
        "B101", "B102", "B103", "B104", "B105", "B106", "B107", "G101", "G102", "G103",
        "B201", "B202", "B203", "B204", "B205", "B206", "B207", "G201", "G202", "G203",
        "B301", "B302", "B303", "B304", "B305", "B306", "B307", "G301", "G302", "G303"
    ];
    foreach ($classRooms as $room) {
        for ($i = 1; $i < 10; $i++) {
            $classMatch[$room][$day][$i] = 0;
        }
    }
    /** sınıflar ve sınıf eşleşmeleri */
    $content .= '<script>';
    ob_start();
    include(dirname(__FILE__, 2) . '/trello/classcript.js');
    $content .= ob_get_clean();
    $content .= '</script>';
    $changeClassURL = site_url() . '/wp-content/plugins/meeting-parents/trello/changeClass.php/';
    $erasmusUrl = site_url() . '/wp-content/plugins/meeting-parents/trello/erasmus.php/';
    $handlingUrl = site_url() . '/wp-content/plugins/meeting-parents/trello/handling.php/';
    $excellURL = site_url() . '/wp-content/plugins/meeting-parents/trello/exelExport.php/';
    global $wpdb;
    $groupMatch = array();
    $groupM = $wpdb->get_results("SELECT * FROM  {$wpdb->prefix}mp_group_matches, {$wpdb->prefix}mp_lesson_group, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_group_matches.group_id = {$wpdb->prefix}mp_lesson_group.group_id AND {$wpdb->prefix}mp_group_matches.student_id = {$wpdb->prefix}mp_student.student_id", ARRAY_A);
    foreach ($groupM as $gm) {
        $groupMatch[$gm['student_id']] = $gm['group_name'];
    }
    $branches = array();
    $branchT = $wpdb->get_results("SELECT * FROM  {$wpdb->prefix}mp_branch", ARRAY_A);
    foreach ($branchT as $bt) {
        $branches[$bt['branch_id']] = $bt['name'];
    }
    $students = [];
    $wholestudent = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE active = '1';", ARRAY_A);
    foreach ($wholestudent as $ws) {
        $stuidforlist = $ws['student_id'];
        $students[$stuidforlist] = $ws['name'] . ' ' . $ws['surname'];
    }

    /** HTML CONTENT */
    $content .= '<input type="hidden" id="erasmusUrl" value="' . $erasmusUrl . '">';
    $content .= '<input type="hidden" id="handlingUrl" value="' . $handlingUrl . '">';
    $content .= '<input type="hidden" id="changeClassUrl" value="' . $changeClassURL . '">';
    $content .= '<input type="hidden" id="today" value="' . $day . '">';
    $content .= '<div id="body">'; // ilk body div
    /** HTML CONTENT */
    if ($day != 'cts' && $day != 'paz') {
        $hours = array("10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00");
    } else {
        $hours = array("08:00", "9:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00");
    }
    for ($saats = 1; $saats < 10; $saats++) {
        /** HTML CONTENT */
        $content .= '<div class="jobs-list-all" id="a' . $day . $saats . '">';
        $content .= '<h2 class="jobs-list-heading-all">' .  $day . ' ' . $hours[$saats] . ' Sınıflar</h2>';
        /** HTML CONTENT */

        foreach ($classRooms as $class) {
            /** HTML CONTENT */
            $content .= '<div class="jobs-list-body-all" id="in-progress">';
            $content .= '<ul class="sort" id="ul' . $day . $saats . $class  . '">';
            $content .= $class;
            $content .= '</ul>';
            $content .= '</div>';
            /** HTML CONTENT */
        }
        /** HTML CONTENT */
        $content .= '<div class="jobs-list-footer-all"></div>';
        $content .= '</div>';
        $content .= '<div class="jobs-list-alls" id="b' . $day . $saats . '">';
        $content .= '<h2 class="jobs-list-heading-all">' . $day . ' ' . $hours[$saats] . ' Dersler</h2>';
        $content .= '<div class="jobs-list-body-all " id="in-progress">';
        $content .= '<ul class="sort" id="' . $day . $hours[$saats] . 'inspaceN404">';
        /** HTML CONTENT */
        $teachercount = 0;
        $teacherList = array();
        $teacherListB = array();
        $jgroupMatch = json_encode($groupMatch);
        $wholeteacher = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_teacher WHERE active = '1';", ARRAY_A);
        foreach ($wholeteacher as $wt) {
            $teacherListB[$wt['teacher_id']] = $wt['name'] . " " . $wt['surname'];
            $teacherList[$teachercount]['id'] = $wt['teacher_id'];
            $teacherList[$teachercount]['name'] = $wt['name'] . " " . $wt['surname'];
            $teachercount++;
        }
        for ($teachercounter = 0; $teachercounter < $teachercount; $teachercounter++) {
            $teacher = $teacherList[$teachercounter]['id'];
            $wnameFD = $teacher . " - " . $saats . ". Saat";
            $wholelesson = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE vw_name = '$wnameFD';", ARRAY_A);
            foreach ($wholelesson as $we) {
                $studentName = " ";
                $cid = $we['vw_id'];
                $pcid = $we['vw_id'];
                $ctype = 'l';
                $value = '0';
                $valuevw = '0';
                $studentID = ' ';
                $croom = $we[$day . '_c'];
                $class = 'job-block';
                $classLi = 'less';
                $classname = 'job-name-block';
                $classinfo = 'job-info-block';
                $vwname = $we['vw_name'];
                $vwid = $we['vw_id'];
                $vwnamear = explode(" - ", $vwname);
                $hangiders = $vwnamear[1];
                $hangidersar = explode(".", $hangiders);
                $hangisaat = $hangidersar[0];
                $vwhour = $hangisaat;
                $lessoninfo = $we[$day];
                $lessonExp = explode(' ', $lessoninfo);
                $lessonBranch = $lessonExp[1];
                $value = "lr|" . $lessoninfo;
                if (isset($lessonExp[2])) {
                    $studentID = $lessonExp[2];
                }
                $studentName = "";
                for ($dizi = 3; $dizi < count($lessonExp); $dizi++) {
                    $studentName .= $lessonExp[$dizi] . ' ';
                }
                $studentName = trim($studentName);
                $ulID = $teacher . '-' . $day . '-' . $we['vw_id'] . '-' . $hangisaat;
                if ($we[$day] == '0') $limitOfLesson = 3;
                else $limitOfLesson = 2;
                for ($quePro = 1; $quePro < $limitOfLesson; $quePro++) {
                    $vwid .= $quePro;
                    if ($studentID == "G") {
                        $valuevw = $studentName;
                    } else {
                        $valuevw = $studentID;
                    }
                    if ($we[$day] == '0') {
                        $studentName = '';
                        $studentID = '';
                        $croom = 'N404';
                        $cid = '';
                        $ctype = '';
                        $value = 'yok|' . $day . $qphour;
                        $classname = 'job-name-block-qp';
                        $classinfo = 'job-info-block-qp';
                        $classLi = 'que';
                        $class = 'job-block-qp';
                        $qphour = $hangisaat . $quePro;
                        $valuevw = 'yok|' . $day . $qphour;
                        $vwhour = $qphour;
                        $wholequestion = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess WHERE qp_teacher_id = '$teacher' AND qp_day = '$day' AND qp_hour = '$qphour';", ARRAY_A);
                        foreach ($wholequestion as $wq) {
                            $class = 'job-block-qp';
                            $cid = $wq['qp_id'];
                            $pcid = $wq['qp_id'];
                            $ctype = 'q';
                            $croom = $wq['qp_class'];
                            $studentID = $wq['qp_student_id'];
                            $valuevw = $studentID;
                            $studentName =  $students[$studentID];
                            $value = 'qp|' .  $studentID;
                            if ($studentID == 0) {
                                $value = 'yok|' . $day . $qphour . ' |' . $wq['qp_hour'];;
                            }
                        }
                    }
                    $liID = 'li' . $day . $hangisaat . $croom . $quePro;
                    if ($studentName != "") {
                        /** HTML CONTENT */
                        $content .= '<li class="' . $classLi . '" type="' . $ctype . '" name="' . $cid . '" id="' . $liID . '">';
                        $content .= '<input type="hidden" name="virtualweek" id="' . 'vw' . $teacher . $day . $vwhour . '" value="' . $valuevw . '">';
                        $content .= '<input type="hidden" name="valueLesson" id="' . 'hli' . $day . $vwid . $hangisaat . '" value="' . $value . '?>">';
                        $content .= '<div class="' . $class . ' ' . $day . $vwhour . '">';

                        $content .= '<div class="' . $classname . '">';
                        $content .= '<div class="job-name">' . $quePro . ' ' . $studentName . ' |' .  ' ' . $teacherList[$teachercounter]['name'] . '</div>';
                        $content .= '<div class="job-edit"><img class="edit-job-icon" src="https://image.flaticon.com/icons/svg/69/69398.svg"></div>';
                        $content .= '</div>';
                        $content .= '<div class="' . $classinfo . '">';
                        $content .= '<div class="job-date" id="' . 'class' . $cid . $day . '">' . $croom . '</div>';
                        $content .= '<div class="user-email">' . $lessonBranch . '</div>';
                        $content .= '</div>';
                        $content .= '</li>';

                        /** HTML CONTENT */
                        $classMatch[$croom][$day][$hangisaat] = $teacher;
                    }
                }
            }
        }

        /** HTML CONTENT */
        $content .= '</ul>';
        $content .= '</div>';
        $content .= '<div class="jobs-list-footer-all"></div>';
        $content .= '</div>';
        /** HTML CONTENT */
        $content .= '<script>';
        $content .= '    jQuery(document).ready(function() {
            var classRooms = [
                "B101", "B102", "B103", "B104", "B105", "B106", "B107", "G101", "G102", "G103",
                "B201", "B202", "B203", "B204", "B205", "B206", "B207", "G201", "G202", "G203",
                "B301", "B302", "B303", "B304", "B305", "B306", "B307", "G301", "G302", "G303"
            ];
            var today = jQuery("#today").val();
            classRooms.forEach(classr => {
                for (let index = 1; index < 10; index++) {
                    for (let findex = 1; findex < 3; findex++) {
                        if (jQuery("#li"+today + index + classr + findex).attr("id") != undefined) {
                            console.log(jQuery("#li"+today + index + classr + findex).attr("id"));
                            jQuery("#ul" +today + index + classr).append(jQuery("#li"+ today + index + classr + findex));
                        }
                    }
                }
            });
        });';
        $content .= '</script>';
    }

    $content .= '</div>';

    $returning = [];
    $returning['success'] = 1;
    $returning['content'] = $content;
    echo json_encode($returning);
}

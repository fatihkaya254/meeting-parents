<div id="pop-up">
    <span onclick="closePop()">close</span>
    <h4 id="whoisPop"></h4>
    <h6 id="groupStu"></h6>
    <?php
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
        $students[$stuidforlist] = $ws['name'] . " " . $ws['surname'];
    }
    $days = array("sal", "car", "per", "cum", "cts", "paz");
    foreach ($days as $day) {

        for ($saatler = 1; $saatler < 10; $saatler++) {
            if ($day != 'cts' && $day != 'paz') {
                $hours = array("10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00");
            } else {
                $hours = array("08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00");
            }
    ?>
            <div class="dingdong" id="<?php echo 'dd' . $day . $saatler ?>">
                <?php echo $day . " " . $hours[$saatler] ?>
                <small class="inf" id="<?php echo 'hoca' . $day . $saatler ?>"></small>
                <small class="inf" id="<?php echo 'ders' . $day . $saatler ?>"></small>
            </div>



        <?php
        }
        ?>
        <div class="seperator" id="<?php echo 'next' . $day ?>"></div>
    <?php
    }
    ?>
    <input type="search" oninput="pNameCheck()" list="popStudentName" name="popStudentName" placeholder="Öğrenci">
    <datalist id="popStudentName">
        <?php
        foreach ($students as $stude) {
        ?>
            <option value="<?php echo $stude ?>">
            <?php
        }
            ?>

    </datalist>
    <input type="search" oninput="pGroupCheck()" list="popGroupName" name="popGroupName" placeholder="Grup">
    <datalist id="popGroupName">
        <?php
        $lastName = "";
        foreach ($groupMatch as $group) {
            if ($group == $lastName) continue;
        ?>
            <option value="<?php echo $group ?>">
            <?php
            $lastName = $group;
        }
            ?>
    </datalist>
    <input type="search" oninput="pBranchCheck()" list="popBranchName" name="popBranchName" placeholder="Branş">
    <datalist id="popBranchName">

        <?php
        foreach ($branches as $brancho) {
        ?>
            <option value="<?php echo $brancho ?>">
            <?php
        }
            ?>


    </datalist>
    <input type="hidden" id="popValue">
    <input type="hidden" id="popId">
    <input type="hidden" id="popDay">
    <input type="hidden" id="popUl">
    <input type="hidden" id="popLi">
    <input type="hidden" id="popHour">
    <input type="hidden" id="popthisHour">
    <input type="hidden" id="popNew">
    <input type="hidden" id="popBranch">
    <input type="hidden" id="changeBranch">
    <input type="submit" onclick="goHand('delete')" value="Sil" id="sil">
    <input type="submit" onclick="goHand('change')" value="Değiştir" id="degistir">
    <input type="submit" onclick="goHand('lr')" value="Ders Ekle" id="ekle">
    <input type="submit" onclick="goHand('qp-1')" value="İlk 25" id="ekle1">
    <input type="submit" onclick="goHand('qp-2')" value="İkinci 25" id="ekle2">
</div>


<input type="hidden" id="changeClassUrl" value="<?php echo $changeClassURL ?>">
<input type="hidden" id="erasmusUrl" value="<?php echo $erasmusUrl ?>">
<input type="hidden" id="handlingUrl" value="<?php echo $handlingUrl ?>">
<a href="<?php echo $excellURL ?>"><img id="excell" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPHBhdGggc3R5bGU9ImZpbGw6IzRDQUY1MDsiIGQ9Ik0yOTQuNjU2LDEzLjAxNGMtMi41MzEtMi4wNTYtNS44NjMtMi44NDItOS4wNDUtMi4xMzNsLTI3Ny4zMzMsNjQNCgkJQzMuMzk3LDc2LjAwMy0wLjA0Nyw4MC4zNjksMCw4NS4zNzd2MzYyLjY2N2MwLjAwMiw1LjI2MywzLjg0Myw5LjczOSw5LjA0NSwxMC41MzlsMjc3LjMzMyw0Mi42NjcNCgkJYzUuODIzLDAuODk1LDExLjI2OS0zLjA5OSwxMi4xNjQtOC45MjFjMC4wODItMC41MzUsMC4xMjQtMS4wNzYsMC4xMjQtMS42MTdWMjEuMzc3QzI5OC42NzYsMTguMTI0LDI5Ny4xOTksMTUuMDQ1LDI5NC42NTYsMTMuMDE0DQoJCXoiLz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTUwMS4zMzQsNDU4LjcxSDI4OGMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N2MwLTUuODkxLDQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3DQoJCWgyMDIuNjY3Vjc0LjcxSDI4OGMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N1MyODIuMTA5LDUzLjM3NywyODgsNTMuMzc3aDIxMy4zMzNjNS44OTEsMCwxMC42NjcsNC43NzYsMTAuNjY3LDEwLjY2Nw0KCQl2Mzg0QzUxMiw0NTMuOTM1LDUwNy4yMjUsNDU4LjcxLDUwMS4zMzQsNDU4LjcxeiIvPg0KPC9nPg0KPGc+DQoJPHBhdGggc3R5bGU9ImZpbGw6I0ZBRkFGQTsiIGQ9Ik0yMDIuNjY3LDM1Mi4wNDRjLTMuNjc4LDAtNy4wOTYtMS44OTUtOS4wNDUtNS4wMTNMODYuOTU1LDE3Ni4zNjQNCgkJYy0zLjI3OS00Ljg5NC0xLjk2OS0xMS41MiwyLjkyNS0xNC43OTlzMTEuNTItMS45NjksMTQuNzk5LDIuOTI1YzAuMTI5LDAuMTkyLDAuMjUxLDAuMzg4LDAuMzY3LDAuNTg4bDEwNi42NjcsMTcwLjY2Nw0KCQljMy4xMSw1LjAwMywxLjU3NiwxMS41OC0zLjQyNywxNC42OTFDMjA2LjU5OSwzNTEuNDg0LDIwNC42NTMsMzUyLjA0MSwyMDIuNjY3LDM1Mi4wNDR6Ii8+DQoJPHBhdGggc3R5bGU9ImZpbGw6I0ZBRkFGQTsiIGQ9Ik05NiwzNTIuMDQ0Yy01Ljg5MS0wLjAxMi0xMC42NTctNC43OTctMTAuNjQ1LTEwLjY4OGMwLjAwNC0xLjk5MiwwLjU2Ni0zLjk0MywxLjYyMS01LjYzMg0KCQlsMTA2LjY2Ny0xNzAuNjY3YzIuOTU0LTUuMDk3LDkuNDgxLTYuODM0LDE0LjU3Ny0zLjg4YzUuMDk3LDIuOTU0LDYuODM0LDkuNDgxLDMuODgsMTQuNTc3Yy0wLjExNiwwLjItMC4yMzgsMC4zOTYtMC4zNjcsMC41ODgNCgkJTDEwNS4wNjcsMzQ3LjAwOUMxMDMuMTE5LDM1MC4xNDIsOTkuNjksMzUyLjA0Nyw5NiwzNTIuMDQ0eiIvPg0KPC9nPg0KPGc+DQoJPHBhdGggc3R5bGU9ImZpbGw6IzRDQUY1MDsiIGQ9Ik0zNzMuMzM0LDQ1OC43MWMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N3YtMzg0YzAtNS44OTEsNC43NzYtMTAuNjY3LDEwLjY2Ny0xMC42NjcNCgkJYzUuODkxLDAsMTAuNjY3LDQuNzc2LDEwLjY2NywxMC42Njd2Mzg0QzM4NCw0NTMuOTM1LDM3OS4yMjUsNDU4LjcxLDM3My4zMzQsNDU4LjcxeiIvPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwzOTQuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3YzAtNS44OTEsNC43NzYtMTAuNjY3LDEwLjY2Ny0xMC42NjcNCgkJaDIxMy4zMzNjNS44OTEsMCwxMC42NjcsNC43NzYsMTAuNjY3LDEwLjY2N0M1MTIsMzg5LjkzNSw1MDcuMjI1LDM5NC43MSw1MDEuMzM0LDM5NC43MXoiLz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTUwMS4zMzQsMzMwLjcxSDI4OGMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N2MwLTUuODkxLDQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3DQoJCWgyMTMuMzMzYzUuODkxLDAsMTAuNjY3LDQuNzc2LDEwLjY2NywxMC42NjdDNTEyLDMyNS45MzUsNTA3LjIyNSwzMzAuNzEsNTAxLjMzNCwzMzAuNzF6Ii8+DQoJPHBhdGggc3R5bGU9ImZpbGw6IzRDQUY1MDsiIGQ9Ik01MDEuMzM0LDI2Ni43MUgyODhjLTUuODkxLDAtMTAuNjY3LTQuNzc2LTEwLjY2Ny0xMC42NjdjMC01Ljg5MSw0Ljc3Ni0xMC42NjcsMTAuNjY3LTEwLjY2Nw0KCQloMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3QzUxMiwyNjEuOTM1LDUwNy4yMjUsMjY2LjcxLDUwMS4zMzQsMjY2LjcxeiIvPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwyMDIuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3czQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3aDIxMy4zMzMNCgkJYzUuODkxLDAsMTAuNjY3LDQuNzc2LDEwLjY2NywxMC42NjdTNTA3LjIyNSwyMDIuNzEsNTAxLjMzNCwyMDIuNzF6Ii8+DQoJPHBhdGggc3R5bGU9ImZpbGw6IzRDQUY1MDsiIGQ9Ik01MDEuMzM0LDEzOC43MUgyODhjLTUuODkxLDAtMTAuNjY3LTQuNzc2LTEwLjY2Ny0xMC42NjdjMC01Ljg5MSw0Ljc3Ni0xMC42NjcsMTAuNjY3LTEwLjY2Nw0KCQloMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3QzUxMiwxMzMuOTM1LDUwNy4yMjUsMTM4LjcxLDUwMS4zMzQsMTM4LjcxeiIvPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=">
</a>
<div id="body">
    <style>
        <?php include(dirname(__FILE__, 2) . '/trello/trestyle.css') ?>
    </style>
    <script>
        <?php include(dirname(__FILE__, 2) . '/trello/trescript.js') ?>
        jQuery(function() {
            jQuery("#draggable").draggable();
        });
    </script>
    <?php
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
    ?>
        <input class="checkbox-booking" type="checkbox" name="booking" value="<?php echo $wt['teacher_id'] ?>" id="hello<?php echo $wt['teacher_id'] ?>" oninput="showBusiness()">
        <label class="for-checkbox-booking" for="hello<?php echo $wt['teacher_id'] ?>">
            <span class="text"><?php echo $wt['name'] . " " . $wt['surname']; ?></span>
        </label>
    <?php
    }

    /** sınıflar ve sınıf eşleşmeleri */
    $classRooms = [
        "B101", "B102", "B103", "B104", "B105", "B106", "B107", "G101", "G102", "G103", "E101",
        "B201", "B202", "B203", "B204", "B205", "B206", "B207", "G201", "G202", "G203", "E201",
        "B301", "B302", "B303", "B304", "B305", "B306", "B307", "G301", "G302", "G303", "E301", "N404"
    ];
    foreach ($classRooms as $room) {
        foreach ($days as $day) {
            for ($i = 1; $i < 10; $i++) {
                $classMatch[$room][$day][$i] = 0;
            }
        }
    }
    /** sınıflar ve sınıf eşleşmeleri */

    for ($teachercounter = 0; $teachercounter < $teachercount; $teachercounter++) {
        $teacher = $teacherList[$teachercounter]['id'];


    ?>
        <div class="body-section" id="body<?php echo $teacher ?>">

            <div class="jobs-list-wrapper" id="teacher<?php echo $teacher ?>">

                <?php

                foreach ($days as $day) {
                    if ($day != 'cts' && $day != 'paz') {
                        $hours = array("10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00");
                    } else {
                        $hours = array("08:00", "9:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00");
                    }
                ?>
                    <div class="jobs-list">
                        <h2 class="jobs-list-heading"><?php echo $day . ' - ' . $teacherList[$teachercounter]['name']  ?></h2>
                        <div class="jobs-list-body" id="in-progress">
                            <?php

                            $wholelesson = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE teacher_id = '$teacher';", ARRAY_A);
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
                            ?>
                                <small><?php echo $hangisaat . ' - ' . $hours[$hangisaat] ?></small>
                                <ul class="sort ul<?php echo $day . $hangisaat; ?>" id="<?php echo $ulID ?>">
                                    <?php
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
                                                $value = "qp|" .  $studentID;
                                                if ($studentID == 0) {
                                                    $value = 'yok|' . $day . $qphour . "|" . $wq['qp_hour'];;
                                                }
                                            }
                                        }
                                        $liID = 'li' . $day . $vwid . $hangisaat;
                                    ?>
                                        <li class="<?php echo $classLi ?>" name="<?php echo $teacher ?>" id="<?php echo $liID ?>">
                                            <input type="hidden" name="virtualweek" id="<?php echo 'vw' . $teacher . $day . $vwhour ?>" value="<?php echo $valuevw ?>"><!-- input sırası değiştirilmemeli -->
                                            <input type="hidden" name="valueLesson" id="<?php echo 'hli' . $day . $vwid . $hangisaat ?>" value="<?php echo $value ?>">
                                            <div class="<?php echo $class . ' ' . $day . $vwhour ?>" id="cover-<?php echo $studentName ?>-<?php if ($studentID != 0) echo $studentID;
                                                                                                                                            else echo $teacher . $day . $vwhour ?>">
                                                <div class="<?php echo $classname ?>">
                                                    <div class="job-name"><?php echo $studentName ?></div>
                                                    <div class="job-edit"><img onclick="openPop('<?php echo $lessonBranch ?>', '<?php echo $ulID ?>', '<?php echo $liID ?>', '<?php echo $studentID ?>','<?php echo $studentName ?>','<?php echo $value ?>', '<?php echo $day ?>','<?php echo $hangisaat ?>','<?php echo $pcid ?>','<?php echo $vwhour ?>')" class="edit-job-icon" src="https://image.flaticon.com/icons/svg/69/69398.svg"></div>
                                                </div>
                                                <div class="<?php echo $classinfo ?>">
                                                    <div class="job-date" id="<?php echo 'class' . $cid . $day ?>" onclick="openClass('<?php echo $cid ?>','<?php echo $day ?>','<?php echo $hangisaat ?>','<?php echo $ctype ?>')"><?php echo $croom ?></div>
                                                    <div class="user-email"><?php echo $lessonBranch ?></div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                        $classMatch[$croom][$day][$hangisaat] = $teacher;
                                    }
                                    ?>
                                </ul>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="jobs-list-footer"></div>
                    </div>
                <?php
                }
                ?>
                <div class="footer-section">
                </div>

            </div>
        </div>

    <?php
    }
    ?>


    <!-- <div id="body">
        <div class="jobs-list-wrapper" id="draggable">
            <div class="jobs-list-all">
                <h2 class="jobs-list-heading">Lesson Handler</h2>
                <div class="jobs-list-all-body" id="new-jobs">
                    <ul class="sort" id="handler">                
                    </ul>
                </div>
            </div>
        </div>
    </div>-->
</div>
<div id="class-pop">
    <img onclick="closeClassPop();" class="class-img" src="https://image.flaticon.com/icons/svg/61/61155.svg">
    <input type="search" oninput="addRoom();" class="hellokitty" list="roomlist" name="roomlist" placeholder="Sınıf">
    <datalist id="roomlist">


    </datalist>
</div>


<script>
    var days = ["sal", "car", "per", "cum", "cts", "paz"];
    var groups = '<?php echo json_encode($groupMatch); ?>';
    var names = '<?php echo json_encode($students); ?>';
    var teacherlist = '<?php echo json_encode($teacherListB); ?>';
    var branches = '<?php echo json_encode($branches); ?>';
    var classRooms = '<?php echo json_encode($classRooms); ?>';
    var classMatch = '<?php echo json_encode($classMatch); ?>';
    var changeClassURL = '<?php echo $changeClassURL; ?>';

    var jTeacherList = JSON.parse(teacherlist);
    var jgroups = JSON.parse(groups);
    var jnames = JSON.parse(names);
    var jbranch = JSON.parse(branches);
    var jclassRooms = JSON.parse(classRooms);
    var jclassMatch = JSON.parse(classMatch);
    var classForID = 0;
    var classForDay = "";
    var classForType = "";
    var classForClass = "";

    function addRoom(day, hour) {
        var classForClass = jQuery(".hellokitty").val();
        if (jclassMatch[classForClass][day][hour] == 0) {
            changeClass(classForID, classForDay, classForType, classForClass);
            jclassMatch[classForClass][day][hour] = -2;
            jQuery("#roomlist").remove(jQuery("<option>").attr('value', jclassRooms[room]).text(jclassRooms[room]));
            jQuery("#class-pop").fadeOut();
        } else {
            console.log('no: ' + classForClass);
        }

    }

    function openClass(id, day, hour, type) {
        jQuery(".hellokitty").val("");
        jQuery(".hellokitty").attr("oninput", "addRoom('" + day + "','" + hour + "')");
        classForID = id;
        classForDay = day;
        classForType = type;
        for (var room in jclassRooms) {
            if (jclassMatch[jclassRooms[room]][day][hour] == 0) {
                jQuery("#roomlist").append(jQuery("<option>").attr('value', jclassRooms[room]).text(jclassRooms[room]));
            }
        }
        var l = event.pageX;
        var t = event.pageY - window.scrollY - 50;
        console.log(window.scrollY);
        console.log("left: " + l + " top: " + t);
        jQuery("#class-pop").css("top", t);
        jQuery("#class-pop").css("left", l);
        jQuery("#class-pop").fadeIn();
    }

    function pGroupCheck() {
        var valueN = jQuery('input[name ="popGroupName"]').val();
        var gExist = Object.values(jgroups).indexOf(valueN);
        if (gExist != -1) {
            jQuery('input[name ="popGroupName"]').css('border', '2px solid rgb(52, 199, 89)');
            jQuery('input[name ="popStudentName"]').css('border', 'none');
            jQuery("#popNew").val('G');

        } else {
            jQuery('input[name ="popGroupName"]').css('border', 'none');
        }
    }

    function pBranchCheck() {
        var valueN = jQuery('input[name ="popBranchName"]').val();
        var braid = Object.keys(jbranch).find(value => jbranch[value] === valueN);
        if (braid != undefined) {
            jQuery('input[name ="popBranchName"]').css('border', '2px solid rgb(52, 199, 89)');
            jQuery("#changeBranch").val(braid);
        } else {
            jQuery('input[name ="popStudentName"]').css('border', 'none');
        }
    }

    function pNameCheck() {
        var valueN = jQuery('input[name ="popStudentName"]').val();
        var stuid = Object.keys(jnames).find(value => jnames[value] === valueN);
        if (stuid != undefined) {
            jQuery('input[name ="popStudentName"]').css('border', '2px solid rgb(52, 199, 89)');
            jQuery('input[name ="popGroupName"]').css('border', 'none');
            jQuery("#popNew").val(stuid);
        } else {
            jQuery('input[name ="popStudentName"]').css('border', 'none');
        }
    }

    function closeClassPop() {
        jQuery("#class-pop").fadeOut();
    }




    /*jQuery("#classPut").on('keypress', function(e) {
        if (e.which == 13) {
            var classForClass = jQuery("#classPut").val();
            changeClass(changeClassURL, classForID, classForDay, classForType, classForClass);
            jQuery("#class-pop").fadeOut();
        }
    });
*/
    function closePop() {
        jQuery("#pop-up").fadeOut();
        jQuery("#body").css("filter", "none");
    }


    function openPop(branch, ul, li, id, name, value, thisDay, thisHour, popid, pophour) {

        jQuery("#popValue").val(value);
        jQuery("#popBranch").val(branch);
        jQuery("#popId").val(popid);
        jQuery("#popDay").val(thisDay);
        jQuery("#popUl").val(ul);
        jQuery("#popLi").val(li);
        jQuery("#popHour").val(pophour);
        jQuery("#popthisHour").val(thisHour);
        jQuery("#groupStu").text("");
        jQuery("#pop-up").fadeIn();
        jQuery("#body").css("filter", "blur(1.5px)");

        if (name == '') {
            jQuery("#ekle").fadeIn();
            jQuery("#sil").prop('disabled', true);
            jQuery("#degistir").prop('disabled', true);
            if (jQuery("#" + ul + " li:first").attr('id') == li) {
                jQuery("#ekle1").fadeIn(100);
                jQuery("#ekle2").fadeOut(100);
            } else {
                jQuery("#ekle2").fadeIn(100);
                jQuery("#ekle1").fadeOut(100);
            }

        } else {
            jQuery("#sil").prop('disabled', false);
            jQuery("#degistir").prop('disabled', false);
            jQuery("#ekle").fadeOut(100);
            jQuery("#ekle1").fadeOut(100);
            jQuery("#ekle2").fadeOut(100);
        }

        console.log(thisHour);
        jQuery("#whoisPop").text(name);
        if (jgroups[id] == undefined) jgroups[id] = "yok";
        for (var key in jTeacherList) {
            if (jTeacherList.hasOwnProperty(key)) {
                for (let day = 0; day < days.length; day++) {
                    let gun = days[day];
                    for (let i = 1; i < 10; i++) {
                        jQuery("#dd" + gun + i).css("background-color", "rgb(209, 209, 214);");
                        jQuery("#dd" + gun + i).css("color", "#000");
                        jQuery("#ders" + gun + i).text("");
                        jQuery("#hoca" + gun + i).text("");
                    }
                }
            }
        }
        for (var key in jTeacherList) {
            if (jTeacherList.hasOwnProperty(key)) {
                for (let day = 0; day < days.length; day++) {
                    let gun = days[day];
                    for (let i = 1; i < 10; i++) {
                        if (jQuery("#vw" + key + gun + i).val() == id || jQuery("#vw" + key + gun + i).val() == name || jQuery("#vw" + key + gun + i).val() == jgroups[id]) {
                            jQuery("#dd" + gun + i).css("background-color", "rgb(52, 199, 89)");
                            jQuery("#dd" + gun + i).css("color", "#fff");
                            jQuery("#hoca" + gun + i).text(jTeacherList[key]);
                            jQuery("#ders" + gun + i).text(jQuery("#vw" + key + gun + i).val());
                            jQuery("#dd" + gun + i).hover(function() {
                                    jQuery("#ders" + gun + i).css("display", "block");
                                    jQuery("#hoca" + gun + i).css("display", "block");
                                },
                                function() {
                                    jQuery("#next" + gun).html("")
                                    jQuery("#ders" + gun + i).css("display", "none");
                                    jQuery("#hoca" + gun + i).css("display", "none");
                                }
                            );
                            if ("" + gun + i == "" + thisDay + thisHour) {
                                jQuery("#dd" + gun + i).css("background-color", "rgb(255, 149, 0)");
                            }
                        }
                        for (let j = 1; j < 3; j++) {
                            if (jQuery("#vw" + key + gun + i + j).val() == id || jQuery("#vw" + key + gun + i + j).val() == name) {
                                jQuery("#dd" + gun + i).css("background-color", "rgb(0, 122, 255)");
                                jQuery("#dd" + gun + i).css("color", "#fff");
                                jQuery("#hoca" + gun + i).text(jTeacherList[key]);
                                jQuery("#ders" + gun + i).text(jQuery("#vw" + key + gun + i).val());
                                if ("" + gun + i == "" + thisDay + thisHour) {
                                    jQuery("#dd" + gun + i).css("background-color", "rgb(255, 149, 0)");
                                }
                                jQuery("#dd" + gun + i).hover(function() {
                                        jQuery("#ders" + gun + i).css("display", "block");
                                        jQuery("#hoca" + gun + i).css("display", "block");
                                    },
                                    function() {
                                        jQuery("#next" + gun).html("")
                                        jQuery("#ders" + gun + i).css("display", "none");
                                        jQuery("#hoca" + gun + i).css("display", "none");
                                    }
                                );
                            }
                        }
                    }
                }
            }
        }
        if (id == "G") {
            Object.keys(jgroups).forEach(function(element) {
                if (jgroups[element] == name) {
                    jQuery("#groupStu").append(jnames[element] + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
                }
            });
        } else {
            jQuery("#groupStu").text(jgroups[id]);
        }
    }
</script>
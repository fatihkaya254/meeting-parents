<div id="pop-up">
    <span onclick="closePop()">close</span>
    <h4 id="whoisPop"></h4>
    <h6 id="groupStu"></h6>
    <?php
    $changeClassURL = site_url() . '/wp-content/plugins/meeting-parents/trello/changeClass.php/';
    $erasmusUrl = site_url() . '/wp-content/plugins/meeting-parents/trello/erasmus.php/';
    global $wpdb;
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
</div>

<div id="class-pop">
    <img onclick="closeClassPop();" class="class-img" src="https://image.flaticon.com/icons/svg/61/61155.svg">
    <input id="classPut" type="text">
</div>

<input type="hidden" id="erasmusUrl" value="<?php echo $erasmusUrl ?>">
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
    $groupMatch = array();
    $groupM = $wpdb->get_results("SELECT * FROM  {$wpdb->prefix}mp_group_matches, {$wpdb->prefix}mp_lesson_group, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_group_matches.group_id = {$wpdb->prefix}mp_lesson_group.group_id AND {$wpdb->prefix}mp_group_matches.student_id = {$wpdb->prefix}mp_student.student_id", ARRAY_A);
    foreach ($groupM as $gm) {
        $groupMatch[$gm['student_id']] = $gm['group_name'];
    }
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


    for ($teachercounter = 0; $teachercounter < $teachercount; $teachercounter++) {
        $teacher = $teacherList[$teachercounter]['id'];


    ?>
        <div class="body-section" id="body<?php echo $teacher ?>">

            <div class="jobs-list-wrapper" id="teacher<?php echo $teacher ?>">

                <?php

                $students = [];
                $wholestudent = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE active = '1';", ARRAY_A);
                foreach ($wholestudent as $ws) {
                    $stuidforlist = $ws['student_id'];
                    $students[$stuidforlist] = $ws['name'] . " " . $ws['surname'];
                }
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

                            ?>
                                <small><?php echo $hangisaat . ' - ' . $hours[$hangisaat] ?></small>
                                <ul class="sort" id=" <?php echo $teacher . '-' . $day . '-' . $we['vw_id'] . '-' . $hangisaat ?>">
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
                                            $value = 'qp|0';
                                            $valuevw = '0';
                                            $classname = 'job-name-block-qp';
                                            $classinfo = 'job-info-block-qp';
                                            $classLi = 'que';
                                            $class = 'job-block-qp';
                                            $qphour = $hangisaat . $quePro;
                                            $wholequestion = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess WHERE qp_teacher_id = '$teacher' AND qp_day = '$day' AND qp_hour = '$qphour';", ARRAY_A);
                                            foreach ($wholequestion as $wq) {
                                                $class = 'job-block-qp';
                                                $cid = $wq['qp_id'];
                                                $ctype = 'q';
                                                $croom = $wq['qp_class'];
                                                $studentID = $wq['qp_student_id'];
                                                $valuevw = $studentID;
                                                $studentName =  $students[$studentID];
                                                $value = "qp|" .  $studentID . "|" . $wq['qp_hour'];
                                                $vwhour = $qphour;
                                            }
                                        } ?>
                                        <li class="<?php echo $classLi ?>" id="<?php echo 'li' . $day . $vwid . $hangisaat ?>">
                                            <input type="hidden" id="<?php echo 'vw' . $teacher . $day . $vwhour ?>" value="<?php echo $valuevw ?>">
                                            <input type="hidden" id="<?php echo 'hli' . $day . $vwid . $hangisaat ?>" value="<?php echo $value ?>">
                                            <div class="<?php echo $class . ' ' . $day . $vwhour ?>" id="cover-<?php echo $studentName ?>-<?php echo $studentID ?>">
                                                <div class="<?php echo $classname ?>">
                                                    <div class="job-name"><?php echo $studentName ?></div>
                                                    <div class="job-edit"><img onclick="openPop('<?php echo $studentID ?>','<?php echo $studentName ?>', '<?php echo $day ?>','<?php echo $hangisaat ?>')" class="edit-job-icon" src="https://image.flaticon.com/icons/svg/69/69398.svg"></div>
                                                </div>
                                                <div class="<?php echo $classinfo ?>">
                                                    <div class="job-date" id="<?php echo 'class' . $cid . $day ?>" onclick="openClass('<?php echo $cid ?>','<?php echo $day ?>','<?php echo $ctype ?>')"><?php echo $croom ?></div>
                                                    <div class="user-email"><?php echo $lessonBranch ?></div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
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

    <?php } ?>


    <div id="body">
        <div class="jobs-list-wrapper" id="draggable">
            <div class="jobs-list-all">
                <h2 class="jobs-list-heading">Lesson Handler</h2>
                <div class="jobs-list-all-body" id="new-jobs">
                    <ul id="handler">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var days = ["sal", "car", "per", "cum", "cts", "paz"];
    var groups = '<?php echo json_encode($groupMatch); ?>';
    var names = '<?php echo json_encode($students); ?>';
    var teacherlist = '<?php echo json_encode($teacherListB); ?>';
    var changeClassURL = '<?php echo $changeClassURL; ?>';
    var jTeacherList = JSON.parse(teacherlist);
    var jgroups = JSON.parse(groups);
    var jnames = JSON.parse(names);
    var classForID = 0;
    var classForDay = "";
    var classForType = "";
    var classForClass = "";
    function closeClassPop(){
        jQuery("#class-pop").fadeOut();
    }
    function openClass(id, day, type) {
        classForID = id;
        classForDay = day;
        classForType = type;
        var l = event.pageX;
        var t = event.pageY - window.scrollY - 50;
        console.log(window.scrollY);
        console.log("left: " + l + " top: " + t);
        jQuery("#class-pop").css("top", t);
        jQuery("#class-pop").css("left", l);
        jQuery("#class-pop").fadeIn();
    }


    jQuery("#classPut").on('keypress', function(e) {
        if (e.which == 13) {
            var classForClass = jQuery("#classPut").val();
            changeClass(changeClassURL, classForID, classForDay, classForType, classForClass);
            jQuery("#class-pop").fadeOut();
        }
    });

    function closePop() {
        jQuery("#pop-up").fadeOut();
        jQuery("#body").css("filter", "none");
    }

    jQuery(".job-block-qp").hover(function() {
            var hoverObject = jQuery(this).attr('id');
            var harray = hoverObject.split("-");
            var id = harray[2];
            var name = harray[1];
            if (id == "G") id = name;
            if (jgroups[id] == undefined) jgroups[id] = "yok";
            //   console.log(jgroups[id]);
            for (var key in jTeacherList) {
                if (jTeacherList.hasOwnProperty(key)) {
                    for (let day = 0; day < days.length; day++) {
                        let gun = days[day];
                        for (let i = 1; i < 10; i++) {
                            if (jQuery("#vw" + key + gun + i).val() == id || jQuery("#vw" + key + gun + i).val() == name || jQuery("#vw" + key + gun + i).val() == jgroups[id]) {
                                var kontrolClass = "job-block " + gun + i;
                                if (jQuery(this).attr('class') != kontrolClass) {
                                    jQuery("." + gun + i).css("box-shadow", "inset 0 0 100px #000000");
                                    jQuery("." + gun + i + 1).css("box-shadow", "inset 0 0 100px #000000");
                                    jQuery("." + gun + i + 2).css("box-shadow", "inset 0 0 100px #000000");
                                    // console.log(gun + i + " = " + jQuery("#vw" + key + gun + i).val());
                                }

                            }
                            for (let j = 1; j < 3; j++) {
                                if (jQuery("#vw" + key + gun + i + j).val() == id || jQuery("#vw" + key + gun + i + j).val() == name) {
                                    var kontrolClass = "job-block " + gun + i + j;
                                    if (jQuery(this).attr('class') != kontrolClass) {
                                        jQuery("." + gun + i).css("box-shadow", "inset 0 0 100px #000000");
                                        jQuery("." + gun + i + j).css("box-shadow", "inset 0 0 100px #000000");
                                        // console.log(gun + i + " = " + jQuery("#vw" + key + gun + i + j).val());
                                    }
                                }
                            }
                        }
                    }
                }
            }
        },
        function() {
            jQuery(".job-block").css("box-shadow", "none");
            jQuery(".job-block-qp").css("box-shadow", "none");
        }
    );

    jQuery(".job-block").hover(function() {
            var hoverObject = jQuery(this).attr('id');
            var harray = hoverObject.split("-");
            var id = harray[2];
            var name = harray[1];
            if (id == "G") id = name;
            if (jgroups[id] == undefined) jgroups[id] = "yok";
            // console.log(jgroups[id]);
            for (var key in jTeacherList) {
                if (jTeacherList.hasOwnProperty(key)) {
                    for (let day = 0; day < days.length; day++) {
                        let gun = days[day];
                        for (let i = 1; i < 10; i++) {
                            if (jQuery("#vw" + key + gun + i).val() == id || jQuery("#vw" + key + gun + i).val() == name || jQuery("#vw" + key + gun + i).val() == jgroups[id]) {
                                var kontrolClass = "job-block " + gun + i;
                                if (jQuery(this).attr('class') != kontrolClass) {
                                    jQuery("." + gun + i).css("box-shadow", "inset 0 0 100px #000000");
                                    jQuery("." + gun + i + 1).css("box-shadow", "inset 0 0 100px #000000");
                                    jQuery("." + gun + i + 2).css("box-shadow", "inset 0 0 100px #000000");
                                    //   console.log(gun + i + " = " + jQuery("#vw" + key + gun + i).val());
                                }

                            }
                            for (let j = 1; j < 3; j++) {
                                if (jQuery("#vw" + key + gun + i + j).val() == id || jQuery("#vw" + key + gun + i + j).val() == name) {
                                    jQuery("." + gun + i).css("box-shadow", "inset 0 0 100px #000000");
                                    jQuery("." + gun + i + j).css("box-shadow", "inset 0 0 100px #000000");
                                    //  console.log(gun + i + " = " + jQuery("#vw" + key + gun + i + j).val());

                                }
                            }
                        }
                    }
                }
            }
            Object.keys(jgroups).forEach(function(element) {
                if (jgroups[element] == name) {
                    id = element;
                    // console.log(jnames[element] + ": " + id);
                    for (var key in jTeacherList) {
                        if (jTeacherList.hasOwnProperty(key)) {
                            for (let day = 0; day < days.length; day++) {
                                let gun = days[day];
                                for (let i = 1; i < 10; i++) {
                                    if (jQuery("#vw" + key + gun + i).val() == id) {
                                        var kontrolClass = "job-block " + gun + i;
                                        jQuery("." + gun + i).css("box-shadow", "inset 0 0 100px #000000");
                                        jQuery("." + gun + i + 1).css("box-shadow", "inset 0 0 100px #000000");
                                        jQuery("." + gun + i + 2).css("box-shadow", "inset 0 0 100px #000000");
                                        //  console.log(gun + i + " = " + jQuery("#vw" + key + gun + i).val());

                                    }
                                    for (let j = 1; j < 3; j++) {
                                        if (jQuery("#vw" + key + gun + i + j).val() == id) {
                                            jQuery("." + gun + i).css("box-shadow", "inset 0 0 100px #000000");
                                            jQuery("." + gun + i + j).css("box-shadow", "inset 0 0 100px #000000");
                                            //    console.log(gun + i + " = " + jQuery("#vw" + key + gun + i + j).val());

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });
        },
        function() {
            jQuery(".job-block").css("box-shadow", "none");
            jQuery(".job-block-qp").css("box-shadow", "none");
        }
    );


    function openPop(id, name, thisDay, thisHour) {

        jQuery("#groupStu").text("");
        jQuery("#pop-up").fadeIn();
        jQuery("#body").css("filter", "blur(1.5px)");

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
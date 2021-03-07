<style>
    <?php include(dirname(__FILE__, 2) . '/trello/programA.css') ?><?php include(dirname(__FILE__, 2) . '/trello/programB.css') ?>
</style>



<div class="table100">
    <table class="otherTable" id="programTable<?php echo $teacher ?>">
        <?php
        require_once dirname(__FILE__, 2) . '/teacherspage/timeTime.php';
        $tT = new timeTime;
        $userLogin = $tT->getUserlogin('');
        $userName = $tT->getUsername('');
        $isTeacher = $tT->isThisTeacher($userLogin);
        $id = $tT->getIDByUsername($userLogin, '');
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
        $dayNames = [];
        $dayNames['sal'] = 'Salı';
        $dayNames['car'] = 'Çarşamba';
        $dayNames['per'] = 'Perşembe';
        $dayNames['cum'] = 'Cuma';
        $dayNames['cts'] = 'Cumartesi';
        $dayNames['paz'] = 'Pazar';
        if ($day != 'cts' && $day != 'paz') {
            $hours = array("10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00");
        } else {
            $hours = array("08:00", "9:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00");
        }
        $wholeteacher = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_teacher WHERE teacher_id = '$id';", ARRAY_A);
        foreach ($wholeteacher as $wt) {
            $teacher = $wt['teacher_id'];
            $teacherName = $wt['name'] . " " . $wt['surname'];
        ?>
            <thead>
                <tr>
                    <th><?php echo $teacherName ?></th>
                    <th>11:00</th>
                    <th>12:00</th>
                    <th>13:00</th>
                    <th>14:00</th>
                    <th style="color: rgb(255, 45, 85);">15:00</th>
                    <th>16:00</th>
                    <th>17:00</th>
                    <th>18:00</th>
                    <th>19:00</th>
                </tr>
            </thead>
            <tbody>
                <?php


                $hours = array("10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00");
                foreach ($days as $day) {
                    if ($day == "cts") {
                ?>
                        <thead>
                            <tr>
                                <th>Haftasonu</th>
                                <th>09:00</th>
                                <th>10:00</th>
                                <th>11:00</th>
                                <th>12:00</th>
                                <th style="color: rgb(255, 45, 85);">13:00</th>
                                <th>14:00</th>
                                <th>15:00</th>
                                <th>16:00</th>
                                <th>17:00</th>
                            </tr>
                        <tbody>
                        <?php
                    }
                        ?>
                        <tr>
                            <td><?php echo $dayNames[$day]; ?></td>
                            <?php
                            for ($dersSaati = 1; $dersSaati < 10; $dersSaati++) {
                                $vwNameWhere = $teacher . ' - ' . $dersSaati . '. Saat';
                                $wholelesson = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE vw_name = '$vwNameWhere';", ARRAY_A);

                                foreach ($wholelesson as $we) {
                            ?>

                                    <?php
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
                                    if ($studentName == "") {
                                        $croom = "";
                                    }
                                    ?>
                                    <td>
                                        <h5 style="margin-bottom: 4px; font: 1em;"><?php echo $studentName ?></h5>
                                        <small><?php echo $lessonBranch . " - " . $croom ?></small>
                                    </td>
                                <?php
                                } ?>



                            <?php
                            }
                            ?>
                        </tr>
                    <?php
                }
                    ?>
                        </tbody>
</div>



<table>
<?php
        }
?>
<table></table>
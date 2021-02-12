<div id="body">
    <style>
        <?php include(dirname(__FILE__, 2) . '/trello/trestyle.css') ?>
    </style>
    <script>
        <?php include(dirname(__FILE__, 2) . '/trello/trescript.js') ?>
    </script>
    <div class="body-section">
        <div class="jobs-list-wrapper">
            <?php
            $days = array("sal", "car", "per", "cum", "cts", "paz");
            foreach ($days as $day) {
            ?>
                <div class="jobs-list">
                    <h2 class="jobs-list-heading"><?php echo $day ?></h2>
                    <div class="jobs-list-body" id="in-progress">
                        <?php
                        global $wpdb;
                        $wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE teacher_id = '1';", ARRAY_A);
                        foreach ($wholeexams as $we) {

                            $vwname = $we['vw_name'];
                            $vwnamear = explode(" - ", $vwname);
                            $hangiders = $vwnamear[1];
                            $hangidersar = explode(".", $hangiders);
                            $hangisaat = $hangidersar[0];
                            $lessoninfo = $we[$day];
                            $lessonExp = explode(' ', $lessoninfo);
                            $lessonBranch = $lessonExp[1];
                            if (isset($lessonExp[2])) {
                                $studentID = $lessonExp[2];
                            }
                            $studentName = "";
                            for ($dizi = 3; $dizi < count($lessonExp); $dizi++) {
                                $studentName .= $lessonExp[$dizi] . ' ';
                            }
                        ?>
                            <small>10:00</small>
                            <ul class="sort" id="in-progress-list">
                                <li id="<?php echo $day . $we['vw_id'] ?>">
                                    <div class="job-block" id="in-progress-test">
                                        <div class="job-name-block">
                                            <div class="job-name"><?php echo $studentName ?></div>
                                            <div class="job-edit"><img class="edit-job-icon" src="https://image.flaticon.com/icons/svg/61/61456.svg"></div>
                                        </div>
                                        <div class="job-info-block">
                                            <div class="job-date">21 Apr</div>
                                            <div class="user-email"><?php echo $lessonBranch ?></div>
                                        </div>
                                    </div>
                                </li>
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
            <div class="footer-section"></div>
        </div>
    </div>
    <?php ?>
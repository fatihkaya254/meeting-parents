    <style>
        <?php include(dirname(__FILE__, 2) . '/trello/trestyle.css') ?>
    </style>


    <?php
    $getLessonsURL = site_url() . '/wp-content/plugins/meeting-parents/trello/classRoomGetter.php/';
    $id = "sal";
    ?>
    <div class="daysButton">
        <ul>
            <input onclick="changeLesson('<?php echo $getLessonsURL; ?>', 'sal')" type="submit" value="Salı">
            <input onclick="changeLesson('<?php echo $getLessonsURL; ?>', 'car')" type="submit" value="Çarşamba">
            <input onclick="changeLesson('<?php echo $getLessonsURL; ?>', 'per')" type="submit" value="Perşembe">
            <input onclick="changeLesson('<?php echo $getLessonsURL; ?>', 'cum')" type="submit" value="Cuma">
            <input onclick="changeLesson('<?php echo $getLessonsURL; ?>', 'cts')" type="submit" value="Cumartesi">
            <input onclick="changeLesson('<?php echo $getLessonsURL; ?>', 'paz')" type="submit" value="Pazar">
        </ul>
    </div>
    <div id="main-content"></div>

    <script>
        function changeLesson(url, classroom) {
            jQuery('#main-content').empty();
            getLessons(url, classroom);
        }
        jQuery(document).ready(function() {
            getLessons('<?php echo $getLessonsURL; ?>', '<?php echo $id; ?>');

        });
    </script>
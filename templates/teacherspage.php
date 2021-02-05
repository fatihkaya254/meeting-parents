<?php

require_once dirname(__FILE__, 2).'/teacherspage/tpstyle.css'; 
require_once dirname(__FILE__, 2).'/teacherspage/timeTime.php'; 

$getLessonsURL = site_url().'/wp-content/plugins/meeting-parents/teacherspage/getLessons.php/';

$tT = new timeTime;

$userLogin = $tT->getUserlogin('');
$userName = $tT->getUsername('');
$isTeacher = $tT->isThisTeacher($userLogin);
$id = $tT->getIDByUsername($userLogin, '');
$time = $tT->getCurrentTime('');
$date = $tT->getCurrentDate('');
$bugun = $tT->getCurrentDay('');
$hours = $tT->getLesssonHours('');
?>

<div id="process-content">
	<ul id="progressbar" class="progressbar">
       
      </ul>
</div>

<div id="main-content">
	
</div>



<script>
	jQuery(document).ready(function(){

		getLessons('<?php echo $getLessonsURL; ?>', '<?php echo $id; ?>');
	
	});

</script>
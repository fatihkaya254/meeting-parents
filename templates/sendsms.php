<?php

require_once dirname(__FILE__, 2).'/sms/smsstyle.css'; 
require_once dirname(__FILE__, 2).'/teacherspage/timeTime.php'; 

$getSMSURL = site_url().'/wp-content/plugins/meeting-parents/sms/getSMS.php';

$tT = new timeTime;

$userLogin = $tT->getUserlogin('');
$userName = $tT->getUsername('');
$isTeacher = $tT->isThisTeacher($userLogin);
$id = $tT->getIDByUsername($userLogin, '');
if ($id != 9 && $id != 15 ) {
	die;
}
$time = $tT->getCurrentTime('');
$date = $tT->getCurrentDate('');
$bugun = $tT->getCurrentDay('');
$hours = $tT->getLesssonHours('');
?>



<div id="main-content">
	
</div>



<script>
	jQuery(document).ready(function(){

		getSms('<?php echo $getSMSURL; ?>', '<?php echo $date; ?>', '<?php echo $bugun; ?>');
	
	});

</script>
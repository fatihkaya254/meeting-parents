<?php 

if (isset($_POST['start']) && $_POST['start'] == '1' ) {


$path = preg_replace('/wp-content.*$/', '', __DIR__);

require_once($path."wp-load.php");


global $wpdb;
date_default_timezone_set('Europe/Istanbul');
$content = '';

$saaat=date('H:i:s');
$t=date('d-m-Y');
$today = date("D",strtotime($t));
$bugun = "<br>bugun<br>";
$tarih = date("Y-m-d",strtotime($t));
$saatler = array('11','12','13','14','15','16','17','18','19');
$smsgetURL = site_url().'/wp-content/plugins/meeting-parents/getsms/';

if ($today == "Mon") {
	$bugun = "pts";
	$content .= ' <div> <h4>Pazartesi</h4></div>';
	$saatler = array('11','12','13','14','15','16','17','18','19');
}
if ($today == "Tue") {
	$bugun = "sal";
	$content .= ' <div> <h4>Salı</h4></div>';
	$saatler = array('11','12','13','14','15','16','17','18','19');
}

if ($today == "Wed") {
	$bugun = "car";
	$content .= ' <div> <h4>Çarşamba</h4></div>';
	$saatler = array('11','12','13','14','15','16','17','18','19');
}

if ($today == "Thu") {
	$bugun = "per";
	$content .= ' <div> <h4>Perşembe</h4></div>';
	$saatler = array('11','12','13','14','15','16','17','18','19');
}

if ($today == "Fri") {
	$bugun = "cum";
	$content .= ' <div> <h4>Cuma</h4></div>';
	$saatler = array('11','12','13','14','15','16','17','18','19');
}

if ($today == "Sat") {
	$bugun = "cts";
	$content .= ' <div> <h4>Cumartesi</h4></div>';
	$saatler = array('9','10','11','12','13','14','15','16','17');
}

if ($today == "Sun") {
	$bugun = "paz";
	$content .= ' <div> <h4>Pazar</h4></div>';
	$saatler = array('9','10','11','12','13','14','15','16','17');
}



//here a div for collassible buttons
$content .= '<div style="width: 1000px;">';

//generata sms button is here
$content .= '<form method="POST">';
$content .= '</form>';

$content .= '';

//gruplar seçiliyor
$wholegroup = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group;", ARRAY_A);
foreach ($wholegroup as $wgt){
	$std1 = $wgt['1_student_id'];
	$std2 = $wgt['2_student_id'];
	$std3 = $wgt['3_student_id'];
	$std4 = $wgt['4_student_id'];
	$std5 = $wgt['5_student_id'];
	$std6 = $wgt['6_student_id'];
	$groupname = $wgt['group_name'];
	//gruptaki öğrenciler bir diziye ekleniyor
	$grupstudents = array($std1, $std2, $std3, $std4, $std5, $std6);
	foreach ($grupstudents as $valueid) {
		if ($valueid != 0) {

			$wholestuid = '';
			$studentname = '';
			$wholestudent = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$valueid';", ARRAY_A);

			foreach ($wholestudent as $wtt){
				$wholestuid = $wtt['student_id'];
				$studentname = $wtt['name']." ".$wtt['surname'];
			}

			for ($i=1; $i < 10 ; $i++) { 

				$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek, {$wpdb->prefix}mp_teacher WHERE `vw_name` LIKE '% $i. %' AND `$bugun` LIKE '% $groupname %' AND {$wpdb->prefix}mp_virtualweek.teacher_id = {$wpdb->prefix}mp_teacher.teacher_id;", ARRAY_A);
				foreach ($sty as $stu){


					$studentInfo = $stu[$bugun];
					$stdInfo = explode (" ",$studentInfo);
					$stuid = $stdInfo[2];
					$branch = $stdInfo[1];
					$graname = $stdInfo[3];
					$teachername = $stu['name']." ".$stu['surname'];
					$teachervwid = $stu['teacher_id'];

					$stya = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE `student_id` = '$wholestuid' AND `teacher_id` = '$teachervwid' AND hangiders = '$i' AND `date_info` = '$tarih';", ARRAY_A);
					if ($stya == null) {
						
						// ders kayılarında bulunmayan smsler
						$content .= '<button type="button" id="<?php echo $i; ?>" class="collapsible"> '.$saatler[$i-1].':00' . $stu[$bugun]. ' | ' . $teachername . '</button>';
						$content .= '<div class="content">';
						$content .= '<p>Bu ders, "ders kayıtları" tablosunda bulunmamaktadır.</p>';
						$content .= '</div>';	


					}else{
						foreach ($stya as $stua){
							$lessonrecordid = $stua['lr_id'];
							$sms = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_sms WHERE `lr_id` = '$lessonrecordid';", ARRAY_A);
							if ($sms == null) {
								//senkronize edilmeyen smsler
								$content .= '<button type="button" id="<?php echo $i; ?>" class="collapsible">' . $saatler[$i-1].':00 '.$stu[$bugun].' | '.$teachername .'</button>';
								$content .= '<div class="content">';
								$content .= '<p>SMS\'ler senkronize edilmedi.</p>';
								$content .= '</div>';	

							}else{
								foreach ($sms as $smskey) {
									if ($smskey['is_sent'] == 0) {                          

										$content .= '<button type="button" id="'.$wholestuid.$i.'" class="collapsibleStart">'. $saatler[$i-1].':00 '.$stu[$bugun].' | '.$teachername .'.</button>';
										$content .= '<div class="content">';
										$content .= '<div id="'.$wholestuid.$i.'response_div"></div>';
										$content .= '<input type="hidden" name="smsid" id="'.$wholestuid.$i.'smsid" value="'.$smskey["sms_id"].'">';
										$content .= '<h4>SMS numarası</h4>';
										$content .= '<input type="textarea" name="numara" id="'.$wholestuid.$i.'numara" value="'.$smskey["parent_num"].'"><br>';
										$content .= '<h4>Mesaj</h4>';
										$content .= '<input type="text" name="mesaj" id="'.$wholestuid.$i.'mesaj" style="width: 800px;" value="'.$smskey["sms_text"].'">';
										$content .= '<input type="submit" name="smsgonder" id="smsgonder" onclick="send_a_sms('. $wholestuid.$i. ');" value="SMS Gönder">';
										$content .= '</div>';

									}else{
										$content .= '<button type="button" id="'.$wholestuid.$i.'" class="collapsibleFinish">'.$saatler[$i-1].':00 '.$stu[$bugun].' | '.$teachername.'</button>';
										$content .= '<div class="content">';
										$content .= '<h4>SMS numarası</h4>';
										$content .= '<h5>'.$smskey['parent_num'].'</h5>';
										$content .= '<h4>Mesaj</h4>';
										$content .= '<h5>'.$smskey['sms_text'].'</h5>';
										$content .= '</div>';
										
									}
								}
							}
						}
					}
				}
			}
		}
	}
}

$wholestudent = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE active = '1' ORDER BY name, surname ASC ;", ARRAY_A);
foreach ($wholestudent as $wtt){
	$wholestuid = $wtt['student_id'];
	$studentname = $wtt['name']." ".$wtt['surname'];

	for ($i=1; $i < 10 ; $i++) { 
		$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek, {$wpdb->prefix}mp_teacher WHERE `vw_name` LIKE '% $i. %' AND `$bugun` LIKE '% $wholestuid %' AND {$wpdb->prefix}mp_virtualweek.teacher_id = {$wpdb->prefix}mp_teacher.teacher_id;", ARRAY_A);
		foreach ($sty as $stu){


			$studentInfo = $stu[$bugun];
			$stdInfo = explode (" ",$studentInfo);
			$stuid = $stdInfo[2];
			$branch = $stdInfo[1];
			$graname = $stdInfo[3];
			$teachername = $stu['name']." ".$stu['surname'];
			$teachervwid = $stu['teacher_id'];

			$stya = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE `student_id` = '$wholestuid' AND `teacher_id` = '$teachervwid' AND hangiders = '$i' AND `date_info` = '$tarih';", ARRAY_A);
			if ($stya == null) {
				// ders kayılarında bulunmayan smsler
				$content .= '<button type="button" id="<?php echo $i; ?>" class="collapsible"> '.$saatler[$i-1].':00' . $stu[$bugun]. ' | ' . $teachername . '</button>';
				$content .= '<div class="content">';
				$content .= '<p>Bu ders, "ders kayıtları" tablosunda bulunmamaktadır.</p>';
				$content .= '</div>';	
			}else{
				foreach ($stya as $stua){
					$lessonrecordid = $stua['lr_id'];
					$sms = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_sms WHERE `lr_id` = '$lessonrecordid';", ARRAY_A);
					if ($sms == null) {
						//senkronize edilmeyen smsler
						$content .= '<button type="button" id="<?php echo $i; ?>" class="collapsible">' . $saatler[$i-1].':00 '.$stu[$bugun].' | '.$teachername .'</button>';
						$content .= '<div class="content">';
						$content .= '<p>SMS\'ler senkronize edilmedi.</p>';
						$content .= '</div>';
					}else{
						foreach ($sms as $smskey) {
							if ($smskey['is_sent'] == 0) {       

								$content .= '<button type="button" id="'.$wholestuid.$i.'" class="collapsibleStart">'. $saatler[$i-1].':00 '.$stu[$bugun].' | '.$teachername .'.</button>';
								$content .= '<div class="content">';
								$content .= '<div id="'.$wholestuid.$i.'response_div"></div>';
								$content .= '<input type="hidden" name="smsid" id="'.$wholestuid.$i.'smsid" value="'.$smskey["sms_id"].'">';
								$content .= '<h4>SMS numarası</h4>';
								$content .= '<input type="textarea" name="numara" id="'.$wholestuid.$i.'numara" value="'.$smskey["parent_num"].'"><br>';
								$content .= '<h4>Mesaj</h4>';
								$content .= '<input type="text" name="mesaj" id="'.$wholestuid.$i.'mesaj" style="width: 800px;" value="'.$smskey["sms_text"].'">';
								$content .= '<input type="submit" name="smsgonder" id="smsgonder" onclick="send_a_sms('. $wholestuid.$i. '); " value="SMS Gönder">';
								$content .= '</div>';
							}else{

								$content .= '<button type="button" id="'.$wholestuid.$i.'" class="collapsibleFinish">'.$saatler[$i-1].':00 '.$stu[$bugun].' | '.$teachername.'</button>';
								$content .= '<div class="content">';
								$content .= '<h4>SMS numarası</h4>';
								$content .= '<h5>'.$smskey['parent_num'].'</h5>';
								$content .= '<h4>Mesaj</h4>';
								$content .= '<h5>'.$smskey['sms_text'].'</h5>';
								$content .= '</div>';
							}
						}
					}
				}
			}
		}
	}
}
$content .= '</div>';
$content .= '<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
</script>
<script>
    var colls = document.getElementsByClassName("collapsibleStart");
    var j;

    for (j = 0; j < colls.length; j++) {
        colls[j].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
</script>
<script>
    var collf = document.getElementsByClassName("collapsibleFinish");
    var k;

    for (k = 0; k < collf.length; k++) {
        collf[k].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
</script>
<script>
    jQuery(document).ready(function(){
        var getUrl = "<?php echo $smsgetURL;?>"
        function getsmsdata()
        {
            console.log("Selaaam");
            var fdi = new FormData();
            fdi.append("start","1"); 
            posttophp(fdi, getUrl, get_full_sms);
        }   
        getsmsdata();
    });
</script>';
$returning = [];
$returning['success'] = 1;
$returning['content'] = $content;
echo json_encode($returning);
}
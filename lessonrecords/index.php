<?php
$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

$renewUrl = site_url().'/wp-content/plugins/meeting-parents/lessonrecords/process.php';

if (isset($_POST['getlr']) && $_POST['getlr'] == '1' ) {
	global $wpdb;
	$tarih = '';
	$tarih .= $_POST['date'];
	$pazartesiBirTarih = new DateTime('2019-4-1');	
	$girilentarih= new DateTime($tarih);
	$interval= $pazartesiBirTarih->diff($girilentarih);
	$gunfarkı = (int)$interval->format('%a');
	$saatler = array('11','12','13','14','15','16','17','18','19');
	$daysofweek = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
	$today = $daysofweek[$gunfarkı % 7];
	$bugun = '';

	if ($today == "Mon") {
		$bugun = "pts";
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}

	if ($today == "Tue") {
		$bugun = "sal";
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}

	if ($today == "Wed") {
		$bugun = "car";
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}

	if ($today == "Thu") {
		$bugun = "per";
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}

	if ($today == "Fri") {
		$bugun = "cum";
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}

	if ($today == "Sat") {
		$bugun = "cts";
		$saatler = array('9','10','11','12','13','14','15','16','17');
	}

	if ($today == "Sun") {
		$bugun = "paz";
		$saatler = array('9','10','11','12','13','14','15','16','17');
	}

	$teaid = $_POST['teaid'];
	$content = '';
	$content .= $tarih.'<br/>';
	$content .= $bugun.'<br/>';
	$content .= '<style type="text/css">				
	.collapsible {
		background-color: #FA675F;
		color: white;
		cursor: pointer;
		padding: 10px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 15px;
		margin-top: 15px;
	}


	.collapsibleStart {
		background-color: #F4CB89;
		color: white;
		cursor: pointer;
		padding: 10px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 15px;
		margin-top: 15px;
		color: black;
	}


	.collapsibleFinish {
		background-color: #509400;
		color: white;
		cursor: pointer;
		padding: 10px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 15px;
		margin-top: 15px;
	}
	.startButton {
		border: 0px;
		margin: 10px;
		background-color: #F4CB89;
		min-height: 30px;
		min-width: 200px;
		color: black;
	}
	.finishbutton {
		border: 0px;
		margin: 10px;
		background-color: #509400;
		min-height: 30px;
		color: white;
		min-width: 200px;
	}


	.content {
		padding: 0 18px;
		display: none;
		overflow: hidden;
		background-color: #f1f1f1;
	}
	</style>';
	$content .= 'Günün Dersleri';
	for ($i=1; $i < 10 ; $i++) { 

		$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE vw_name = '$teaid - $i. Saat' ;", ARRAY_A);
		foreach ($sty as $stu){
			if ($stu[$bugun] != "freeday" && $stu[$bugun] != "0") {
				$studentInfo = $stu[$bugun];
				$stdInfo = explode (" ",$studentInfo);
				$stuid = $stdInfo[2];
				$branch = $stdInfo[1];
				$braid = 0;
				$graname = $stdInfo[3];
				$bra = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_branch WHERE name = '$branch' ;", ARRAY_A);
				foreach ($bra as $brarw){
					$braid = $brarw['branch_id'];
				} 
				if ($stuid !="G") {

					$record = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE student_id = '$stuid' AND date_info = '$tarih' AND branch_id = $braid AND teacher_id = '$teaid' AND `hangiders` = '$i';", ARRAY_A);
					if ($record == null) {
						$content .= '<button type="button" id="'.$i.'" class="collapsible">'.$saatler[$i-1].':00 '.$stu[$bugun].'</button>';
						$content .= '<div class="content">';
						$content .= '<input type="hidden" name="hangihoca" value="'.$teaid.'">';
						$content .= '<input type="hidden" name="hangisaat" value="'.$i.'">';
						$content .= '<input type="hidden" name="stuid" value="'.$stuid.'">';
						$content .= '<input type="hidden" name="braid" value="'.$braid.'">';
						$content .= '<button class="startButton" name="baslat">Ders Başladı</button>';
						$content .= '</div>';
					}else{ 
						foreach ($record as $rrow) {
							$homwork = $rrow['homework_status'];
							if ($homwork == "0") {

								$content .= '<button type="button" id="'.$i.'" class="collapsibleStart">'.$saatler[$i-1].':00 '.$stu[$bugun].'</button>';
								$content .= '<div class="content">';
								$content .= '<input type="hidden" name="hangihoca" value="'.$teaid.'">';
								$content .= '<input type="hidden" name="hangisaat" value="'.$i.'">';
								$content .= '<input type="hidden" name="namnam" value="'.$graname.'">';
								$content .= '<input type="hidden" name="stuid" value="'.$stuid.'">	';
								$content .= '<br><label for="lesson">İşlenen Konu:</label><br>';
								$content .= '<input type="text" name="lesson" placeholder="Köklü ifadeler -Testokul Kitabından- bitirildi"><br>';
								$content .= '<br><label for="homework">Ödev Kontrolü:</label><br>';
								$content .= '<select name="homework" id="homework">';
								$content .= '<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>';
								$content .= '<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>';
								$content .= '<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>';
								$content .= '</select>';
								$content .= '<br>';
								$content .= '<br><label for="lesson">Bir Sonraki Ödev:</label><br>';
								$content .= '<input type="text" name="nextwork" placeholder="3-4-5 Yayınları 251-254 sayfaları"><br>';
								$content .= '<br>';
								$content .= '<label><input type="checkbox" name="uykusuzluk">   Uykusuzluk Belirtileri</label><br>';
								$content .= '<label><input type="checkbox" name="katilmama">   Derse Katılmama</label><br>';
								$content .= '<label><input type="checkbox" name="teknik">   Teknik Sorunları Bahane Etme</label><br>';
								$content .= '<button class="finishbutton" name="bitir">DERSİ BİTİR</button>';
								$content .= '</div>';

							}else{
								$content .= '<button type="button" id="'.$i.'" class="collapsibleFinish">'.$saatler[$i-1].':00 '.$stu[$bugun].'</button>';
								$content .= '<div class="content">';
								$konu = $rrow['lesson_status'];
								$homework = $rrow['homework_status'];
								$nextwork = $rrow['next_homework'];
								$content .= '<p>'.$konu.'</p>';
								$content .= '<p>'.$homework.'</p>';
								$content .= '<p>'.$nextwork.'</p>';


								$content .= '<input type="text" name="lrid" id="'.$i.'lrid" value="'.$rrow['lr_id'].'">';
								$content .= '<input type="text" name="link" id="'.$i.'hders" value="'.$rrow['hangiders'].'">';
								$content .= '<input type="text" name="link" id="'.$i.'link" value="'.$rrow['lesson_url'].'">';
								$content .= '<input type="submit" name="gonder" onclick="renew_lr(\''.$i.$stdwjp.'\', \''.$renewUrl.'\' )" id="'.$i.'gonder">';
								$content .= '</div>';
							}
						}
					}
				} else{
					$group = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group WHERE group_name = '$graname' ;", ARRAY_A);
					foreach ($group as $grow){
						$std1 = $grow['1_student_id'];
						$std2 = $grow['2_student_id'];
						$std3 = $grow['3_student_id'];
						$std4 = $grow['4_student_id'];
						$std5 = $grow['5_student_id'];
						$std6 = $grow['6_student_id'];
						$sn1 = "YOK";
						$sn2 = "YOK";
						$sn3 = "YOK";
						$sn4 = "YOK";
						$sn5 = "YOK";
						$sn6 = "YOK";

						$s1 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$std1';", ARRAY_A);
						foreach ($s1 as $key => $r1) {
							$sn1 = $r1['name']." ".$r1['surname'];
						}
						$s2 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$std2' ", ARRAY_A);
						foreach ($s2 as $key => $r2) {
							$sn2 = $r2['name']." ".$r2['surname'];
						}										
						$s3 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$std3' ", ARRAY_A);
						foreach ($s3 as $key => $r3) {
							$sn3 = $r3['name']." ".$r3['surname'];
						}
						if ($std4 !=0 ) {									
							$s4 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$std4';", ARRAY_A);
							foreach ($s4 as $key => $r4) {
								$sn4 = $r4['name']." ".$r4['surname'];
							}	
						}								
						if ($std5 !=0 ) {
							$s5 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$std5';", ARRAY_A);
							foreach ($s5 as $key => $r5) {
								$sn5 = $r5['name']." ".$r5['surname'];
							}		
						}								
						if ($std6 !=0 ) {
							$s6 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$std6' ", ARRAY_A);
							foreach ($s6 as $key => $r6) {
								$sn6 = $r6['name']." ".$r6['surname'];
							}
						}
						$stubir = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE student_id = '$std1' AND branch_id ='$braid' AND date_info = '$tarih' AND `hangiders` = '$i' ;", ARRAY_A);
						if ($stubir == null) {
							$content .= '<button type="button" id="'.$i.'" class="collapsible">'.$saatler[$i-1].':00 '.$stu[$bugun].'</button>';
							$content .= '<div class="content">';
							$content .= '<input type="hidden" name="hangihoca" value="'.$teaid.'">';
							$content .= '<input type="hidden" name="hangisaat" value="'.$i.'">';
							$content .= '<input type="hidden" name="st1" value="'.$std1.'">';
							$content .= '<input type="hidden" name="st2" value="'.$std2.'">';
							$content .= '<input type="hidden" name="st3" value="'.$std3.'">';
							$content .= '<input type="hidden" name="st4" value="'.$std4.'">';
							$content .= '<input type="hidden" name="st5" value="'.$std5.'">';
							$content .= '<input type="hidden" name="st6" value="'.$std6.'">';
							$content .= '<input type="hidden" name="braidg" value="'.$braid.'">';
							$content .= '<button class="startButton" name="Gbaslat">Ders Başladı</button>';
							$content .= '</div>';

						}else{
							foreach ($stubir as $rrow) {
								$homwork = $rrow['homework_status'];
								if ($homwork == "0") {
									$content .= '<button type="button" id="'.$i.'" class="collapsibleStart">'.$saatler[$i-1].':00 '.$stu[$bugun].'</button>';
									$content .= '<div class="content">';
									$konu = "bilinmiyor";
									$nexttopicRank = 0;

									$content .= '<input type="hidden" name="hangihoca" value="'.$teaid.'">';
									$content .= '<input type="hidden" name="hangisaat" value="'.$i.'">';
									$content .= '<input type="hidden" name="st1" value="'.$std1.'">';
									$content .= '<input type="hidden" name="st2" value="'.$std2.'">';
									$content .= '<input type="hidden" name="st3" value="'.$std3.'">';
									$content .= '<input type="hidden" name="st4" value="'.$std4.'">';
									$content .= '<input type="hidden" name="st5" value="'.$std5.'">';
									$content .= '<input type="hidden" name="st6" value="'.$std6.'">';
									$content .= '<br><label for="lesson">İşlenen Konu:</label><br>';
									$content .= '<input type="text" name="lesson" placeholder="Köklü ifadeler -Testokul Kitabından- bitirildi"><br>';
									$content .= '<br><label for="nextwork">Bir Sonraki Ödev:</label><br>';
									$content .= '<input type="text" name="nextwork" placeholder="3-4-5 Yayınları 251-254 sayfaları"><br>';
									$content .= '<br>';

									$content .= '<br><br><br><label for="lesson1">'.$sn1.'</label>';
									$content .= '<br><label for="homework">Ödev Kontrolü:</label><br>';
									$content .= '<select name="homework1" id="homework1">';
									$content .= '<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>';
									$content .= '<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>';
									$content .= '<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>';
									$content .= '</select>';
									$content .= '<br>';
									$content .= '<label><input type="checkbox" name="yok1">   DERSE GELMEDİ!</label><br>';
									$content .= '<label><input type="checkbox" name="uykusuzluk1">   Uykusuzluk Belirtileri</label><br>';
									$content .= '<label><input type="checkbox" name="katilmama1">   Derse Katılmama</label><br>';
									$content .= '<label><input type="checkbox" name="teknik1">   Teknik Sorunları Bahane Etme</label><br>';							

									$content .= '<br><br><br><label for="lesson2">'.$sn2.'</label>';
									$content .= '<br><label for="homework">Ödev Kontrolü:</label><br>';
									$content .= '<select name="homework2" id="homework2">';
									$content .= '<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>';
									$content .= '<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>';
									$content .= '<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>';
									$content .= '</select>';
									$content .= '<br>';
									$content .= '<label><input type="checkbox" name="yok2">   DERSE GELMEDİ!</label><br>';
									$content .= '<label><input type="checkbox" name="uykusuzluk2">   Uykusuzluk Belirtileri</label><br>';
									$content .= '<label><input type="checkbox" name="katilmama2">   Derse Katılmama</label><br>';
									$content .= '<label><input type="checkbox" name="teknik2">   Teknik Sorunları Bahane Etme</label><br>';

									$content .= '<br><br><br><label for="lesson3">'.$sn3.'</label>';
									$content .= '<br><label for="homework">Ödev Kontrolü:</label><br>';
									$content .= '<select name="homework3" id="homework3">';
									$content .= '<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>';
									$content .= '<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>';
									$content .= '<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>';
									$content .= '</select>';
									$content .= '<br>';
									$content .= '<label><input type="checkbox" name="yok3">   DERSE GELMEDİ!</label><br>';
									$content .= '<label><input type="checkbox" name="uykusuzluk3">   Uykusuzluk Belirtileri</label><br>';
									$content .= '<label><input type="checkbox" name="katilmama3">   Derse Katılmama</label><br>';
									$content .= '<label><input type="checkbox" name="teknik3">   Teknik Sorunları Bahane Etme</label><br>';

									$content .= '<br><br><br><label for="lesson4">'.$sn4.'</label>';
									$content .= '<br><label for="homework">Ödev Kontrolü:</label><br>';
									$content .= '<select name="homework4" id="homework4">';
									$content .= '<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>';
									$content .= '<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>';
									$content .= '<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>';
									$content .= '</select>';
									$content .= '<br>';
									$content .= '<label><input type="checkbox" name="yok4">   DERSE GELMEDİ!</label><br>';
									$content .= '<label><input type="checkbox" name="uykusuzluk4">   Uykusuzluk Belirtileri</label><br>';
									$content .= '<label><input type="checkbox" name="katilmama4">   Derse Katılmama</label><br>';
									$content .= '<label><input type="checkbox" name="teknik4">   Teknik Sorunları Bahane Etme</label><br>';

									$content .= '<br><br><br><label for="lesson5">'.$sn5.'</label>';
									$content .= '<br><label for="homework">Ödev Kontrolü:</label><br>';
									$content .= '<select name="homework5" id="homework5">';
									$content .= '<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>';
									$content .= '<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>';
									$content .= '<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>';
									$content .= '</select>';
									$content .= '<br>';
									$content .= '<label><input type="checkbox" name="yok5">   DERSE GELMEDİ!</label><br>';
									$content .= '<label><input type="checkbox" name="uykusuzluk5">   Uykusuzluk Belirtileri</label><br>';
									$content .= '<label><input type="checkbox" name="katilmama5">   Derse Katılmama</label><br>';
									$content .= '<label><input type="checkbox" name="teknik5">   Teknik Sorunları Bahane Etme</label><br>';

									$content .= '<br><br><br><label for="lesson6">'.$sn6.'</label>';
									$content .= '<br><label for="homework">Ödev Kontrolü:</label><br>';
									$content .= '<select name="homework6" id="homework6">';
									$content .= '<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>';
									$content .= '<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>';
									$content .= '<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>';
									$content .= '</select>';
									$content .= '<br>';
									$content .= '<label><input type="checkbox" name="yok6">   DERSE GELMEDİ!</label><br>';
									$content .= '<label><input type="checkbox" name="uykusuzluk6">   Uykusuzluk Belirtileri</label><br>';
									$content .= '<label><input type="checkbox" name="katilmama6">   Derse Katılmama</label><br>';
									$content .= '<label><input type="checkbox" name="teknik6">   Teknik Sorunları Bahane Etme</label><br>';

									$content .= '<button class="finishbutton" name="Gbitir">DERSİ BİTİR</button>';
									$content .= '</div>';

								}else{
									$content .= '<button type="button" id="'.$i.'" class="collapsibleFinish">'.$saatler[$i-1].':00 '.$stu[$bugun].'</button>';
									$content .= '<div class="content">';


									$studentsall = array($std1,$std2,$std3,$std4,$std5,$std6);
									foreach ($studentsall as $stdwjp) {

										$theTopic = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records, {$wpdb->prefix}mp_student  WHERE {$wpdb->prefix}mp_lesson_records.student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_lesson_records.date_info ='$tarih' AND {$wpdb->prefix}mp_lesson_records.student_id = 
											'$stdwjp' AND {$wpdb->prefix}mp_lesson_records.teacher_id = '$teaid' AND {$wpdb->prefix}mp_lesson_records.hangiders = '$i';", ARRAY_A);
										foreach ($theTopic as $ttrow) {					
											$lessons = $ttrow['lesson_status'];
											$homworks = $ttrow['homework_status'];
											$nextwork = $ttrow['next_homework'];
											$name = $ttrow['name']." ".$ttrow['surname'];


											$content .= '<h6>'.$name.'</h6>';
											$content .= '<p>'.$lessons.'</p>';
											$content .= '<p>'.$homworks.'</p>';
											$content .= '<p>'.$nextwork.'</p>';

											$content .= '<input type="text" name="lrid" id="'.$i.$stdwjp.'lrid" value="'.$ttrow['lr_id'].'">';
											$content .= '<input type="text" name="link" id="'.$i.$stdwjp.'hders" value="'.$ttrow['hangiders'].'">';
											$content .= '<input type="text" name="link" id="'.$i.$stdwjp.'link" value="'.$ttrow['lesson_url'].'">';
											$content .= '<input type="submit" name="gonder" onclick="renew_lr(\''.$i.$stdwjp.'\', \''.$renewUrl.'\' )" id="'.$i.'gonder">';
										}
									}
									$content .= '</div>';		
								}
							}
						}
					}
				}
			}
		} 

	// soru çözümleri

		$birincisaat = $i.'1';
		$ikincisaat = $i.'2';
		$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_questionprocess.qp_student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$teaid' AND {$wpdb->prefix}mp_questionprocess.qp_hour = '$birincisaat' AND {$wpdb->prefix}mp_questionprocess.qp_day = '$bugun' AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$teaid' ;", ARRAY_A);
		foreach ($sty as $stu){
			$qpstudent_id = $stu['qp_student_id'];
			$record = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_qprecords WHERE student_id = '$qpstudent_id' AND date_info = '$tarih' AND teacher_id = '$teaid';", ARRAY_A);
			if ($record == null) {
				$content .= '<button type="button" id="'.$i.'" class="collapsible">'.$saatler[$i-1].':00 '.$stu['name'].' '.$stu['surname'].'</button>';	
				$content .= '<div class="content">';	
				$content .= '<input type="hidden" name="hangihoca" value="'.$teaid.'">';	
				$content .= '<input type="hidden" name="hangisaat" value="'.$i.'">';	
				$content .= '<input type="hidden" name="qpstudent_id" value="'.$qpstudent_id.'">';	
				$content .= '<input type="hidden" name="braid" value="'.$braid.'">';	
				$content .= '<button class="startButton" name="baslatsc1">Ders Başladı</button>';	
				$content .= '</div>';	
			}else{
				foreach ($record as $recrow) {
					$qprid = $recrow['qpr_id'];
					$finishtime = $recrow['finish_time'];
					$stuasq = $recrow['s_asked'];
					$teaasq = $recrow['t_asked'];
					if ($finishtime == '00:00:00') {
						$content .= '<button type="button" id="'.$i.'" class="collapsibleStart">'.$saatler[$i-1].':00 '.$stu['name'].' '.$stu['surname'].'</button>';	
						$content .= '<div class="content">';	
						$content .= '<input type="hidden" name="hangihoca" value="'. $teaid.'">';	
						$content .= '<input type="hidden" name="hangisaat" value="'. $i.'">';	
						$content .= '<input type="hidden" name="qpr_id" value="'. $qprid.'">';	
						$content .= '<label for="ogrsoru">Öğrencinin Sorduğu Soru Sayısı</label><br>';	
						$content .= '<input type="text" name="ogrsoru" id="ogrsoru"><br>';	
						$content .= '<label for="teasoru">Öğretmenin Sorduğu Soru Sayısı</label><br>';	
						$content .= '<input type="text" name="teasoru" id="teasoru"><br>';	
						$content .= '<button class="finishbutton" name="bitirsc1">Dersi Tamamla</button>';	
						$content .= '</div>';	



					}else{
						$content .= '<button type="button" id="'.$i.'" class="collapsibleFinish">'.$saatler[$i-1].':00 '.$stu['name'].' '.$stu['surname'].'</button>';	
						$content .= '<div class="content">';	
						$content .= '<h6>Öğretmen Soru Sayısı: '. $teaasq. '</h6>';	
						$content .= '<h6>Öğrenci Soru Sayısı: '. $stuasq . '</h6>';	
						$content .= '</div>';	
					}
				}
			}
		}
		$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_questionprocess.qp_student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$teaid' AND {$wpdb->prefix}mp_questionprocess.qp_hour = '$ikincisaat' AND {$wpdb->prefix}mp_questionprocess.qp_day = '$bugun' AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$teaid' ;", ARRAY_A);
		foreach ($sty as $stu){
			$qpstudent_id = $stu['qp_student_id'];
			$record = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_qprecords WHERE student_id = '$qpstudent_id' AND date_info = '$tarih' AND teacher_id = '$teaid';", ARRAY_A);
			if ($record == null) {
				$content .= '<button type="button" id="'.$i.'" class="collapsible">'.$saatler[$i-1].':25 '.$stu['name'].' '.$stu['surname'].'</button>';	
				$content .= '<div class="content">';	
				$content .= '<input type="hidden" name="hangihoca" value="'.$teaid.'">';	
				$content .= '<input type="hidden" name="hangisaat" value="'.$i.'">';	
				$content .= '<input type="hidden" name="qpstudent_id" value="'.$qpstudent_id.'">';	
				$content .= '<input type="hidden" name="braid" value="'.$braid.'">';	
				$content .= '<button class="startButton" name="baslatsc1">Ders Başladı</button>';	
				$content .= '</div>';	

			}else{

				foreach ($record as $recrow) {
					$qprid = $recrow['qpr_id'];
					$finishtime = $recrow['finish_time'];
					$stuasq = $recrow['s_asked'];
					$teaasq = $recrow['t_asked'];
					if ($finishtime == '00:00:00') {
																			# code...
						$content .= '<button type="button" id="'.$i.'" class="collapsibleStart">'.$saatler[$i-1].':25 '.$stu['name'].' '.$stu['surname'].'</button>';	
						$content .= '<div class="content">';	
						$content .= '<input type="hidden" name="hangihoca" value="'. $teaid.'">';	
						$content .= '<input type="hidden" name="hangisaat" value="'. $i.'">';	
						$content .= '<input type="hidden" name="qpr_id" value="'. $qprid.'">';	
						$content .= '<label for="ogrsoru">Öğrencinin Sorduğu Soru Sayısı</label><br>';	
						$content .= '<input type="text" name="ogrsoru" id="ogrsoru"><br>';	
						$content .= '<label for="teasoru">Öğretmenin Sorduğu Soru Sayısı</label><br>';	
						$content .= '<input type="text" name="teasoru" id="teasoru"><br>';	
						$content .= '<button class="finishbutton" name="bitirsc1">Dersi Tamamla</button>';	
						$content .= '</div>';	

					}else{
						$content .= '<button type="button" id="'.$i.'" class="collapsibleFinish">'.$saatler[$i-1].':25 '.$stu['name'].' '.$stu['surname'].'</button>';	
						$content .= '<div class="content">';	
						$content .= '<h6>Öğretmen Soru Sayısı: '. $teaasq. '</h6>';	
						$content .= '<h6>Öğrenci Soru Sayısı: '. $stuasq . '</h6>';	
						$content .= '</div>';	
					}						
				}
			}
		}
	}
}
$content .= '<script>
var coll = document.getElementsByClassName("collapsible");
var ci;
for (ci = 0; ci < coll.length; ci++) {
	coll[ci].addEventListener("click", function() {
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
		<script>var coll = document.getElementsByClassName("collapsibleStart");
		var csi;
		for (csi = 0; csi < coll.length; csi++) {
			coll[csi].addEventListener("click", function() {
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
				<script>var coll = document.getElementsByClassName("collapsibleFinish");
				var cfi;
				for (cfi = 0; cfi < coll.length; cfi++) {
					coll[cfi].addEventListener("click", function() {
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
						';	
						$returning = [];
						$returning['success'] = 1;
						$returning['content'] = $content;
						echo json_encode($returning);











<style type="text/css">				
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
	}</style>
	<?php 
	global $wpdb;
	global $current_user;
	wp_get_current_user();
	date_default_timezone_set('Europe/Istanbul');

	
	$saaat=date('H:i:s');
	$t=date('d-m-Y');
	$today = date("D",strtotime($t));
	$bugun = "<br>bugun<br>";
	$tarih = date("Y-m-d",strtotime($t));

	$saatler = array('11','12','13','14','15','16','17','18','19');


	?> <div> <h4><?php echo $tarih." ".date('H:i:s'); ?></h4></div> <?php
	
	if ($today == "Mon") {
		$bugun = "pts";
		?> <div> <h4><?php echo "Pazartesi"."<br>";; ?></h4></div> <?php
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}
	if ($today == "Tue") {
		$bugun = "sal";
		?> <div> <h4><?php echo "Salı"."<br>"; ?></h4></div> <?php
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}

	if ($today == "Wed") {
		$bugun = "car";
		?> <div> <h4><?php echo "Çarşamba"."<br>"; ?></h4></div> <?php
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}

	if ($today == "Thu") {
		$bugun = "per";
		?> <div> <h4><?php echo "Perşembe"."<br>"; ?></h4></div> <?php
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}

	if ($today == "Fri") {
		$bugun = "cum";
		?> <div> <h4><?php echo "Cuma"."<br>"; ?></h4></div> <?php
		$saatler = array('11','12','13','14','15','16','17','18','19');
	}

	if ($today == "Sat") {
		$bugun = "cts";
		?> <div> <h4><?php echo "Cumartesi"."<br>"; ?></h4></div> <?php
		$saatler = array('9','10','11','12','13','14','15','16','17');
	}

	if ($today == "Sun") {
		$bugun = "paz";
		?> <div> <h4><?php echo "Pazar"."<br>"; ?></h4></div> <?php
		$saatler = array('9','10','11','12','13','14','15','16','17');
	}



	$username = $current_user->user_login;

	$dizia = explode ("_",$username);


	//student
	if ($dizia[0] == "S") {
		?> <div> <h4><?php echo $current_user->display_name . "\n"; ?></h4></div> <?php
		$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_stuenter WHERE student_id = '$dizia[1]' AND `date` >= NOW() - INTERVAL 7 day", ARRAY_A);
		foreach ($sty as $stu){
			echo $stu['day_name'] . "<br>";
		}
	}

	// teacher 
	if ($dizia[0] == "T" && ($dizia[2] == "Irfan" || $dizia[2] == "Fatih" || $dizia[2] == "irfan")) {
		
		?> <div> <h4><?php echo $current_user->display_name . "\n"; ?></h4></div> <?php

		$wholeteacher = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_teacher WHERE active = '1' ;", ARRAY_A);
		foreach ($wholeteacher as $wtt){
			$wholeteaid = $wtt['teacher_id'];
			$teacherwhonamed = $wtt['name']." ".$wtt['surname'];
			echo $teacherwhonamed;
			for ($i=1; $i < 10 ; $i++) { 

				$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE vw_name = '$wholeteaid - $i. Saat' ;", ARRAY_A);
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

							$record = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE student_id = '$stuid' AND date_info = '$tarih' AND branch_id = $braid AND teacher_id = '$wholeteaid' AND `hangiders` = '$i';", ARRAY_A);
							if ($record == null) {
								?>
								<button type="button" id="<?php echo $i; ?>" class="collapsible"><?php echo $saatler[$i-1].":00 ".$stu[$bugun]; ?></button>
								<div class="content">

									<form method="POST">
										<input type="hidden" name="hangihoca" value="<?php echo $wholeteaid; ?>">
										<input type="hidden" name="hangisaat" value="<?php echo $i; ?>">
										<input type="hidden" name="stuid" value="<?php echo $stuid ?>">
										<input type="hidden" name="braid" value="<?php echo $braid ?>">
										<button class="startButton" name="baslat">Ders Başladı</button>
									</form>
									</div><?php 
								}else{
									foreach ($record as $rrow) {
										$homwork = $rrow['homework_status'];
										if ($homwork == "0") {
											?>
											<button type="button" id="<?php echo $i; ?>" class="collapsibleStart"><?php echo $saatler[$i-1].":00 ".$stu[$bugun]; ?></button>
											<div class="content">

												<form method="POST">
													<input type="hidden" name="hangihoca" value="<?php echo $wholeteaid; ?>">
													<input type="hidden" name="hangisaat" value="<?php echo $i; ?>">
													<input type="hidden" name="namnam" value="<?php echo $graname; ?>">
													<input type="hidden" name="stuid" value="<?php echo $stuid; ?>">												
													<br><label for="lesson">İşlenen Konu:</label><br>
													<input type="text" name="lesson" placeholder="Köklü ifadeler 'Testokul Kitabından' bitirildi"><br>
													<br><label for="homework">Ödev Kontrolü:</label><br>
													<select name="homework" id="homework">
														<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>
														<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>
														<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>
													</select>
													<br>
													<br><label for="lesson">Bir Sonraki Ödev:</label><br>
													<input type="text" name="nextwork" placeholder="3-4-5 Yayınları 251-254 sayfaları"><br>
													<br>
													<label><input type="checkbox" name="uykusuzluk">   Uykusuzluk Belirtileri</label><br>
													<label><input type="checkbox" name="katilmama">   Derse Katılmama</label><br>
													<label><input type="checkbox" name="teknik">   Teknik Sorunları Bahane Etme</label><br>
													<button class="finishbutton" name="bitir">DERSİ BİTİR</button>
												</form>
												</div><?php 
											}else{
												?>
												<button type="button" id="<?php echo $i; ?>" class="collapsibleFinish"><?php echo $saatler[$i-1].":00 ".$stu[$bugun]; ?></button>
												<div class="content">
													<?php 						
													$konu = $rrow['lesson_status'];
													$homework = $rrow['homework_status'];
													$nextwork = $rrow['next_homework'];
													$recid = $rrow['lr_id'];
													$urlne = $rrow['lesson_url'];
													?>
													<p><?php echo $konu; ?></p>	
													<p><?php echo $homework; ?></p>	
													<p><?php echo $nextwork; ?></p>

													<form method="POST">
														<input type="hidden" name="hangirecord" value="<?php echo $recid; ?>">
														<input type="text" name="hangirecordtext" value="<?php echo $recid; ?>">
														<input type="text" name="urltext" value="<?php echo $urlne; ?>">
														<input type="submit" name="ekleurl" value="Link Ekle">

													</form>

													</div><?php 
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
												}		}								
												if ($std5 !=0 ) {
													$s5 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$std5';", ARRAY_A);
													foreach ($s5 as $key => $r5) {
														$sn5 = $r5['name']." ".$r5['surname'];
													}		}								
													if ($std6 !=0 ) {
														$s6 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$std6' ", ARRAY_A);
														foreach ($s6 as $key => $r6) {
															$sn6 = $r6['name']." ".$r6['surname'];
														}}



														$stubir = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE student_id = '$std1' AND branch_id ='$braid' AND date_info = '$tarih' AND `hangiders` = '$i' ;", ARRAY_A);



														if ($stubir == null) {
															?>
															<button type="button" id="<?php echo $i; ?>" class="collapsible"><?php echo $saatler[$i-1].":00 ".$stu[$bugun]; ?></button>
															<div class="content">
																<form method="POST">
																	<input type="hidden" name="hangihoca" value="<?php echo $wholeteaid; ?>">
																	<input type="hidden" name="hangisaat" value="<?php echo $i; ?>">
																	<input type="hidden" name="st1" value="<?php echo $std1; ?>">
																	<input type="hidden" name="st2" value="<?php echo $std2; ?>">
																	<input type="hidden" name="st3" value="<?php echo $std3; ?>">
																	<input type="hidden" name="st4" value="<?php echo $std4; ?>">
																	<input type="hidden" name="st5" value="<?php echo $std5; ?>">
																	<input type="hidden" name="st6" value="<?php echo $std6; ?>">
																	<input type="hidden" name="braidg" value="<?php echo $braid ?>">
																	<button class="startButton" name="Gbaslat">Ders Başladı</button>
																	</form></div><?php 
																}else{
																	foreach ($stubir as $rrow) {
																		$homwork = $rrow['homework_status'];
																		if ($homwork == "0") {
																			?>
																			<button type="button" id="<?php echo $i; ?>" class="collapsibleStart"><?php echo $saatler[$i-1].":00 ".$stu[$bugun]; ?></button>
																			<div class="content">

																				<?php
																				$konu = "bilinmiyor";
																				$nexttopicRank = 0;

																				?>

																				<form method="POST">
																					<input type="hidden" name="hangihoca" value="<?php echo $wholeteaid; ?>">
																					<input type="hidden" name="hangisaat" value="<?php echo $i; ?>">
																					<input type="hidden" name="st1" value="<?php echo $std1; ?>">												
																					<input type="hidden" name="st2" value="<?php echo $std2; ?>">												
																					<input type="hidden" name="st3" value="<?php echo $std3; ?>">												
																					<input type="hidden" name="st4" value="<?php echo $std4; ?>">												
																					<input type="hidden" name="st5" value="<?php echo $std5; ?>">												
																					<input type="hidden" name="st6" value="<?php echo $std6; ?>">


																					<br><label for="lesson">İşlenen Konu:</label><br>
																					<input type="text" name="lesson" placeholder="Köklü ifadeler 'Testokul Kitabından' bitirildi"><br>

																					<br><label for="nextwork">Bir Sonraki Ödev:</label><br>
																					<input type="text" name="nextwork" placeholder="3-4-5 Yayınları 251-254 sayfaları"><br>
																					<br>



																					<br><br><br><label for="lesson1"><?php echo $sn1; ?></label>
																					<br><label for="homework">Ödev Kontrolü:</label><br>
																					<select name="homework1" id="homework1">
																						<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>
																						<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>
																						<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>
																					</select>
																					<br>
																					<label><input type="checkbox" name="yok1">   DERSE GELMEDİ!</label><br>
																					<label><input type="checkbox" name="uykusuzluk1">   Uykusuzluk Belirtileri</label><br>
																					<label><input type="checkbox" name="katilmama1">   Derse Katılmama</label><br>
																					<label><input type="checkbox" name="teknik1">   Teknik Sorunları Bahane Etme</label><br>

																					<br><br><br><label for="lesson2"><?php echo $sn2; ?></label>
																					<br><label for="homework">Ödev Kontrolü:</label><br>
																					<select name="homework2" id="homework2">
																						<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>
																						<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>
																						<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>
																					</select>
																					<br>
																					<label><input type="checkbox" name="yok2">   DERSE GELMEDİ!</label><br>
																					<label><input type="checkbox" name="uykusuzluk2">   Uykusuzluk Belirtileri</label><br>
																					<label><input type="checkbox" name="katilmama2">   Derse Katılmama</label><br>
																					<label><input type="checkbox" name="teknik2">   Teknik Sorunları Bahane Etme</label><br>						

																					<br><br><br><label for="lesson3"><?php echo $sn3; ?></label>
																					<br><label for="homework">Ödev Kontrolü:</label><br>
																					<select name="homework3" id="homework3">
																						<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>
																						<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>
																						<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>
																					</select>
																					<br>
																					<label><input type="checkbox" name="yok3">   DERSE GELMEDİ!</label><br>
																					<label><input type="checkbox" name="uykusuzluk3">   Uykusuzluk Belirtileri</label><br>
																					<label><input type="checkbox" name="katilmama3">   Derse Katılmama</label><br>
																					<label><input type="checkbox" name="teknik3">   Teknik Sorunları Bahane Etme</label><br>


																					<br><br><br><label for="lesson4"><?php echo $sn4; ?></label>
																					<br><label for="homework">Ödev Kontrolü:</label><br>
																					<select name="homework4" id="homework4">
																						<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>
																						<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>
																						<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>
																					</select>
																					<br>
																					<label><input type="checkbox" name="yok4">   DERSE GELMEDİ!</label><br>
																					<label><input type="checkbox" name="uykusuzluk4">   Uykusuzluk Belirtileri</label><br>
																					<label><input type="checkbox" name="katilmama4">   Derse Katılmama</label><br>
																					<label><input type="checkbox" name="teknik4">   Teknik Sorunları Bahane Etme</label><br>


																					<br><br><br><label for="lesson5"><?php echo $sn5; ?></label>
																					<br><label for="homework">Ödev Kontrolü:</label><br>
																					<select name="homework5" id="homework5">
																						<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>
																						<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>
																						<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>
																					</select>
																					<br>
																					<label><input type="checkbox" name="yok5">   DERSE GELMEDİ!</label><br>
																					<label><input type="checkbox" name="uykusuzluk5">   Uykusuzluk Belirtileri</label><br>
																					<label><input type="checkbox" name="katilmama5">   Derse Katılmama</label><br>
																					<label><input type="checkbox" name="teknik5">   Teknik Sorunları Bahane Etme</label><br>

																					<br><br><br><label for="lesson6"><?php echo $sn6; ?></label>
																					<br><label for="homework">Ödev Kontrolü:</label><br>
																					<select name="homework6" id="homework6">
																						<option style="color: red;" value="yok">(YOK)Ödev Videosu Yok/Ödevini Yapmadı</option>
																						<option style="color: red;" value="eksik">(EKSİK)Ödev Eksik ve Özensiz Yapıldı</option>
																						<option style="color: green;" value="tam">(TAM)Ödevler Tam ve Eksiksiz Yapıldı</option>
																					</select>
																					<br>
																					<label><input type="checkbox" name="yok6">   DERSE GELMEDİ!</label><br>
																					<label><input type="checkbox" name="uykusuzluk6">   Uykusuzluk Belirtileri</label><br>
																					<label><input type="checkbox" name="katilmama6">   Derse Katılmama</label><br>
																					<label><input type="checkbox" name="teknik6">   Teknik Sorunları Bahane Etme</label><br>

																					<br><br>
																					<button class="finishbutton" name="Gbitir">DERSİ BİTİR</button>
																				</form>
																				</div><?php 
																			}else{
																				?>
																				<button type="button" id="<?php echo $i; ?>" class="collapsibleFinish"><?php echo $saatler[$i-1].":00 ".$stu[$bugun]; ?></button>
																				<div class="content">
																					<?php 	
																					$studentsall = array($std1,$std2,$std3,$std4,$std5,$std6);
																					foreach ($studentsall as $stdwjp) {
																					# code...

																						$theTopic = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records, {$wpdb->prefix}mp_student  WHERE {$wpdb->prefix}mp_lesson_records.student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_lesson_records.date_info ='$tarih' AND {$wpdb->prefix}mp_lesson_records.student_id = 
																							'$stdwjp' AND {$wpdb->prefix}mp_lesson_records.teacher_id = '$wholeteaid' AND {$wpdb->prefix}mp_lesson_records.hangiders = '$i';", ARRAY_A);
																						foreach ($theTopic as $ttrow) {					
																							$lessons = $ttrow['lesson_status'];
																							$homworks = $ttrow['homework_status'];
																							$nextwork = $ttrow['next_homework'];
																							$name = $ttrow['name']." ".$ttrow['surname'];
																							$recid = $ttrow['lr_id'];
																							$urlne = $ttrow['lesson_url'];
																							?>
																							<h6><?php echo $name; ?></h6>
																							<p><?php echo $lessons; ?></p>
																							<p><?php echo $homworks; ?></p>
																							<p><?php echo $nextwork; ?></p>

																							<form method="POST">
																								<input type="hidden" name="hangirecord" value="<?php echo $recid; ?>">
																								<input type="text" name="hangirecordtext" value="<?php echo $recid; ?>">
																								<input type="text" name="urltext" value="<?php echo $urlne; ?>">
																								<input type="submit" name="ekleurl" value="Link Ekle">

																							</form>
																							<?php 
																						}												

																					}
																					?></div><?php 

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
														$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_questionprocess.qp_student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$wholeteaid' AND {$wpdb->prefix}mp_questionprocess.qp_hour = '$birincisaat' AND {$wpdb->prefix}mp_questionprocess.qp_day = '$bugun' AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$wholeteaid';", ARRAY_A);
														foreach ($sty as $stu){
															$qpstudent_id = $stu['qp_student_id'];
															$record = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_qprecords WHERE student_id = '$qpstudent_id' AND date_info = '$tarih' AND teacher_id = '$wholeteaid';", ARRAY_A);
															if ($record == null) {
																?>
																<button type="button" id="<?php echo $i; ?>" class="collapsible"><?php echo $saatler[$i-1].":00 ".$stu['name']." ".$stu['surname']; ?></button>
																<div class="content">

																	<form method="POST">
																		<input type="hidden" name="hangihoca" value="<?php echo $wholeteaid; ?>">
																		<input type="hidden" name="hangisaat" value="<?php echo $i; ?>">
																		<input type="hidden" name="qpstudent_id" value="<?php echo $qpstudent_id; ?>">
																		<input type="hidden" name="braid" value="<?php echo $braid; ?>">
																		<button class="startButton" name="baslatsc1">Ders Başladı</button>
																	</form>
																	</div><?php 
																}else{
																	foreach ($record as $recrow) {
																		$qprid = $recrow['qpr_id'];
																		$finishtime = $recrow['finish_time'];
																		$stuasq = $recrow['s_asked'];
																		$teaasq = $recrow['t_asked'];
																		if ($finishtime == '00:00:00') {
																			# code...

																			?>
																			<button type="button" id="<?php echo $i ?>" class="collapsibleStart"><?php echo $saatler[$i-1].":00 ".$stu['name']." ".$stu['surname']; ?></button>
																			<div class="content">

																				<form method="POST">
																					<input type="hidden" name="hangihoca" value="<?php echo $wholeteaid; ?>">
																					<input type="hidden" name="hangisaat" value="<?php echo $i; ?>">
																					<input type="hidden" name="qpr_id" value="<?php echo $qprid; ?>">
																					<label for="ogrsoru">Öğrencinin Sorduğu Soru Sayısı</label><br>
																					<input type="text" name="ogrsoru" id="ogrsoru"><br>
																					<label for="teasoru">Öğretmenin Sorduğu Soru Sayısı</label><br>
																					<input type="text" name="teasoru" id="teasoru"><br>
																					<button class="finishbutton" name="bitirsc1">Dersi Tamamla</button>
																				</form>
																				</div><?php 
																			}else{
																				?>
																				<button type="button" id="<?php echo $i; ?>" class="collapsibleFinish"><?php echo $saatler[$i-1].":00 ".$stu['name']." ".$stu['surname']; ?></button>
																				<div class="content">
																					<h6>Öğretmen Soru Sayısı: <?php echo $teaasq; ?></h6>
																					<h6>Öğrenci Soru Sayısı: <?php echo $stuasq; ?></h6>
																				</form>
																				</div><?php 
																			}
																		}
																	}
																}
																$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_questionprocess.qp_student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$wholeteaid' AND {$wpdb->prefix}mp_questionprocess.qp_hour = '$ikincisaat' AND {$wpdb->prefix}mp_questionprocess.qp_day = '$bugun' AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$wholeteaid';", ARRAY_A);
																foreach ($sty as $stu){
																	$qpstudent_id = $stu['qp_student_id'];
																	$record = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_qprecords WHERE student_id = '$qpstudent_id' AND date_info = '$tarih' AND teacher_id = '$wholeteaid';", ARRAY_A);
																	if ($record == null) {
																		?>
																		<button type="button" id="<?php echo $i; ?>" class="collapsible"><?php echo $saatler[$i-1].":25 ".$stu['name']." ".$stu['surname']; ?></button>
																		<div class="content">

																			<form method="POST">
																				<input type="hidden" name="hangihoca" value="<?php echo $wholeteaid; ?>">
																				<input type="hidden" name="hangisaat" value="<?php echo $i; ?>">
																				<input type="hidden" name="qpstudent_id" value="<?php echo $qpstudent_id; ?>">
																				<input type="hidden" name="braid" value="<?php echo $braid; ?>">
																				<button class="startButton" name="baslatsc2">Ders Başladı</button>
																			</form>
																			</div><?php 
																		}else{

																			foreach ($record as $recrow) {
																				$qprid = $recrow['qpr_id'];
																				$finishtime = $recrow['finish_time'];
																				$stuasq = $recrow['s_asked'];
																				$teaasq = $recrow['t_asked'];
																				if ($finishtime == '00:00:00') {
																			# code...

																					?>
																					<button type="button" id="<?php echo $i; ?>" class="collapsibleStart"><?php echo $saatler[$i-1].":25 ".$stu['name']." ".$stu['surname']; ?></button>
																					<div class="content">

																						<form method="POST">
																							<input type="hidden" name="hangihoca" value="<?php echo $wholeteaid; ?>">
																							<input type="hidden" name="hangisaat" value="<?php echo $i; ?>">
																							<input type="hidden" name="qpr_id" value="<?php echo $qprid; ?>">
																							<label for="ogrsoru">Öğrencinin Sorduğu Soru Sayısı</label><br>
																							<input type="text" name="ogrsoru" id="ogrsoru"><br>
																							<label for="teasoru">Öğretmenin Sorduğu Soru Sayısı</label><br>
																							<input type="text" name="teasoru" id="teasoru"><br>
																							<button class="finishbutton" name="bitirsc2">Dersi Tamamla</button>
																						</form>
																						</div><?php 
																					}else{
																						?>
																						<button type="button" id="<?php echo $i; ?>" class="collapsibleFinish"><?php echo $saatler[$i-1].":25 ".$stu['name']." ".$stu['surname']; ?></button>
																						<div class="content">
																							<h6>Öğretmen Soru Sayısı: <?php echo $teaasq; ?></h6>
																							<h6>Öğrenci Soru Sayısı: <?php echo $stuasq; ?></h6>
																						</form>
																						</div><?php 
																					}
																				}
																			}
																		}
																	}
																}
															}


															if (isset($_POST['baslatsc1'])) {

																$stdid = $_POST['qpstudent_id'];
																$braidq = $_POST['braid'];
																$hangiders = $_POST['hangisaat'];
																$teacherid = $_POST['hangihoca'];
																$wpdb -> query ("
																	INSERT INTO `wp_mp_qprecords` (`qpr_id`, `student_id`, `teacher_id`, `start_time`, `finish_time`, `date_info`, `branch_id`, `s_asked`, `t_asked`,`hangiders`) VALUES (NULL, '$stdid', '$teacherid', '$saaat', '00:00:00', '$tarih', '$braidq', '0', '0','$hangiders')
																	");
																	?>
																	<meta http-equiv="refresh" content="0;URL=index.php"><?php
																}

																if (isset($_POST['bitirsc1'])) {
																	$hangiders = $_POST['hangisaat'];
																	$teacherid = $_POST['hangihoca'];
																	$qpridid = $_POST['qpr_id'];
																	$scStu = $_POST['ogrsoru'];
																	$scTea = $_POST['teasoru'];
																	$wpdb -> query ("
																		UPDATE `wp_mp_qprecords` SET `finish_time` = '$saaat', `s_asked` = '$scStu', `t_asked` = '$scTea' WHERE `qpr_id` = '$qpridid'

																		");
																		?>
																		<meta http-equiv="refresh" content="0;URL=index.php"><?php
																	}

																	if (isset($_POST['baslatsc2'])) {
																		$hangiders = $_POST['hangisaat'];
																		$teacherid = $_POST['hangihoca'];
																		$stdid = $_POST['qpstudent_id'];
																		$braidq = $_POST['braid'];	
																		$wpdb -> query ("
																			INSERT INTO `wp_mp_qprecords` (`qpr_id`, `student_id`, `teacher_id`, `start_time`, `finish_time`, `date_info`, `branch_id`, `s_asked`, `t_asked`, `hangiders`) VALUES (NULL, '$stdid', '$teacherid', '$saaat', '00:00:00', '$tarih', '$braidq', '0', '0', '$hangiders')

																			");
																			?>
																			<meta http-equiv="refresh" content="0;URL=index.php"><?php													
																		}

																		if (isset($_POST['bitirsc2'])) {
																			$hangiders = $_POST['hangisaat'];
																			$teacherid = $_POST['hangihoca'];
																			$qpridid = $_POST['qpr_id'];
																			$scStu = $_POST['ogrsoru'];
																			$scTea = $_POST['teasoru'];
																			$wpdb -> query ("
																				UPDATE `wp_mp_qprecords` SET `finish_time` = '$saaat', `s_asked` = '$scStu', `t_asked` = '$scTea' WHERE `qpr_id` = '$qpridid'

																				");
																				?>
																				<meta http-equiv="refresh" content="0;URL=index.php"><?php
																			}



																			if (isset($_POST['baslat'])) {
																				$hangiders = $_POST['hangisaat'];
																				$teacherid = $_POST['hangihoca'];
																				$stdid = $_POST['stuid'];
																				$braidq = $_POST['braid'];
																				$wpdb -> query ("
																					INSERT INTO `wp_mp_lesson_records` 
																					(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`,`hangiders`) 
																					VALUES 
																					(NULL, '$stdid', '$teacherid', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidq', '$hangiders')

																					");
																					?>
																					<meta http-equiv="refresh" content="0;URL=index.php"><?php
																				}



																				if (isset($_POST['bitir'])) {
																					$hangiders = $_POST['hangisaat'];
																					$teacherid = $_POST['hangihoca'];
																					$qstdid = $_POST['stuid'];
																					$lessoninf = $_POST['lesson'];
																					$homeinf = $_POST['homework'];
																					$nexthomework = $_POST['nextwork'];
																					
																					$wpdb -> query ("
																						UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = '$lessoninf', homework_status = '$homeinf', next_homework = '$nexthomework' WHERE student_id = '$qstdid' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																						");

																					if (isset($_POST['uykusuzluk'])) {
																						$wpdb -> query ("
																							INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$qstdid', '$teacherid', 'uykusuzluk', '$tarih', '$saaat')
																							");

																					}
																					if (isset($_POST['katilmama'])) {
																						$wpdb -> query ("
																							INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$qstdid', '$teacherid', 'katilmama', '$tarih', '$saaat')
																							");
																					}
																					if (isset($_POST['teknik'])) {
																						$wpdb -> query ("
																							INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$qstdid', '$teacherid', 'teknik', '$tarih', '$saaat')
																							");
																					}







																					?>
																					<meta http-equiv="refresh" content="0;URL=index.php"><?php
																				}

																				if (isset($_POST['Gbaslat'])) {
																					$hangiders = $_POST['hangisaat'];
																					$teacherid = $_POST['hangihoca'];
																					$stdid1 = $_POST['st1'];
																					$stdid2 = $_POST['st2'];
																					$stdid3 = $_POST['st3'];
																					$stdid4 = $_POST['st4'];
																					$stdid5 = $_POST['st5'];
																					$stdid6 = $_POST['st6'];
																					$braidgq = $_POST['braidg'];

																					if ($stdid1 != 0) {
																						$wpdb -> query ("
																							INSERT INTO `wp_mp_lesson_records` 
																							(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`, `hangiders`) 
																							VALUES 
																							(NULL, '$stdid1', '$teacherid', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq','$hangiders')

																							");}
																						if ($stdid2 != 0) {
																							$wpdb -> query ("
																								INSERT INTO `wp_mp_lesson_records` 
																								(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`, `hangiders`) 
																								VALUES 
																								(NULL, '$stdid2', '$teacherid', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq','$hangiders')

																								");}
																							if ($stdid3 != 0) {
																								$wpdb -> query ("
																									INSERT INTO `wp_mp_lesson_records` 
																									(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`, `hangiders`) 
																									VALUES 
																									(NULL, '$stdid3', '$teacherid', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq','$hangiders')

																									");}
																								if ($stdid4 != 0) {
																									$wpdb -> query ("
																										INSERT INTO `wp_mp_lesson_records` 
																										(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`, `hangiders`) 
																										VALUES 
																										(NULL, '$stdid4', '$teacherid', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq','$hangiders')

																										");}
																									if ($stdid5 != 0) {
																										$wpdb -> query ("
																											INSERT INTO `wp_mp_lesson_records` 
																											(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`, `hangiders`) 
																											VALUES 
																											(NULL, '$stdid5', '$teacherid', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq','$hangiders')

																											");}
																										if ($stdid1 != 0) {
																											$wpdb -> query ("
																												INSERT INTO `wp_mp_lesson_records` 
																												(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`, `hangiders`) 
																												VALUES 
																												(NULL, '$stdid6', '$teacherid', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq','$hangiders')

																												");}
																												?>
																												<meta http-equiv="refresh" content="0;URL=index.php"><?php
																											}



																											if (isset($_POST['Gbitir'])) {
																												$hangiders = $_POST['hangisaat'];
																												$teacherid = $_POST['hangihoca'];
																												$stdid1 = $_POST['st1'];
																												$stdid2 = $_POST['st2'];
																												$stdid3 = $_POST['st3'];
																												$stdid4 = $_POST['st4'];
																												$stdid5 = $_POST['st5'];
																												$stdid6 = $_POST['st6'];

																												$lessoninf = $_POST['lesson'];
																												$nexthomework = $_POST['nextwork'];
																												$homeinf1 = $_POST['homework1'];
																												$homeinf2 = $_POST['homework2'];
																												$homeinf3 = $_POST['homework3'];
																												$homeinf4 = $_POST['homework4'];
																												$homeinf5 = $_POST['homework5'];
																												$homeinf6 = $_POST['homework6'];


																												//grup ogrencisi
																												if (isset($_POST['yok1'])) {
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = 'Katılmadı', homework_status = '$homeinf1', next_homework = '$nexthomework' WHERE student_id = '$stdid1' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}else{
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = '$lessoninf', homework_status = '$homeinf1', next_homework = '$nexthomework' WHERE student_id = '$stdid1' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}
																												//grup ogrencisi
																												if (isset($_POST['yok2'])) {
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = 'Katılmadı', homework_status = '$homeinf2', next_homework = '$nexthomework' WHERE student_id = '$stdid2' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}else{
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = '$lessoninf', homework_status = '$homeinf2', next_homework = '$nexthomework' WHERE student_id = '$stdid2' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}
																												//grup ogrencisi
																												if (isset($_POST['yok3'])) {
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = 'Katılmadı', homework_status = '$homeinf3', next_homework = '$nexthomework' WHERE student_id = '$stdid3' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}else{
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = '$lessoninf', homework_status = '$homeinf3', next_homework = '$nexthomework' WHERE student_id = '$stdid3' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}
																												//grup ogrencisi
																												if (isset($_POST['yok4'])) {
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = 'Katılmadı', homework_status = '$homeinf4', next_homework = '$nexthomework' WHERE student_id = '$stdid4' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}else{
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = '$lessoninf', homework_status = '$homeinf4', next_homework = '$nexthomework' WHERE student_id = '$stdid4' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}
																												//grup ogrencisi
																												if (isset($_POST['yok5'])) {
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = 'Katılmadı', homework_status = '$homeinf5', next_homework = '$nexthomework' WHERE student_id = '$stdid5' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}else{
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = '$lessoninf', homework_status = '$homeinf5', next_homework = '$nexthomework' WHERE student_id = '$stdid5' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}
																												//grup ogrencisi
																												if (isset($_POST['yok6'])) {
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = 'Katılmadı', homework_status = '$homeinf6', next_homework = '$nexthomework' WHERE student_id = '$stdid6' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}else{
																													$wpdb -> query ("
																														UPDATE `wp_mp_lesson_records` SET finish_time ='$saaat', lesson_status = '$lessoninf', homework_status = '$homeinf6', next_homework = '$nexthomework' WHERE student_id = '$stdid6' AND date_info = '$tarih' AND teacher_id = '$teacherid' AND `hangiders` = '$hangiders';
																														");
																												}
																												




																												if (isset($_POST['uykusuzluk1'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid1', '$teacherid', 'uykusuzluk', '$tarih', '$saaat')
																														");

																												}
																												if (isset($_POST['katilmama1'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid1', '$teacherid', 'katilmama', '$tarih', '$saaat')
																														");
																												}
																												if (isset($_POST['teknik1'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid1', '$teacherid', 'teknik', '$tarih', '$saaat')
																														");
																												}


																												
																												if (isset($_POST['uykusuzluk2'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid2', '$teacherid', 'uykusuzluk', '$tarih', '$saaat')
																														");

																												}
																												if (isset($_POST['katilmama2'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid2', '$teacherid', 'katilmama', '$tarih', '$saaat')
																														");
																												}
																												if (isset($_POST['teknik2'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid2', '$teacherid', 'teknik', '$tarih', '$saaat')
																														");
																												}


																												
																												if (isset($_POST['uykusuzluk3'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid3', '$teacherid', 'uykusuzluk', '$tarih', '$saaat')
																														");

																												}
																												if (isset($_POST['katilmama3'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid3', '$teacherid', 'katilmama', '$tarih', '$saaat')
																														");
																												}
																												if (isset($_POST['teknik3'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid3', '$teacherid', 'teknik', '$tarih', '$saaat')
																														");
																												}


																												
																												if (isset($_POST['uykusuzluk4'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid4', '$teacherid', 'uykusuzluk', '$tarih', '$saaat')
																														");

																												}
																												if (isset($_POST['katilmama4'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid4', '$teacherid', 'katilmama', '$tarih', '$saaat')
																														");
																												}
																												if (isset($_POST['teknik4'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid4', '$teacherid', 'teknik', '$tarih', '$saaat')
																														");
																												}


																												
																												if (isset($_POST['uykusuzluk5'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid5', '$teacherid', 'uykusuzluk', '$tarih', '$saaat')
																														");

																												}
																												if (isset($_POST['katilmama5'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid5', '$teacherid', 'katilmama', '$tarih', '$saaat')
																														");
																												}
																												if (isset($_POST['teknik5'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid5', '$teacherid', 'teknik', '$tarih', '$saaat')
																														");
																												}


																												
																												if (isset($_POST['uykusuzluk6'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid6', '$teacherid', 'uykusuzluk', '$tarih', '$saaat')
																														");

																												}
																												if (isset($_POST['katilmama6'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid6', '$teacherid', 'katilmama', '$tarih', '$saaat')
																														");
																												}
																												if (isset($_POST['teknik6'])) {
																													$wpdb -> query ("
																														INSERT INTO `wp_mp_symptom` (`student_id`, `teacher_id`, `symptom`, `date`, `time`) VALUES ('$stdid6', '$teacherid', 'teknik', '$tarih', '$saaat')
																														");
																												}
																												?>
																												<meta http-equiv="refresh" content="0;URL=index.php"><?php


																											}

																											if (isset($_POST['ekleurl'])) {
																												
																												$whichrecord = $_POST['hangirecord'];
																												$urlte = $_POST['urltext'];
																												$wpdb -> query ("
																													UPDATE `wp_mp_lesson_records` SET lesson_url = '$urlte' WHERE lr_id = '$whichrecord';
																													");

																											}


																											/*echo 'Username: ' . $current_user->user_login . "\n";
																											echo 'User display name: ' . $current_user->display_name . "\n";*/
																											?>

																											<script>
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
																												var coll = document.getElementsByClassName("collapsibleStart");
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
																												var coll = document.getElementsByClassName("collapsibleFinish");
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
																											<br>
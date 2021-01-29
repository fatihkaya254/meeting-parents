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
		.collapsiblenone {
			background-color: black;
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


		?> <div> <h4><?php echo $tarih." ".date('H:i:s'); ?></h4></div> <?php

		if ($today == "Mon") {
			$bugun = "pzt";
			?> <div> <h4><?php echo "Pazartesi"."<br>";; ?></h4></div> <?php

		}
		if ($today == "Tue") {
			$bugun = "sal";
			?> <div> <h4><?php echo "Salı"."<br>"; ?></h4></div> <?php

		}

		if ($today == "Wed") {
			$bugun = "car";
			?> <div> <h4><?php echo "Çarşamba"."<br>"; ?></h4></div> <?php

		}

		if ($today == "Thu") {
			$bugun = "per";
			?> <div> <h4><?php echo "Perşembe"."<br>"; ?></h4></div> <?php

		}

		if ($today == "Fri") {
			$bugun = "cum";
			?> <div> <h4><?php echo "Cuma"."<br>"; ?></h4></div> <?php

		}

		if ($today == "Sat") {
			$bugun = "cts";
			?> <div> <h4><?php echo "Cumartesi"."<br>"; ?></h4></div> <?php

		}

		if ($today == "Sun") {
			$bugun = "paz";
			?> <div> <h4><?php echo "Pazar"."<br>"; ?></h4></div> <?php

		}


		$username = $current_user->user_login;

		$dizi = explode ("_",$username);
		if ($dizi[0] == "T") {

			if ($dizi[2] == "irfan") {
				for ($i=1; $i < 10 ; $i++) {
					?><div><h4><?php echo $i.". Saat"; ?></h4></div><?php
					$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virtualweek, {$wpdb->prefix}teacher WHERE vw_name LIKE '_ - $i. Saat' AND {$wpdb->prefix}virtualweek.teacher_id = {$wpdb->prefix}teacher.teacher_id;", ARRAY_A);
					foreach ($sty as $stu){
						if ($stu[$bugun] != "freeday" && $stu[$bugun] != "0") {
							$studentInfo = $stu[$bugun];
							$stdInfo = explode (" ",$studentInfo);
							$stuid = $stdInfo[1];
							$branch = $stdInfo[0];
							$braid = 0;
							$graname = $stdInfo[2];
							$teacher_name =  $stu['name'] . " " .$stu['surname'];
							$bra = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}branch WHERE name = '$branch' ;", ARRAY_A);
							foreach ($bra as $brarw){
								$braid = $brarw['branch_id'];
							}
							if ($stuid !="G") {

								$record = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lesson_records WHERE student_id = '$stuid' AND date_info = '$tarih' AND branch_id = $braid;", ARRAY_A);
								if ($record == null) {
									?>
									<button type="button" id="<?php echo $i ?>" class="collapsible"><?php echo $i.". Ders ".$stu[$bugun]." ".$teacher_name; ?></button>
									<div class="content">

										<form method="POST">
											<input type="hidden" name="stuid" value="<?php echo $stuid ?>">
											<input type="hidden" name="braid" value="<?php echo $braid ?>">
											<button class="startButton" name="baslat">Ders Başladı</button>
											<button class="startButton" name="gelmedi">Öğrenci Gelmedi</button>
										</form>
										</div><?php 
									}else{
										foreach ($record as $rrow) {
											$homwork = $rrow['homework_status'];
											if ($homwork == "0") {
												?>
												<button type="button" id="<?php echo $i ?>" class="collapsibleStart"><?php echo $i.". Ders ".$stu[$bugun]." ".$teacher_name; ?></button>
												<div class="content">

													<?php
													$konu = "bilinmiyor";
													$nexttopicRank = 0;
													$bookname = "bilinmiyor";
													$bookid = 0;
													$theTopic = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student_books, {$wpdb->prefix}topic,{$wpdb->prefix}books WHERE {$wpdb->prefix}student_books.book_id = {$wpdb->prefix}topic.book_id  AND {$wpdb->prefix}student_books.book_id = {$wpdb->prefix}books.book_id AND  {$wpdb->prefix}student_books.rank = {$wpdb->prefix}topic.rank AND {$wpdb->prefix}student_books.student_id = '$stuid' AND {$wpdb->prefix}books.branch_id = $braid AND {$wpdb->prefix}student_books.is_comp = 0; ", ARRAY_A);

													foreach ($theTopic as $ttrow) {
														$konu = $ttrow['name'];
														$nexttopicRank = $ttrow['rank'] + 1;
														$bookname = $ttrow['book_name'];
														$bookid = $ttrow['book_id'];
														$topicid = $ttrow['topic_id'];
														$topRank = 1000;
														$topR = $wpdb->get_results("SELECT * FROM wp_topic WHERE book_id ='$bookid' ORDER BY `rank` DESC LIMIT 0,1", ARRAY_A);
														foreach ($topR as $ttrrow) {
															$topRank = $ttrrow['rank'];
														}

													}
													echo $topRank." ".$nexttopicRank;?>
													<form method="POST">
														<input type="hidden" name="namnam" value="<?php echo $graname ?>">
														<input type="hidden" name="stuid" value="<?php echo $stuid ?>">												
														<input type="hidden" name="topicid" value="<?php echo $topicid ?>">												
														<br><label for="lesson"><?php echo $konu; ?></label><br>
														<input type="hidden" name="nexttopicRank" value="<?php echo $nexttopicRank; ?>">
														<input type="hidden" name="toprank" value="<?php echo $topRank; ?>">
														<br><label for="lesson"><?php echo $bookname; ?></label><br>
														<input type="hidden" name="bookid" value="<?php echo $bookid; ?>">
														<br><label for="lesson">Konu Anlatımı:</label><br>
														<select name="lesson" id="lesson">
															<optgroup style="color: red;" label="Öğrenci Konu Kitabını Getirmedi">
																<option value="farkli">Konu Farklı Kaynaktan İşlendi</option>
																<option value="tekrara">Önceki Konulardan Test Çözüldü</option>
															</optgroup>
															<optgroup style="color: green;" label="Öğrenci Konu Anlatım Kitabını Getirdi">
																<option value="yuz">Konu %100 İşlendi</option>
																<option value="eksik">Konu Eksik İşlendi</option>
																<option value="tekrarb">Önceki Konulardan Tekrar Dersi Yapıldı</option>
															</optgroup>
														</select><br>
														<br><label for="homework">Ödev Kontrolü:</label><br>
														<select name="homework" id="homework">
															<option style="color: red;" value="yok">Soru Kitabı Yanında Değil</option>
															<option style="color: red;" value="hic">Ödevler Hiç Yapılmadı</option>
															<option style="color: red;" value="eksik">Ödevler Eksik/Özensiz Yapıldı</option>
															<option style="color: green;" value="tam">Ödevler Tam ve Eksiksiz Yapıldı</option>
														</select>
														<br><br>
														<button class="finishbutton" name="bitir">DERSİ BİTİR</button>
													</form>
													</div><?php 
												}else{
													$theTopic = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lesson_records WHERE {$wpdb->prefix}lesson_records.student_id = $stuid AND {$wpdb->prefix}lesson_records.date_info ='$tarih'", ARRAY_A);
													foreach ($theTopic as $ttrow) {
														$lessons = $ttrow['lesson_status'];
														if ($lessons == "gelmedi") {
															?>
															<button type="button" id="<?php echo $i ?>" class="collapsiblenone"><?php echo "gelmedi ". $i.". Ders ".$stu[$bugun]." ".$teacher_name; ?></button>
															<div class="content">
																<h4>öğrenci derse gelmedi</h4>
															</div>
															<?php 
														}else{
															?>
															<button type="button" id="<?php echo $i ?>" class="collapsibleFinish"><?php echo $i.". Ders ".$stu[$bugun]." ".$teacher_name; ?></button>
															<div class="content">

																<?php 
																$theTopic = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student_books, {$wpdb->prefix}topic, {$wpdb->prefix}lesson_records, {$wpdb->prefix}books WHERE {$wpdb->prefix}student_books.book_id = {$wpdb->prefix}topic.book_id AND {$wpdb->prefix}lesson_records.student_id = $stuid AND {$wpdb->prefix}lesson_records.date_info ='$tarih' AND {$wpdb->prefix}student_books.book_id = {$wpdb->prefix}books.book_id AND  {$wpdb->prefix}student_books.rank = {$wpdb->prefix}topic.rank AND {$wpdb->prefix}student_books.student_id = '$stuid' AND {$wpdb->prefix}books.branch_id = $braid;", ARRAY_A);
																foreach ($theTopic as $ttrow) {
																	$konu = $ttrow['name'];
																	$nexttopicRank = $ttrow['rank'] + 1;
																	$bookname = $ttrow['book_name'];
																	$bookid = $ttrow['book_id'];
																	$topicid = $ttrow['topic_id'];
																	$homworks = $ttrow['homework_status'];
																	echo $bookname. " - " . $konu. "<br>";
																	if ($lessons == "eksik") {
																		echo "Konunun Tamamı İşlenmedi <br>";
																	}
																	else if ($lessons == "farkli") {
																		echo "Öğrenci Kitabını Getirmedi, Farklı Bir Kaynaktan İşlendi<br>";
																	}
																	else if ($lessons == "tekrara") {
																		echo "Öğrenci Kitabını Getirmedi, Önceki Konulardan Soru Çözümü Yapıldı<br>";
																	}
																	else if ($lessons == "yuz") {
																		echo "Konu Eksiksiz Bir Şekilde Bitirildi<br>";
																	}													
																	else if ($lessons == "tekrarb") {
																		echo "Önceki Konulardan Tekar Dersi Yapıldı<br>";
																	}

																	if ($homworks == "eksik") {
																		echo "Öğrenci Ödevini Özensiz ve Eksik Yapmış <br>";
																	}
																	else if ($homworks == "tam") {
																		echo "Öğrenci Ödevini Tam Yapmış<br>";
																	}
																	else if ($homworks == "hic") {
																		echo "Ödevler Yapılmadı<br>";
																	}
																	else if ($homworks == "yok") {
																		echo "Öğrenci Soru Kitabını Getirmediği İçin Ödevler Kontrol Edilemedi<br>";
																	}													

																}
																?></div><?php 
															}}}
														}

													}
												} else{
													$group = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lesson_group WHERE group_name = '$graname' ;", ARRAY_A);
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

														$s1 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student WHERE student_id = '$std1';", ARRAY_A);
														foreach ($s1 as $key => $r1) {
															$sn1 = $r1['name']." ".$r1['surname'];
														}
														$s2 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student WHERE student_id = '$std2' ", ARRAY_A);
														foreach ($s2 as $key => $r2) {
															$sn2 = $r2['name']." ".$r2['surname'];
														}										
														$s3 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student WHERE student_id = '$std3' ", ARRAY_A);
														foreach ($s3 as $key => $r3) {
															$sn3 = $r3['name']." ".$r3['surname'];
														}
														if ($std4 !=0 ) {									
															$s4 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student WHERE student_id = '$std4';", ARRAY_A);
															foreach ($s4 as $key => $r4) {
																$sn4 = $r4['name']." ".$r4['surname'];
															}		}								
															if ($std5 !=0 ) {
																$s5 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student WHERE student_id = '$std5';", ARRAY_A);
																foreach ($s5 as $key => $r5) {
																	$sn5 = $r5['name']." ".$r5['surname'];
																}		}								
																if ($std6 !=0 ) {
																	$s6 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student WHERE student_id = '$std6' ", ARRAY_A);
																	foreach ($s6 as $key => $r6) {
																		$sn6 = $r6['name']." ".$r6['surname'];
																	}}



																	$stubir = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lesson_records WHERE student_id = '$std1' AND branch_id ='$braid' AND date_info = '$tarih' ;", ARRAY_A);



																	if ($stubir == null) {
																		?>
																		<button type="button" id="<?php echo $i ?>" class="collapsible"><?php echo $i.". Ders ".$stu[$bugun]." ".$teacher_name; ?></button>
																		<div class="content">
																			<form method="POST">
																				<input type="hidden" name="st1" value="<?php echo $std1 ?>">
																				<input type="hidden" name="st2" value="<?php echo $std2 ?>">
																				<input type="hidden" name="st3" value="<?php echo $std3 ?>">
																				<input type="hidden" name="st4" value="<?php echo $std4 ?>">
																				<input type="hidden" name="st5" value="<?php echo $std5 ?>">
																				<input type="hidden" name="st6" value="<?php echo $std6 ?>">
																				<input type="hidden" name="braidg" value="<?php echo $braid ?>">
																				<button class="startButton" name="Gbaslat">Ders Başladı</button>
																				</form></div><?php 
																			}else{
																				foreach ($stubir as $rrow) {
																					$homwork = $rrow['homework_status'];
																					if ($homwork == "0") {
																						?>
																						<button type="button" id="<?php echo $i ?>" class="collapsibleStart"><?php echo $i.". Ders ".$stu[$bugun]." ".$teacher_name; ?></button>
																						<div class="content">

																							<?php
																							$konu = "bilinmiyor";
																							$nexttopicRank = 0;
																							$bookname = "bilinmiyor";
																							$bookid = 0;
																							$theTopic = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student_books, {$wpdb->prefix}topic,{$wpdb->prefix}books WHERE {$wpdb->prefix}student_books.book_id = {$wpdb->prefix}topic.book_id  AND {$wpdb->prefix}student_books.book_id = {$wpdb->prefix}books.book_id AND  {$wpdb->prefix}student_books.rank = {$wpdb->prefix}topic.rank AND {$wpdb->prefix}student_books.student_id = '$std1' AND {$wpdb->prefix}books.branch_id = $braid;", ARRAY_A);

																							foreach ($theTopic as $ttrow) {
																								$konu = $ttrow['name'];
																								$nexttopicRank = $ttrow['rank'] + 1;
																								$bookname = $ttrow['book_name'];
																								$bookid = $ttrow['book_id'];
																								$topicid = $ttrow['topic_id'];
																								$topRank = 1000;
																								$topR = $wpdb->get_results("SELECT * FROM wp_topic WHERE book_id ='$bookid' ORDER BY `rank` DESC LIMIT 0,1", ARRAY_A);
																								foreach ($topR as $ttrrow) {
																									$topRank = $ttrrow['rank'];
																								}
																							}
																							echo "hello".$topRank." " . $nexttopicRank;
																							?>

																							<form method="POST">
																								<input type="hidden" name="st1" value="<?php echo $std1 ?>">												
																								<input type="hidden" name="st2" value="<?php echo $std2 ?>">												
																								<input type="hidden" name="st3" value="<?php echo $std3 ?>">												
																								<input type="hidden" name="st4" value="<?php echo $std4 ?>">												
																								<input type="hidden" name="st5" value="<?php echo $std5 ?>">												
																								<input type="hidden" name="st6" value="<?php echo $std6 ?>">												
																								<input type="hidden" name="Gtopicid" value="<?php echo $topicid ?>">												
																								<br><label for="lesson"><?php echo $konu; ?></label><br>
																								<input type="hidden" name="GnexttopicRank" value="<?php echo $nexttopicRank; ?>">
																								<input type="hidden" name="toprank" value="<?php echo $topRank; ?>">
																								<br><label for="lesson"><?php echo $bookname; ?></label><br>
																								<input type="hidden" name="Gbookid" value="<?php echo $bookid; ?>">


																								<br><br><br><label for="lesson1"><?php echo $sn1; ?></label>
																								<br><label for="lesson1">Konu Anlatımı:</label><br>
																								<select name="lesson1" id="lesson1">
																									<optgroup style="color: red;" label="Öğrenci Konu Kitabını Getirmedi">
																										<option value="farkli">Konu Farklı Kaynaktan İşlendi (veya grup dersine katılmadı)</option>
																										<option value="tekrara">Önceki Konulardan Test Çözüldü</option>
																									</optgroup>
																									<optgroup style="color: green;" label="Öğrenci Konu Anlatım Kitabını Getirdi">
																										<option value="yuz">Konu %100 İşlendi</option>
																										<option value="eksik">Konu Eksik İşlendi</option>
																										<option value="tekrarb">Önceki Konulardan Tekrar Dersi Yapıldı</option>
																									</optgroup>
																								</select><br>
																								<br><label for="homework1">Ödev Kontrolü:</label><br>
																								<select name="homework1" id="homework1">
																									<option style="color: red;" value="yok">Soru Kitabı Yanında Değil</option>
																									<option style="color: red;" value="hic">Ödevler Hiç Yapılmadı</option>
																									<option style="color: red;" value="eksik">Ödevler Eksik/Özensiz Yapıldı</option>
																									<option style="color: green;" value="tam">Ödevler Tam ve Eksiksiz Yapıldı</option>
																								</select>

																								<br><br><br><label for="lesson2"><?php echo $sn2; ?></label>
																								<br><label for="lesson2">Konu Anlatımı:</label><br>
																								<select name="lesson2" id="lesson2">
																									<optgroup style="color: red;" label="Öğrenci Konu Kitabını Getirmedi">
																										<option value="farkli">Konu Farklı Kaynaktan İşlendi</option>
																										<option value="tekrara">Önceki Konulardan Test Çözüldü</option>
																									</optgroup>
																									<optgroup style="color: green;" label="Öğrenci Konu Anlatım Kitabını Getirdi">
																										<option value="yuz">Konu %100 İşlendi</option>
																										<option value="eksik">Konu Eksik İşlendi</option>
																										<option value="tekrarb">Önceki Konulardan Tekrar Dersi Yapıldı</option>
																									</optgroup>
																								</select><br>
																								<br><label for="homework2">Ödev Kontrolü:</label><br>
																								<select name="homework2" id="homework2">
																									<option style="color: red;" value="yok">Soru Kitabı Yanında Değil</option>
																									<option style="color: red;" value="hic">Ödevler Hiç Yapılmadı</option>
																									<option style="color: red;" value="eksik">Ödevler Eksik/Özensiz Yapıldı</option>
																									<option style="color: green;" value="tam">Ödevler Tam ve Eksiksiz Yapıldı</option>
																								</select>

																								<br><br><br><label for="lesson3"><?php echo $sn3; ?></label>
																								<br><label for="lesson3">Konu Anlatımı:</label><br>
																								<select name="lesson3" id="lesson3">
																									<optgroup style="color: red;" label="Öğrenci Konu Kitabını Getirmedi">
																										<option value="farkli">Konu Farklı Kaynaktan İşlendi</option>
																										<option value="tekrara">Önceki Konulardan Test Çözüldü</option>
																									</optgroup>
																									<optgroup style="color: green;" label="Öğrenci Konu Anlatım Kitabını Getirdi">
																										<option value="yuz">Konu %100 İşlendi</option>
																										<option value="eksik">Konu Eksik İşlendi</option>
																										<option value="tekrarb">Önceki Konulardan Tekrar Dersi Yapıldı</option>
																									</optgroup>
																								</select><br>
																								<br><label for="homework3">Ödev Kontrolü:</label><br>
																								<select name="homework3" id="homework3">
																									<option style="color: red;" value="yok">Soru Kitabı Yanında Değil</option>
																									<option style="color: red;" value="hic">Ödevler Hiç Yapılmadı</option>
																									<option style="color: red;" value="eksik">Ödevler Eksik/Özensiz Yapıldı</option>
																									<option style="color: green;" value="tam">Ödevler Tam ve Eksiksiz Yapıldı</option>
																								</select>


																								<br><br><br><label for="lesson4"><?php echo $sn4; ?></label>
																								<br><label for="lesson4">Konu Anlatımı:</label><br>
																								<select name="lesson4" id="lesson4">
																									<optgroup style="color: red;" label="Öğrenci Konu Kitabını Getirmedi">
																										<option value="farkli">Konu Farklı Kaynaktan İşlendi</option>
																										<option value="tekrara">Önceki Konulardan Test Çözüldü</option>
																									</optgroup>
																									<optgroup style="color: green;" label="Öğrenci Konu Anlatım Kitabını Getirdi">
																										<option value="yuz">Konu %100 İşlendi</option>
																										<option value="eksik">Konu Eksik İşlendi</option>
																										<option value="tekrarb">Önceki Konulardan Tekrar Dersi Yapıldı</option>
																									</optgroup>
																								</select><br>
																								<br><label for="homework4">Ödev Kontrolü:</label><br>
																								<select name="homework4" id="homework4">
																									<option style="color: red;" value="yok">Soru Kitabı Yanında Değil</option>
																									<option style="color: red;" value="hic">Ödevler Hiç Yapılmadı</option>
																									<option style="color: red;" value="eksik">Ödevler Eksik/Özensiz Yapıldı</option>
																									<option style="color: green;" value="tam">Ödevler Tam ve Eksiksiz Yapıldı</option>
																								</select>


																								<br><br><br><label for="lesson5"><?php echo $sn5; ?></label>
																								<br><label for="lesson5">Konu Anlatımı:</label><br>
																								<select name="lesson5" id="lesson5">
																									<optgroup style="color: red;" label="Öğrenci Konu Kitabını Getirmedi">
																										<option value="farkli">Konu Farklı Kaynaktan İşlendi</option>
																										<option value="tekrara">Önceki Konulardan Test Çözüldü</option>
																									</optgroup>
																									<optgroup style="color: green;" label="Öğrenci Konu Anlatım Kitabını Getirdi">
																										<option value="yuz">Konu %100 İşlendi</option>
																										<option value="eksik">Konu Eksik İşlendi</option>
																										<option value="tekrarb">Önceki Konulardan Tekrar Dersi Yapıldı</option>
																									</optgroup>
																								</select><br>
																								<br><label for="homework5">Ödev Kontrolü:</label><br>
																								<select name="homework5" id="homework5">
																									<option style="color: red;" value="yok">Soru Kitabı Yanında Değil</option>
																									<option style="color: red;" value="hic">Ödevler Hiç Yapılmadı</option>
																									<option style="color: red;" value="eksik">Ödevler Eksik/Özensiz Yapıldı</option>
																									<option style="color: green;" value="tam">Ödevler Tam ve Eksiksiz Yapıldı</option>
																								</select>

																								<br><br><br><label for="lesson6"><?php echo $sn6; ?></label>
																								<br><label for="lesson6">Konu Anlatımı:</label><br>
																								<select name="lesson6" id="lesson6">
																									<optgroup style="color: red;" label="Öğrenci Konu Kitabını Getirmedi">
																										<option value="farkli">Konu Farklı Kaynaktan İşlendi</option>
																										<option value="tekrara">Önceki Konulardan Test Çözüldü</option>
																									</optgroup>
																									<optgroup style="color: green;" label="Öğrenci Konu Anlatım Kitabını Getirdi">
																										<option value="yuz">Konu %100 İşlendi</option>
																										<option value="eksik">Konu Eksik İşlendi</option>
																										<option value="tekrarb">Önceki Konulardan Tekrar Dersi Yapıldı</option>
																									</optgroup>
																								</select><br>
																								<br><label for="homework6">Ödev Kontrolü:</label><br>
																								<select name="homework6" id="homework6">
																									<option style="color: red;" value="yok">Soru Kitabı Yanında Değil</option>
																									<option style="color: red;" value="hic">Ödevler Hiç Yapılmadı</option>
																									<option style="color: red;" value="eksik">Ödevler Eksik/Özensiz Yapıldı</option>
																									<option style="color: green;" value="tam">Ödevler Tam ve Eksiksiz Yapıldı</option>
																								</select>

																								<br><br>
																								<button class="finishbutton" name="Gbitir">DERSİ BİTİR</button>
																							</form>
																							</div><?php 
																						}else{

																							$theTopic = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lesson_records WHERE {$wpdb->prefix}lesson_records.student_id = $std1 AND {$wpdb->prefix}lesson_records.date_info ='$tarih'", ARRAY_A);
																							foreach ($theTopic as $ttrow) {
																								$lessons = $ttrow['lesson_status'];
																								if ($lessons == "gelmedi") {
																									?>
																									<button type="button" id="<?php echo $i ?>" class="collapsiblenone"><?php echo "gelmedi ". $i.". Ders ".$stu[$bugun]." ".$teacher_name; ?></button>
																									<div class="content">
																										<h4>öğrenci derse gelmedi</h4>
																									</div>
																									<?php 
																								}else{
																									?>
																									<button type="button" id="<?php echo $i ?>" class="collapsibleFinish"><?php echo $i.". Ders ".$stu[$bugun]." ".$teacher_name; ?></button>
																									<div class="content">

																										<?php 
																										$theTopic = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student_books, {$wpdb->prefix}topic, {$wpdb->prefix}lesson_records, {$wpdb->prefix}books WHERE {$wpdb->prefix}student_books.book_id = {$wpdb->prefix}topic.book_id AND {$wpdb->prefix}lesson_records.student_id = $std1 AND {$wpdb->prefix}lesson_records.date_info ='$tarih' AND {$wpdb->prefix}student_books.book_id = {$wpdb->prefix}books.book_id AND  {$wpdb->prefix}student_books.rank = {$wpdb->prefix}topic.rank AND {$wpdb->prefix}student_books.student_id = '$std1' AND {$wpdb->prefix}books.branch_id = $braid;", ARRAY_A);
																										foreach ($theTopic as $ttrow) {
																											$konu = $ttrow['name'];
																											$nexttopicRank = $ttrow['rank'] + 1;
																											$bookname = $ttrow['book_name'];
																											$bookid = $ttrow['book_id'];
																											$topicid = $ttrow['topic_id'];
																											$homworks = $ttrow['homework_status'];
																											echo $bookname. " - " . $konu. "<br>";
																											if ($lessons == "eksik") {
																												echo "Konunun Tamamı İşlenmedi <br>";
																											}
																											else if ($lessons == "farkli") {
																												echo "Öğrenci Kitabını Getirmedi, Farklı Bir Kaynaktan İşlendi<br>";
																											}
																											else if ($lessons == "tekrara") {
																												echo "Öğrenci Kitabını Getirmedi, Önceki Konulardan Soru Çözümü Yapıldı<br>";
																											}
																											else if ($lessons == "yuz") {
																												echo "Konu Eksiksiz Bir Şekilde Bitirildi<br>";
																											}													
																											else if ($lessons == "tekrarb") {
																												echo "Önceki Konulardan Tekar Dersi Yapıldı<br>";
																											}

																											if ($homworks == "eksik") {
																												echo "Öğrenci Ödevini Özensiz ve Eksik Yapmış <br>";
																											}
																											else if ($homworks == "tam") {
																												echo "Öğrenci Ödevini Tam Yapmış<br>";
																											}
																											else if ($homworks == "hic") {
																												echo "Ödevler Yapılmadı<br>";
																											}
																											else if ($homworks == "yok") {
																												echo "Öğrenci Soru Kitabını Getirmediği İçin Ödevler Kontrol Edilemedi<br>";
																											}													

																										}
																									}
																									?></div><?php 
																								}}
																							}
																						}

																					}


																				}


																			}
																		}
																	}

																}	

															}



															if (isset($_POST['baslat'])) {

																$stdid = $_POST['stuid'];
																$braidq = $_POST['braid'];
																$wpdb -> query ("
																	INSERT INTO `wp_lesson_records` 
																	(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`) 
																	VALUES 
																	(NULL, '$stdid', '$dizi[1]', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidq')

																	");
																	?>
																	<meta http-equiv="refresh" content="0;URL=index.php"><?php
																}
																if (isset($_POST['gelmedi'])) {

																	$stdid = $_POST['stuid'];
																	$braidq = $_POST['braid'];
																	$wpdb -> query ("
																		INSERT INTO `wp_lesson_records` 
																		(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`) 
																		VALUES 
																		(NULL, '$stdid', '$dizi[1]', '0', '00:00:00', '00:00:00', 'gelmedi', 'gelmedi', '$tarih','$braidq')

																		");
																		?>
																		<meta http-equiv="refresh" content="0;URL=index.php"><?php
																	}
																	if (isset($_POST['bitir'])) {
																		$topRankF = $_POST['toprank']; 
																		$qstdid = $_POST['stuid'];
																		$qnexttopicRank = $_POST['nexttopicRank'];
																		$qbookid = $_POST['bookid'];
																		$qtopicid = $_POST['topicid'];
																		$lessoninf = $_POST['lesson'];
																		$homeinf = $_POST['homework'];

																		if ($lessoninf != "yuz" && $lessoninf != "farkli" ) {
																			$nexttopicRank = $nexttopicRank - 1;
																		}


																		$wpdb -> query ("
																			UPDATE `wp_lesson_records` SET topic_id = '$qtopicid', finish_time ='$saaat', lesson_status = '$lessoninf', homework_status = '$homeinf' WHERE student_id = '$qstdid' AND date_info = '$tarih';
																			");


																		if ($nexttopicRank <= $topRankF) {
																			$wpdb -> query ("
																				UPDATE `wp_student_books` SET `rank` = '$qnexttopicRank' WHERE student_id = '$qstdid' AND book_id = '$qbookid';
																				");


																		}else{
																			$wpdb -> query ("
																				UPDATE `wp_student_books` SET `is_comp` = '1' WHERE student_id = '$qstdid' AND book_id = '$qbookid';
																				");
//*********************************************************************
														//mail başı

																				?>

																				<title>Posta Gönderme Sonuç Raporu</title>  
																				<meta http-equiv="Content-Type" content="text/html;">
																				<h1>merhaba</h1>
																				<meta charset="UTF-8">
																				<?php

require_once dirname(__FILE__, 2).'/notifications/mailphp/class.phpmailer.php';// PHPMailer dosyamizi çagiriyoruz

$mail = new PHPMailer(); // Sinifimizi $mail degiskenine atadik
$mail->IsSMTP(true);  // Mailimizin SMTP ile gönderilecegini belirtiyoruz
$mail->From     = "bilgi@liseyegecissinavi.site";//"admin@localhost"; //Gönderen kisminda yer alacak e-mail adresi
$mail->Sender   = "bilgi@liseyegecissinavi.site";//"admin@localhost";//Gönderen Mail adresi
//$mail->ReplyTo  = ($_POST["mailiniz"]);//"admin@localhost";//Tekrar gönderimdeki mail adersi
$mail->AddReplyTo=("bilgi@liseyegecissinavi.site");//"admin@localhost";//Tekrar gönderimdeki mail adersi
$mail->FromName = "Kitap Bildirimi";//"PHP Mailer";//gönderenin ismi
$mail->Host     = "mail.liseyegecissinavi.site";//"localhost"; //SMTP server adresi
$mail->SMTPAuth = true; //SMTP server'a kullanici adi ile baglanilcagini belirtiyoruz
$mail->SMTPSecure = false;
$mail->SMTPAutoTLS = false;
$mail->Port     = 587; //Natro SMPT Mail Portu
$mail->CharSet = 'uft-8'; //Türkçe yazı karakterleri için CharSet  ayarını bu şekilde yapıyoruz.
$mail->Username = "bilgi@liseyegecissinavi.site";//"admin@localhost"; //SMTP kullanici adi
$mail->Password = "ZLen-hN4-01";//""; //SMTP mailinizin sifresi
$mail->WordWrap = 50;
$mail->IsHTML(true); //Mailimizin HTML formatinda hazirlanacagini bildiriyoruz.
$mail->Subject  = "konumuz neydi bizim"." /PHP SMTP Ayarları/Mail Konusu";//"Deneme Maili"; // Mailin Konusu Konu
//Mailimizin gövdesi: (HTML ile)
$body  = "";
$group = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student,  {$wpdb->prefix}books  WHERE {$wpdb->prefix}student.student_id = '$qstdid' AND {$wpdb->prefix}books.book_id= '$qbookid';", ARRAY_A);
foreach ($group as $grow){
	$body .= $grow['name']." ".$grow['surname']." ".$grow['number']. " adlı ve numaralı öğrencimiz, ".$grow['book_name']." kitabının son konusunu işlemiş ve kitabı bitirmiştir. Söz konusu kitabın branşından başka bir kitap verilecekse bilgilerin bir sonraki dersinden önce sisteme girilmesi gerekmektedir";
}




echo $body;
//  $body = $_POST["mesaj"];//"Bu mail bir deneme mailidir. SMTP server ile gönderilmistir.";
// HTML okuyamayan mail okuyucularda görünecek düz metin:
$textBody = $body;//"Bu mail bir deneme mailidir. SMTP server ile gönderilmistir.";
$mail->Body = $body;
$mail->AltBody = $text_body;
if ($mail->Send()) echo "Sorunuz gönderildimiştir. <br>Natro Sistem Uzmanlarımız müsait olduğunda yanıtlayacaktır.";
else echo "Form göndermede hata oldu! Daha sonra tekrar deneyiniz.";
$mail->ClearAddresses();
$mail->ClearAttachments();
//$mail->AddAttachment('images.png'); //mail içinde resim göndermek için
//$mail->addCC('mailadi@alanadiniz.site');// cc email adresi
//$mail->addBCC('mailadi@alanadiniz.site');// bcc email adresi
$mail->AddAddress("fatihkaya254@gmail.com"); // Mail gönderilecek adresleri ekliyoruz.
//$mail->AddAddress("ysfasln.80@gmail.com");
//$mail->AddAddress("irfantokcan@gmail.com");
//$mail->AddAddress("av.oguzhankocer@gmail.com");
$mail->Send();
$mail->ClearAddresses();
$mail->ClearAttachments(); 



														//mail sonu
														//********************************************************************
}

?>
<meta http-equiv="refresh" content="0;URL=index.php"><?php
}

if (isset($_POST['Gbaslat'])) {

	$stdid1 = $_POST['st1'];
	$stdid2 = $_POST['st2'];
	$stdid3 = $_POST['st3'];
	$stdid4 = $_POST['st4'];
	$stdid5 = $_POST['st5'];
	$stdid6 = $_POST['st6'];
	$braidgq = $_POST['braidg'];

	if ($stdid1 != 0) {
		$wpdb -> query ("
			INSERT INTO `wp_lesson_records` 
			(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`) 
			VALUES 
			(NULL, '$stdid1', '$dizi[1]', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq')

			");}
		if ($stdid2 != 0) {
			$wpdb -> query ("
				INSERT INTO `wp_lesson_records` 
				(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`) 
				VALUES 
				(NULL, '$stdid2', '$dizi[1]', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq')

				");}
			if ($stdid3 != 0) {
				$wpdb -> query ("
					INSERT INTO `wp_lesson_records` 
					(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`) 
					VALUES 
					(NULL, '$stdid3', '$dizi[1]', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq')

					");}
				if ($stdid4 != 0) {
					$wpdb -> query ("
						INSERT INTO `wp_lesson_records` 
						(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`) 
						VALUES 
						(NULL, '$stdid4', '$dizi[1]', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq')

						");}
					if ($stdid5 != 0) {
						$wpdb -> query ("
							INSERT INTO `wp_lesson_records` 
							(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`) 
							VALUES 
							(NULL, '$stdid5', '$dizi[1]', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq')

							");}
						if ($stdid1 != 0) {
							$wpdb -> query ("
								INSERT INTO `wp_lesson_records` 
								(`lr_id`, `student_id`, `teacher_id`, `topic_id`, `start_time`, `finish_time`, `lesson_status`, `homework_status`, `date_info`, `branch_id`) 
								VALUES 
								(NULL, '$stdid6', '$dizi[1]', '0', '$saaat', '00:00:00', '0', '0', '$tarih','$braidgq')

								");}
								?>
								<meta http-equiv="refresh" content="0;URL=index.php"><?php
							}



							if (isset($_POST['Gbitir'])) {

								$stdid1 = $_POST['st1'];
								$stdid2 = $_POST['st2'];
								$stdid3 = $_POST['st3'];
								$stdid4 = $_POST['st4'];
								$stdid5 = $_POST['st5'];
								$stdid6 = $_POST['st6'];
								$topRankF = $_POST['toprank']; 

								$qnexttopicRank = $_POST['GnexttopicRank'];
								$qbookid = $_POST['Gbookid'];
								$qtopicid = $_POST['Gtopicid'];

								$lessoninf1 = $_POST['lesson1'];
								$homeinf1 = $_POST['homework1'];

								$lessoninf2 = $_POST['lesson2'];
								$homeinf2 = $_POST['homework2'];

								$lessoninf3 = $_POST['lesson3'];
								$homeinf3 = $_POST['homework3'];

								$lessoninf4 = $_POST['lesson4'];
								$homeinf4 = $_POST['homework4'];

								$lessoninf5 = $_POST['lesson5'];
								$homeinf5 = $_POST['homework5'];

								$lessoninf6 = $_POST['lesson6'];
								$homeinf6 = $_POST['homework6'];


								if ($lessoninf1 != "yuz" && $lessoninf1 != "farkli" ) {
									$qnexttopicRank = $qnexttopicRank - 1;
								}


								$wpdb -> query ("
									UPDATE `wp_lesson_records` SET topic_id = '$qtopicid', finish_time ='$saaat', lesson_status = '$lessoninf1', homework_status = '$homeinf1' WHERE student_id = '$stdid1' AND date_info = '$tarih';
									");

								if ($nexttopicRank <= $topRankF) {
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `rank` = '$qnexttopicRank' WHERE student_id = '$stdid1' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `rank` = '$qnexttopicRank' WHERE student_id = '$stdid2' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `rank` = '$qnexttopicRank' WHERE student_id = '$stdid3' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `rank` = '$qnexttopicRank' WHERE student_id = '$stdid4' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `rank` = '$qnexttopicRank' WHERE student_id = '$stdid5' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `rank` = '$qnexttopicRank' WHERE student_id = '$stdid6' AND book_id = '$qbookid';
										");
								}else{
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `is_comp` = '1' WHERE student_id = '$stdid1' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `is_comp` = '1' WHERE student_id = '$stdid2' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `is_comp` = '1' WHERE student_id = '$stdid3' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `is_comp` = '1' WHERE student_id = '$stdid4' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `is_comp` = '1' WHERE student_id = '$stdid5' AND book_id = '$qbookid';
										");
									$wpdb -> query ("
										UPDATE `wp_student_books` SET `is_comp` = '1' WHERE student_id = '$stdid6' AND book_id = '$qbookid';
										");

									//*********************************************************************
														//mail başı

										?>

										<title>Posta Gönderme Sonuç Raporu</title>  
										<meta http-equiv="Content-Type" content="text/html;">
										<h1>merhaba</h1>
										<meta charset="UTF-8">
										<?php

require_once dirname(__FILE__, 2).'/notifications/mailphp/class.phpmailer.php';// PHPMailer dosyamizi çagiriyoruz

$mail = new PHPMailer(); // Sinifimizi $mail degiskenine atadik
$mail->IsSMTP(true);  // Mailimizin SMTP ile gönderilecegini belirtiyoruz
$mail->From     = "bilgi@liseyegecissinavi.site";//"admin@localhost"; //Gönderen kisminda yer alacak e-mail adresi
$mail->Sender   = "bilgi@liseyegecissinavi.site";//"admin@localhost";//Gönderen Mail adresi
//$mail->ReplyTo  = ($_POST["mailiniz"]);//"admin@localhost";//Tekrar gönderimdeki mail adersi
$mail->AddReplyTo=("bilgi@liseyegecissinavi.site");//"admin@localhost";//Tekrar gönderimdeki mail adersi
$mail->FromName = "Kitap Bildirimi";//"PHP Mailer";//gönderenin ismi
$mail->Host     = "mail.liseyegecissinavi.site";//"localhost"; //SMTP server adresi
$mail->SMTPAuth = true; //SMTP server'a kullanici adi ile baglanilcagini belirtiyoruz
$mail->SMTPSecure = false;
$mail->SMTPAutoTLS = false;
$mail->Port     = 587; //Natro SMPT Mail Portu
$mail->CharSet = 'uft-8'; //Türkçe yazı karakterleri için CharSet  ayarını bu şekilde yapıyoruz.
$mail->Username = "bilgi@liseyegecissinavi.site";//"admin@localhost"; //SMTP kullanici adi
$mail->Password = "ZLen-hN4-01";//""; //SMTP mailinizin sifresi
$mail->WordWrap = 50;
$mail->IsHTML(true); //Mailimizin HTML formatinda hazirlanacagini bildiriyoruz.
$mail->Subject  = "konumuz neydi bizim"." /PHP SMTP Ayarları/Mail Konusu";//"Deneme Maili"; // Mailin Konusu Konu
//Mailimizin gövdesi: (HTML ile)
$body  = "";
$group = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lesson_group,  {$wpdb->prefix}books  WHERE {$wpdb->prefix}lesson_group.1_student_id = '$stdid1' AND {$wpdb->prefix}books.book_id= '$qbookid';", ARRAY_A);
foreach ($group as $grow){
	$body .= $grow['group_name']. " adlı gruptaki öğrenciler, ".$grow['book_name']." kitabının son konusunu işlemiş ve kitabı bitirmiştir. Söz konusu kitabın branşından başka bir kitap verilecekse bilgilerin bir sonraki dersinden önce sisteme girilmesi gerekmektedir";
}




echo $body;
//  $body = $_POST["mesaj"];//"Bu mail bir deneme mailidir. SMTP server ile gönderilmistir.";
// HTML okuyamayan mail okuyucularda görünecek düz metin:
$textBody = $body;//"Bu mail bir deneme mailidir. SMTP server ile gönderilmistir.";
$mail->Body = $body;
$mail->AltBody = $text_body;
if ($mail->Send()) echo "Sorunuz gönderildimiştir. <br>Natro Sistem Uzmanlarımız müsait olduğunda yanıtlayacaktır.";
else echo "Form göndermede hata oldu! Daha sonra tekrar deneyiniz.";
$mail->ClearAddresses();
$mail->ClearAttachments();
//$mail->AddAttachment('images.png'); //mail içinde resim göndermek için
//$mail->addCC('mailadi@alanadiniz.site');// cc email adresi
//$mail->addBCC('mailadi@alanadiniz.site');// bcc email adresi
$mail->AddAddress("fatihkaya254@gmail.com"); // Mail gönderilecek adresleri ekliyoruz.
//$mail->AddAddress("ysfasln.80@gmail.com");
//$mail->AddAddress("irfantokcan@gmail.com");
//$mail->AddAddress("av.oguzhankocer@gmail.com");
$mail->Send();
$mail->ClearAddresses();
$mail->ClearAttachments(); 



														//mail sonu
														//********************************************************************
}

$wpdb -> query ("
	UPDATE `wp_lesson_records` SET topic_id = '$qtopicid', finish_time ='$saaat', lesson_status = '$lessoninf2', homework_status = '$homeinf2' WHERE student_id = '$stdid2' AND date_info = '$tarih';
	");

$wpdb -> query ("
	UPDATE `wp_lesson_records` SET topic_id = '$qtopicid', finish_time ='$saaat', lesson_status = '$lessoninf3', homework_status = '$homeinf3' WHERE student_id = '$stdid3' AND date_info = '$tarih';
	");

$wpdb -> query ("
	UPDATE `wp_lesson_records` SET topic_id = '$qtopicid', finish_time ='$saaat', lesson_status = '$lessoninf4', homework_status = '$homeinf4' WHERE student_id = '$stdid4' AND date_info = '$tarih';
	");

$wpdb -> query ("
	UPDATE `wp_lesson_records` SET topic_id = '$qtopicid', finish_time ='$saaat', lesson_status = '$lessoninf5', homework_status = '$homeinf5' WHERE student_id = '$stdid5' AND date_info = '$tarih';
	");

$wpdb -> query ("
	UPDATE `wp_lesson_records` SET topic_id = '$qtopicid', finish_time ='$saaat', lesson_status = '$lessoninf6', homework_status = '$homeinf6' WHERE student_id = '$stdid6' AND date_info = '$tarih';
	");


	?>
	<meta http-equiv="refresh" content="0;URL=index.php"><?php


}

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
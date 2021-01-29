<style>

	/* Style the tab */
	.tab {
		overflow: hidden;
		border: 1px solid #ccc;
		background-color: #f1f1f1;
		margin-top: 50px;
	}

	/* Style the buttons that are used to open the tab content */
	.tab button {
		background-color: inherit;
		float: left;
		border: none;
		outline: none;
		cursor: pointer;
		padding: 14px 16px;
		transition: 0.3s;
	}

	/* Change background color of buttons on hover */
	.tab button:hover {
		background-color: #ddd;
	}

	/* Create an active/current tablink class */
	.tab button.active {
		background-color: #ccc;
	}

	/* Style the tab content */
	.tabcontent {
		display: none;
		padding: 6px 12px;
		border: 1px solid #ccc;
		border-top: none;
		float: left;
		width: 1210px;
	}</style>


	<?php global $wpdb;
	$gunler = array("sal","car","per","cum","cts","paz");
	$dersler = array("1","2","3","4","5","6","7","8","9");
	$sorus = array("ilk 25 Dakika","Son 25 Dakika");
	$stuoptions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE active = 1 ", ARRAY_A);
	?>
	<div class="tab">
		<?php
		$teachers = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_teacher WHERE active = 1", ARRAY_A);
		foreach($teachers as $row)
		{ 
			$teaid = $row["teacher_id"];
			?>
			<button class="tablinks" onclick="openCity(event, '<?php echo $row["teacher_id"]; ?>')"><?php echo $row["name"]; ?></button>
			<?php 
		}
		$branches = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_teacher	WHERE active = 1", ARRAY_A);
		foreach($branches as $row)
		{ 
			$teaid = $row["teacher_id"];
			?>
			<div id="<?php echo $row["teacher_id"]; ?>" class="tabcontent" >


				<div style="width: 1100px; height: 30px; border: solid; margin: 10px; padding: 10px;">

					<form method="POST">
						<input type="hidden" name="ogretmen" value="<?php echo $teaid; ?>">
						<input list="ogrencilistesi" name="ogrlist" id="ogrlist" placeholder="Öğrenci">
						<datalist id="ogrencilistesi">
							<?php 
							$students = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE active = '1' ", ARRAY_A);
							foreach($students as $row)
							{
								?>
								<option value=" <?php echo $row['name']." ".$row['surname']." - ".$row['student_id']; ?>"></option>
								<?php
							}
							$students = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group ", ARRAY_A);
							foreach($students as $row)
							{
								?>
								<option value=" <?php echo  " - ".$row['group_name']; ?>"></option>
								<?php
							}
							?>

						</datalist>
						<input list="gunlistesi" name="daylist" id="daylist" placeholder="Gün/Saat">
						<datalist id="gunlistesi">

							<?php 
							foreach ($gunler as $gun) {
								foreach ($dersler as $ders){
									?>
									<option value=" <?php echo " - ".$gun." - ".$ders;?>"></option>
									<?php
								}
							}
							?>
						</datalist>

						<input list="hangidakika" name="hangiyirmibes" id="hangiyirmibes" placeholder="Hangi 25?">
						<datalist id="hangidakika">
							<option value="1"></option>
							<option value="2"></option>
							?>

						</datalist>
						
						<input list="branslistesi" name="brans" id="brans" placeholder="Ders">
						<datalist id="branslistesi">
							<?php 
							$students = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_branch ", ARRAY_A);
							foreach($students as $row)
							{
								?>
								<option value=" <?php echo $row['name']; ?>"></option>
								<?php
							}
							?>

						</datalist>
						<input  type="submit" name="ekle" id="ekle" value="Soru Çözümü Ekle">
					</form>
				</div>


				<?php 



				foreach ($dersler as $ders) {
					foreach ($gunler as $gun) {
						$dersvarmi = '0';
						$branches = $wpdb->get_results("SELECT $gun FROM {$wpdb->prefix}mp_virtualweek WHERE vw_name = '$teaid - $ders. saat' ", ARRAY_A);
						foreach($branches as $row)
						{
							$dersvarmi = $row[$gun];
						}
						$birincisc = '0';
						$ikincisc = '0';
						if ($dersvarmi == '0') {

							
							?>
							<div style="width: 150px; height: 250px; margin: 10px; border: solid; padding: 10px; position: relative; float: left;">
								<h3> <?php echo $gun." ".$ders.". Saat"; ?> </h3>
								<p>Birinci Saat:</p>
								<?php 
								$birincisaat = $ders.'1';
								$qpbirid = '0';
								$branches = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_questionprocess.qp_student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_questionprocess.qp_day = '$gun' AND {$wpdb->prefix}mp_questionprocess.qp_hour = '$birincisaat' AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$teaid' ", ARRAY_A);
								foreach($branches as $row)
								{
									$birincisc = $row['name']." ".$row['surname']." - ".$row['qp_branch'];
									$qpbirid = $row['qp_id'];
									$qpstu = $row['student_id'];
								}
								echo $birincisc;
								?>
								<form method="POST">
									<input type="hidden" name="qpstu" value="<?php echo $qpstu; ?>">
									<input type="hidden" name="birid" value="<?php echo $qpbirid; ?>">
									<input type="hidden" name="gun" value="<?php echo $gun.$ders; ?>">
									<input type="submit" name="1sil" value="1. saati temizle">
								</form>
								<p>İkinci Saat:</p>
								<?php 
								$ikincisaat = $ders.'2';
								$qpikiid = '0';
								$branches = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_questionprocess, {$wpdb->prefix}mp_student  WHERE {$wpdb->prefix}mp_questionprocess.qp_student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_questionprocess.qp_day = '$gun' AND {$wpdb->prefix}mp_questionprocess.qp_hour = '$ikincisaat' AND {$wpdb->prefix}mp_questionprocess.qp_teacher_id = '$teaid' ", ARRAY_A);
								foreach($branches as $row)
								{
									$ikincisc = $row['name']." ".$row['surname']." - ".$row['qp_branch'];
									$qpikiid = $row['qp_id'];
									$qpstu = $row['student_id'];
								}
								echo $ikincisc;
								?>
								<form method="POST">
									<input type="hidden" name="qpstu" value="<?php echo $qpstu; ?>">
									<input type="hidden" name="ikkid" value="<?php echo $qpikiid; ?>">
									<input type="hidden" name="gun" value="<?php echo $gun.$ders; ?>">
									<input type="submit" name="2sil" value="2. saati temizle">
								</form>
							</div>

							<?php
						}else{
							?>
							<div style="width: 150px; height: 250px; margin: 10px; border: solid; padding: 10px; position: relative; float: left;">
								<h2 style="color: red;"> DOLU </h2>
								<?php 

								?>
								<h4 style="color: red;"><?php echo $dersvarmi; ?></h4>

							</div>

							<?php
						}
					}
				} 



				?>

			</div>

			<?php 
		} ?>
	</div>

	<?php 
	if (isset($_POST['ekle'])) {
		$qpday = $_POST['daylist'];
		$daysdays = explode (" - ",$qpday);
		$qpstu = $_POST['ogrlist'];
		$whowho = explode (" - ",$qpstu);
		$stuid = $whowho[1];
		$qpbranch = $_POST['brans'];
		$qphouryb = $_POST['hangiyirmibes'];
		$qpteacher = $_POST['ogretmen'];
		$dayname = $daysdays[1];
		$hooro = $daysdays[2].$qphouryb;


		$vs = $wpdb->get_results("SELECT $dayname$daysdays[2] FROM {$wpdb->prefix}mp_virtualstudent WHERE student_id = '$stuid' AND $dayname$daysdays[2] = '0' ", ARRAY_A);
		foreach($vs as $vser)
		{
			$vw = $wpdb->get_results("SELECT $dayname FROM {$wpdb->prefix}mp_virtualweek WHERE vw_name = '$teaid - $ders. saat' AND $dayname = '0'", ARRAY_A);
			foreach($vw as $vwer)
			{
				$wpdb->query
				("INSERT INTO `wp_mp_questionprocess` (`qp_day`, `qp_student_id`, `qp_branch`, `qp_hour`, `qp_teacher_id`) VALUES ('$dayname', '$stuid', '$qpbranch', '$hooro', '$qpteacher')");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET $dayname$daysdays[2] = '$qphouryb - $qpbranch - Soru Çözümü' WHERE `student_id` = '$stuid'");
			}
		}

	}


	if (isset($_POST['1sil'])) {
		$qpid = $_POST['birid'];
		$gd = $_POST['gun'];
		$qbstuid = $_POST['qpstu'];
		$wpdb->query
		("DELETE FROM `wp_mp_questionprocess` WHERE `qp_id` = '$qpid' ");
		$wpdb->query
		("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET $gd = '0' WHERE `student_id` = '$qbstuid'");
	}
	if (isset($_POST['2sil'])) {
		$qpid = $_POST['ikkid'];
		$gd = $_POST['gun'];
		$qbstuid = $_POST['qpstu'];
		$wpdb->query
		("DELETE FROM `wp_mp_questionprocess` WHERE `qp_id` = '$qpid' ");
		$wpdb->query
		("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET $gd = '0' WHERE `student_id` = '$qbstuid'");
	}
	?>


	<script>
		function openCity(evt, cityName) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById(cityName).style.display = "block";
			evt.currentTarget.className += " active";
		}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

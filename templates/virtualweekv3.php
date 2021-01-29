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
								<option value=" <?php echo  " - G ".$row['group_name']; ?>"></option>
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

						<input list="branslistesi" name="brans" id="brans" placeholder="Ders">
						<datalist id="branslistesi">
							<?php 
							$students = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_branch  ", ARRAY_A);
							foreach($students as $row)
							{
								?>
								<option value=" <?php echo $row['name']; ?>"></option>
								<?php
							}
							?>

						</datalist>
						<input  type="submit" name="ekle" id="ekle" value="Ders Ekle">
					</form>
				</div>


				<?php 



				foreach ($dersler as $ders) {
					foreach ($gunler as $gun) {
						?>
						<div style="width: 130px; height: 100px; margin: 10px; border: solid; padding: 20px; position: relative; float: left;">
							<h2> <?php echo $gun." ".$ders.". Saat"; ?> </h2>
							<?php 
							$branches = $wpdb->get_results("SELECT $gun FROM {$wpdb->prefix}mp_virtualweek WHERE vw_name = '$teaid - $ders. saat' ", ARRAY_A);
							foreach($branches as $row)
							{
								echo $row[$gun];
							}
							?>
							<form method="POST">
								<input type="hidden" name="gun" value="<?php echo $gun; ?>">
								<input type="hidden" name="saat" value="<?php echo $ders; ?>">
								<input type="hidden" name="teacherwho" value="<?php echo $teaid; ?>">
								<input type="submit" name="sil" value="temizle">
							</form>

							<?php 

							if (isset($_POST['sil'])) {
								$gundelete = $_POST['gun']; 
								$saatdelete = $_POST['saat']; 
								$hocadelete = $_POST['teacherwho']; 
								$cikan = 0;
								$cikanibul = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE `teacher_id` = '$hocadelete' AND `vw_name` = '$hocadelete - $saatdelete. Saat'", ARRAY_A);
								foreach($cikanibul as $ckn){ $cikan = $ckn[$gundelete];}
								if ($cikan != "0") {

									$teacherwho = $_POST['teacherwho'];
									$kim = explode (" ",$cikan);
									$brans = $kim[1];
									$idstu = $kim[2]; 
									$groupnameG = $kim[3];
									?><script type="text/javascript">console.log('<?php echo "kim: ".$idorgroupname." brans: ".$brans ?>');</script><?php
									$wpdb->query
									("UPDATE `{$wpdb->prefix}mp_virtualweek` SET `$gundelete` = '0' WHERE `teacher_id` = '$hocadelete' AND `vw_name` = '$hocadelete - $saatdelete. Saat';");
									$wpdb->query
									("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gundelete$saatdelete` = '0' WHERE `student_id` = '$idstu'");
									
									$indeksgroupa = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group WHERE `group_name` = '$groupnameG'", ARRAY_A);
									foreach($indeksgroupa as $igrowa){
										$std1 = $igrowa['1_student_id'];
										$std2 = $igrowa['2_student_id'];
										$std3 = $igrowa['3_student_id'];
										$std4 = $igrowa['4_student_id'];
										$std5 = $igrowa['5_student_id'];
										$std6 = $igrowa['6_student_id'];
										$gruid = $igrowa['group_id']; 
										$wpdb->query
										("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gundelete$saatdelete` = '0' WHERE `student_id` = '$std1'");
										$wpdb->query
										("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gundelete$saatdelete` = '0' WHERE `student_id` = '$std2'");
										$wpdb->query
										("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gundelete$saatdelete` = '0' WHERE `student_id` = '$std3'");
										$wpdb->query
										("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gundelete$saatdelete` = '0' WHERE `student_id` = '$std4'");
										$wpdb->query
										("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gundelete$saatdelete` = '0' WHERE `student_id` = '$std5'");
										$wpdb->query
										("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gundelete$saatdelete` = '0' WHERE `student_id` = '$std6'");

									}
								}

							}

							?>

						</div>

						<?php

					}
				} 



				?>

			</div>

			<?php 
		} ?>
	</div>

	<?php 
	if (isset($_POST['ekle'])) {
		$teacherwho = $_POST['ogretmen'];
		$daywho = $_POST['daylist'];
		$dayday = explode (" - ",$daywho);
		$gunpost = $dayday[1];
		$derspost = $dayday[2];
		$cikan = 0;
		?><script type="text/javascript">console.log('<?php echo "hangi ders: ".$derspost ?>');</script><?php
		$cikanibul = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualweek WHERE `teacher_id` = '$teacherwho' AND `vw_name` = '$teacherwho - $derspost. Saat'", ARRAY_A);
		foreach($cikanibul as $ckn){ $cikan = $ckn[$gunpost];}
		if ($cikan != "0") {

			$teacherwho = $_POST['ogretmen'];
			$kim = explode (" ",$cikan);
			$brans = $kim[1];
			$idorgroupname = $kim[2];
			?><script type="text/javascript">console.log('<?php echo "kim: ".$idorgroupname." brans: ".$brans ?>');</script><?php
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_virtualweek` SET `$gunpost` = '0' WHERE `teacher_id` = '$teacherwho' AND `vw_name` = '$teacherwho - $derspost. Saat';");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '0' WHERE `student_id` = '$idorgroupname'");
			$kkkaaa = explode (" ",$idorgroupname);
			$groupnameG = $kkkaaa[1];
			$indeksgroupa = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group WHERE `group_name` = '$groupnameG'", ARRAY_A);
			foreach($indeksgroupa as $igrowa){
				$std1 = $igrowa['1_student_id'];
				$std2 = $igrowa['2_student_id'];
				$std3 = $igrowa['3_student_id'];
				$std4 = $igrowa['4_student_id'];
				$std5 = $igrowa['5_student_id'];
				$std6 = $igrowa['6_student_id'];
				$gruid = $igrowa['group_id']; 
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '0' WHERE `student_id` = '$std1'");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '0' WHERE `student_id` = '$std2'");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '0' WHERE `student_id` = '$std3'");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '0' WHERE `student_id` = '$std4'");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '0' WHERE `student_id` = '$std5'");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '0' WHERE `student_id` = '$std6'");

			}
		}

		$giren = $_POST['ogrlist'];
		$kimgirdi = explode (" - ",$giren);
		$bransgiren = $_POST['brans'];
		$idorgroupnamegiren = $kimgirdi[1];
		$girenname = $kimgirdi[0];
		$teacherwho = $_POST['ogretmen'];
		$kkkaaa = explode (" ",$idorgroupnamegiren);
		$groupnameG = $kkkaaa[1];
		$wpdb->query
		("UPDATE `{$wpdb->prefix}mp_virtualweek` SET `$gunpost` = '$bransgiren $idorgroupnamegiren $girenname' WHERE `teacher_id` = '$teacherwho' AND `vw_name` = '$teacherwho - $derspost. Saat';");
		$wpdb->query
		("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '$bransgiren' WHERE `student_id` = '$idorgroupnamegiren'");

		$indeksgroupa = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group WHERE `group_name` = '$groupnameG'", ARRAY_A);
		foreach($indeksgroupa as $igrowa){
			$std1 = $igrowa['1_student_id'];
			$std2 = $igrowa['2_student_id'];
			$std3 = $igrowa['3_student_id'];
			$std4 = $igrowa['4_student_id'];
			$std5 = $igrowa['5_student_id'];
			$std6 = $igrowa['6_student_id'];
			$gruid = $igrowa['group_id']; 
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '$bransgiren - Grup' WHERE `student_id` = '$std1'");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '$bransgiren - Grup' WHERE `student_id` = '$std2'");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '$bransgiren - Grup' WHERE `student_id` = '$std3'");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '$bransgiren - Grup' WHERE `student_id` = '$std4'");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '$bransgiren - Grup' WHERE `student_id` = '$std5'");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_virtualstudent` SET `$gunpost$derspost` = '$bransgiren - Grup' WHERE `student_id` = '$std6'");
		}
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

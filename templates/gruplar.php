<?php require_once dirname(__FILE__, 2).'/assets/mystyle.css'; ?>

<style type="text/css">
	input, label {
		display:block;
		margin: 10px;
	}
</style>
<div style="width: 225px; float: left; margin-right:  100px;">
	<form method="POST">
		<h2>Grup Oluştur</h2>
		<label for="grupname">Grup Adı</label>
		<input type="text" name="grupname">
		<label for="Dropdown1">1. Öğrenci</label>
		<select name="Dropdown1" checktype="c1"><option selected="true" value="" required></option>
			<?php
			global $wpdb;
			$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
			foreach($isong as $row)
			{	
				$stuid = $row['student_id'];
				$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
				foreach($ogr as $ogrow)
				{
					?>
					<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
					<?php
				} 
			} ?>
		</select>

		<label for="Dropdown2">2. Öğrenci</label>
		<select name="Dropdown2" checktype="c2"><option selected="true" value="" required></option>
			<?php
			global $wpdb;
			$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
			foreach($isong as $row)
			{
				$stuid = $row['student_id'];
				$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
				foreach($ogr as $ogrow)
				{
					?>
					<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
					<?php
				} 
			} ?>
		</select>

		<label for="Dropdown3">3. Öğrenci</label>
		<select name="Dropdown3" checktype="c3"><option selected="true" value="" required></option>
			<?php
			global $wpdb;
			$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
			foreach($isong as $row)
			{
				$stuid = $row['student_id'];
				$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
				foreach($ogr as $ogrow)
				{
					?>
					<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
					<?php
				} 
			} ?>
		</select>

		<label for="Dropdown4">4. Öğrenci</label>
		<select name="Dropdown4" checktype="c4"><option selected="true" value="" required></option>
			<?php
			global $wpdb;
			$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
			foreach($isong as $row)
			{
				$stuid = $row['student_id'];
				$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
				foreach($ogr as $ogrow)
				{
					?>
					<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
					<?php
				} 
			} ?>
		</select>

		<label for="Dropdown5">5. Öğrenci</label>
		<select name="Dropdown5" checktype="c5"><option selected="true" value="" required></option>
			<?php
			global $wpdb;
			$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
			foreach($isong as $row)
			{
				$stuid = $row['student_id'];
				$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
				foreach($ogr as $ogrow)
				{
					?>
					<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
					<?php
				} 
			} ?>
		</select>

		<label for="Dropdown6">6. Öğrenci</label>
		<select name="Dropdown6" checktype="c6"><option selected="true" value="" required></option>
			<?php
			global $wpdb;
			$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
			foreach($isong as $row)
			{
				$stuid = $row['student_id'];
				$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
				foreach($ogr as $ogrow)
				{
					?>
					<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
					<?php
				} 
			} ?>
		</select>

		<button class="hellobutton" type="submit" name="addgroup">Grup Oluştur</button>
	</form>
	<?php 
	if (isset($_POST['addgroup'])) {
		$grupname = $_POST['grupname'];
		$stu1 = $_POST['Dropdown1'];
		$stu2 = $_POST['Dropdown2'];
		$stu3 = $_POST['Dropdown3'];
		$stu4 = $_POST['Dropdown4'];
		$stu5 = $_POST['Dropdown5'];
		$stu6 = $_POST['Dropdown6'];

		$grade = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `student_id` = '$stu1'", ARRAY_A);
		foreach($grade as $grader){
			$gradeid=$grader['grade_id'];
			$wpdb->query
			("INSERT INTO `{$wpdb->prefix}lesson_group` (`group_id`, `1_student_id`, `2_student_id`, `3_student_id`, `4_student_id`, `5_student_id`, `6_student_id`, `grade_id`, `group_name`) VALUES (NULL, '$stu1', '$stu2', '$stu3', '$stu4', '$stu5', '$stu6', '$gradeid', '$grupname');");

			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stu1';");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stu2';");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stu3';");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stu4';");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stu5';");
			$wpdb->query
			("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stu6';");

		}
		?><script type="text/javascript">console.log('<?php echo $stu6."df".$gradeid ?>'); </script><?php 
	}
	?>
</div>

<div style="float: left; width: 400px;">
	<?php 

	global $wpdb;
	$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group ORDER BY `group_name` ASC;", ARRAY_A);
	foreach ($sty as $stu) {
		$sname = $stu["group_name"];
		$lgid = $stu["group_id"];
		?>



		<button type="button" class="collapsible"><?php echo $stu['group_name']; ?></button>																
		<div class="content">
			
			<form method="POST">
				<input type="hidden" name="gid" value="<?php echo $_POST['group_id'] ?>">
				<button class="hellobutton" type="submit" name="deleteg">Grubu Sil</button>
			</form>
			<?php


			$stu1 = $stu['1_student_id'];
			$stu2 = $stu['2_student_id'];
			$stu3 = $stu['3_student_id'];
			$stu4 = $stu['4_student_id'];
			$stu5 = $stu['5_student_id'];
			$stu6 = $stu['6_student_id'];
			if (isset($_POST['deleteg'])) {
				
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu1';");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu2';");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu3';");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu4';");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu5';");
				$wpdb->query
				("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu6';");

				$wpdb->query
				("DELETE FROM `{$wpdb->prefix}lesson_group` WHERE `group_id` = '$lgid'");
				?><script type="text/javascript">window.location.reload(); </script><?php 
			}  
			if ($stu1 == 0) {
				?>
				<form method="POST">
					<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
					<select name="Dropdown1" checktype="c1"><option selected="true" value="" required></option>
						<?php
						global $wpdb;
						$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
						foreach($isong as $row)
						{	
							$stuid = $row['student_id'];
							$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
							foreach($ogr as $ogrow)
							{
								?>
								<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
								<?php
							} 
						} ?>
					</select>
					<button class="hellobutton" type="submit" name="addstu">Öğrenci Ekle</button>
				</form>
				<?php 
				if (isset($_POST['addstu'])) {
					$stuid = $_POST['Dropdown1'];
					$posgid = $_POST['groupid'];
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `1_student_id` = '$stuid' WHERE `group_id` = '$posgid';");
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stuid';");
					?><script type="text/javascript">window.location.reload(); </script><?php 
				}
			}
			else{
				$stdnn1 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `student_id` = '$stu1';", ARRAY_A);
				foreach ($stdnn1 as $stdnrow1){
					?>
					<form method="POST">
						<input type="hidden" name="groupid" value="<?php echo $lgid ?>">

						<h2><?php echo $stdnrow1['name']." " .$stdnrow1['surname']; ?></h2>
						<input type="hidden" name="s1id" value="<?php echo $stdnrow1['student_id'] ?>">
						<button class="hellobutton" type="submit" name="sil1">Öğrenciyi Gruptan Çıkar</button>
					</form>
					<?php 
					if (isset($_POST['sil1'])) {
						$posgid = $_POST['groupid'];
						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `1_student_id` = 0 WHERE `group_id` = '$posgid';");

						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu1';");
						?><script type="text/javascript">window.location.reload(); </script><?php 
					}
				}
			}



			//22222222222222222222222222222222222222222222222222


			if ($stu2 == 0) {
				?>
				<form method="POST">
					<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
					<select name="Dropdown2" checktype="c1"><option selected="true" value="" required></option>
						<?php
						global $wpdb;
						$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
						foreach($isong as $row)
						{	
							$stuid = $row['student_id'];
							$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
							foreach($ogr as $ogrow)
							{
								?>
								<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
								<?php
							} 
						} ?>
					</select>
					<button class="hellobutton" type="submit" name="addstu">Öğrenci Ekle</button>
				</form>
				<?php 
				if (isset($_POST['addstu'])) {
					$posgid = $_POST['groupid'];
					$stuid = $_POST['Dropdown2'];
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `2_student_id` = '$stuid' WHERE `group_id` = '$posgid';");
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stuid';");
					?><script type="text/javascript">window.location.reload(); </script><?php 
				}
			}
			else{
				$stdnn2 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `student_id` = '$stu2';", ARRAY_A);
				foreach ($stdnn2 as $stdnrow2){
					?>
					<form method="POST">
						<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
						<h2><?php echo $stdnrow2['name']." " .$stdnrow2['surname']; ?></h2>
						<input type="hidden" name="s2id" value="<?php echo $stdnrow2['student_id'] ?>">
						<button class="hellobutton" type="submit" name="sil2">Öğrenciyi Gruptan Çıkar</button>
					</form>
					<?php 
					if (isset($_POST['sil2'])) {
					$posgid = $_POST['groupid'];
						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `2_student_id` = 0 WHERE `group_id` = '$posgid';");

						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu2';");
						?><script type="text/javascript">window.location.reload(); </script><?php 
					}
				}
			}



			//3




			if ($stu3 == 0) {
				?>
				<form method="POST">
					<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
					<select name="Dropdown3" checktype="c1"><option selected="true" value="" required></option>
						<?php
						global $wpdb;
						$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
						foreach($isong as $row)
						{	
							$stuid = $row['student_id'];
							$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
							foreach($ogr as $ogrow)
							{
								?>
								<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
								<?php
							} 
						} ?>
					</select>
					<button class="hellobutton" type="submit" name="addstu">Öğrenci Ekle</button>
				</form>
				<?php 
				if (isset($_POST['addstu'])) {
					$posgid = $_POST['groupid'];
					$stuid = $_POST['Dropdown3'];
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `3_student_id` = '$stuid' WHERE `group_id` = '$posgid';");
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stuid';");
					?><script type="text/javascript">window.location.reload(); </script><?php 
				}
			}
			else{
				$stdnn3 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `student_id` = '$stu3';", ARRAY_A);
				foreach ($stdnn3 as $stdnrow3){
					?>
					<form method="POST">
						<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
						<h2><?php echo $stdnrow3['name']." " .$stdnrow3['surname']; ?></h2>
						<input type="hidden" name="s3id" value="<?php echo $stdnrow3['student_id'] ?>">
						<button class="hellobutton" type="submit" name="sil3">Öğrenciyi Gruptan Çıkar</button>
					</form>
					<?php 
					if (isset($_POST['sil3'])) {
					$posgid = $_POST['groupid'];
						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `3_student_id` = 0 WHERE `group_id` = '$posgid';");

						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu3';");
						?><script type="text/javascript">window.location.reload(); </script><?php 
					}
				}
			}



			//4



			if ($stu4 == 0) {
				?>
				<form method="POST">
					<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
					<select name="Dropdown4" checktype="c4"><option selected="true" value="" required></option>
						<?php
						global $wpdb;
						$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
						foreach($isong as $row)
						{	
							$stuid = $row['student_id'];
							$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
							foreach($ogr as $ogrow)
							{
								?>
								<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
								<?php
							} 
						} ?>
					</select>
					<button class="hellobutton" type="submit" name="addstu">Öğrenci Ekle</button>
				</form>
				<?php 
				if (isset($_POST['addstu'])) {
					$posgid = $_POST['groupid'];
					$stuid = $_POST['Dropdown4'];
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `4_student_id` = '$stuid' WHERE `group_id` = '$posgid';");
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stuid';");
					?><script type="text/javascript">window.location.reload(); </script><?php 
				}
			}
			else{
				$stdnn4 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `student_id` = '$stu4';", ARRAY_A);
				foreach ($stdnn4 as $stdnrow4){
					?>
					<form method="POST">
						<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
						<h2><?php echo $stdnrow4['name']." " .$stdnrow4['surname']; ?></h2>
						<input type="hidden" name="s4id" value="<?php echo $stdnrow4['student_id'] ?>">
						<button class="hellobutton" type="submit" name="sil4">Öğrenciyi Gruptan Çıkar</button>
					</form>
					<?php 
					if (isset($_POST['sil4'])) {
					$posgid = $_POST['groupid'];
						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `4_student_id` = 0 WHERE `group_id` = '$posgid';");

						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu4';");
						?><script type="text/javascript">window.location.reload(); </script><?php 
					}
				}
			}




			//5



			if ($stu5 == 0) {
				?>
				<form method="POST">
					<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
					<select name="Dropdown5" checktype="c5"><option selected="true" value="" required></option>
						<?php
						global $wpdb;
						$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
						foreach($isong as $row)
						{	
							$stuid = $row['student_id'];
							$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
							foreach($ogr as $ogrow)
							{
								?>
								<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
								<?php
							} 
						} ?>
					</select>
					<button class="hellobutton" type="submit" name="addstu">Öğrenci Ekle</button>
				</form>
				<?php 
				if (isset($_POST['addstu'])) {
					$posgid = $_POST['groupid'];
					$stuid = $_POST['Dropdown5'];
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `5_student_id` = '$stuid' WHERE `group_id` = '$posgid';");
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stuid';");
					?><script type="text/javascript">window.location.reload(); </script><?php 
				}
			}
			else{
				$stdnn5 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `student_id` = '$stu5';", ARRAY_A);
				foreach ($stdnn5 as $stdnrow5){
					?>
					<form method="POST">
						<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
						<h2><?php echo $stdnrow5['name']." " .$stdnrow5['surname']; ?></h2>
						<input type="hidden" name="s5id" value="<?php echo $stdnrow5['student_id'] ?>">
						<button class="hellobutton" type="submit" name="sil5">Öğrenciyi Gruptan Çıkar</button>
					</form>
					<?php 
					if (isset($_POST['sil5'])) {
					$posgid = $_POST['groupid'];
						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `5_student_id` = 0 WHERE `group_id` = '$posgid';");

						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu5';");
						?><script type="text/javascript">window.location.reload(); </script><?php 
					}
				}
			}



			//6,




			if ($stu6 == 0) {
				?>
				<form method="POST">
					<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
					<select name="Dropdown6" checktype="c6"><option selected="true" value="" required></option>
						<?php
						global $wpdb;
						$isong = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_isongroup WHERE `ison` = 0", ARRAY_A);
						foreach($isong as $row)
						{	
							$stuid = $row['student_id'];
							$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `active` = 1 AND `student_id` = '$stuid' ", ARRAY_A);
							foreach($ogr as $ogrow)
							{
								?>
								<option value="<?php echo $ogrow["student_id"]; ?>"><?php echo $ogrow["name"] . " " . $ogrow["surname"]. "  |  " . $ogrow["number"]; ?></option>
								<?php
							} 
						} ?>
					</select>
					<button class="hellobutton" type="submit" name="addstu">Öğrenci Ekle</button>
				</form>
				<?php 
				if (isset($_POST['addstu'])) {
					$posgid = $_POST['groupid'];
					$stuid = $_POST['Dropdown6'];
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `6_student_id` = '$stuid' WHERE `group_id` = '$posgid';");
					$wpdb->query
					("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '1' WHERE `student_id` = '$stuid';");
					?><script type="text/javascript">window.location.reload(); </script><?php 
				}
			}
			else{
				$stdnn6 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE `student_id` = '$stu6';", ARRAY_A);
				foreach ($stdnn6 as $stdnrow6){
					?>
					<form method="POST">
						<input type="hidden" name="groupid" value="<?php echo $lgid ?>">
						<h2><?php echo $stdnrow6['name']." " .$stdnrow6['surname']; ?></h2>
						<input type="hidden" name="s6id" value="<?php echo $stdnrow6['student_id'] ?>">
						<button class="hellobutton" type="submit" name="sil6">Öğrenciyi Gruptan Çıkar</button>
					</form>
					<?php 
					if (isset($_POST['sil6'])) {
					$posgid = $_POST['groupid'];
						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_lesson_group` SET `6_student_id` = 0 WHERE `group_id` = '$posgid';");

						$wpdb->query
						("UPDATE `{$wpdb->prefix}mp_isongroup` SET `ison` = '0' WHERE `student_id` = '$stu6';");
						?><script type="text/javascript">window.location.reload(); </script><?php 
					}
				}

			}
			?>
		</div>
		<?php 
	}
	?>
</div>
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
</div>
<style>
	table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}

	td, th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even) {
		background-color: #dddddd;
	}
</style>
<?php

global $wpdb;
$getSAURL = site_url().'/wp-content/plugins/meeting-parents/exams/getStudentAnswers.php';
$generateSAURL = site_url().'/wp-content/plugins/meeting-parents/exams/generateSA.php';

?>
<p id="paragraf" name="paragraf"></p>
<table class="table" id="maintable">
	<tr>
		<th>Deneme</th>
		<th>Öğrenci Ekle</th>
	</tr>
	<td>
		<div name="exam" id="exam">
			<select onchange="getStudentAnswer('<?php echo $getSAURL; ?>')">
				<option>-Deneme Sınavı Seçin-</option>
				<?php 
				$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_exams ORDER BY exam_date DESC;", ARRAY_A);
				foreach ($wholeexams as $we){

					?>
					<option   value="<?php echo $we["exam_id"];?>-<?php echo $we["exam_type"];?>"><?php echo $we["exam_name"].' '.$we["exam_type"].' - '.$we["exam_date"]; ?></option>
					<?php 
				}
				?>
			</select>
		</div>
	</td>
	<td>
		<div name="student" id="student">
			<select onchange="myFunction()">
				<option>-Öğrenci Seçin-</option>
				<?php 
				$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student ORDER BY name, surname ASC;", ARRAY_A);
				foreach ($wholeexams as $we){

					?>
					<option   value="<?php echo $we["student_id"];?>"><?php echo $we["name"].'  '.$we["surname"].' - '.$we["number"]; ?></option>
					<?php 
				}
				?>
			</select>
		</div>
	</td>
</table>
<br><br><br>
<table class="table" name="answerTable" id="answerTable">
	<tr>
		<th>Öğrenci</th>
		<th>Cevaplar</th>
	</tr>	
</table>


<script>
	function myFunction() {
		var name = jQuery( "#student option:selected" ).text(); 
		if (confirm(name + " adlı öğrenciyi bu sınava eklemek istiyor musunuz?")) {
			generateSA('<?php echo $generateSAURL; ?>')
		} else {
		}
	}
</script>
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
$getQuestionsURL = site_url().'/wp-content/plugins/meeting-parents/exams/getQuestions.php';


?>
<div name="exam" id="exam">
<select onchange="getQuestions('<?php echo $getQuestionsURL; ?>')">
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
<br>
<table class="table">

	
</table>
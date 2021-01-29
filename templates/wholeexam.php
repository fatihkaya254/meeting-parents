

<?php 
$getExamURL = site_url().'/wp-content/plugins/meeting-parents/exams/getExams.php';
$addExamURL = site_url().'/wp-content/plugins/meeting-parents/exams/addExam.php';
?>

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

<table class="table">
	<tr>
		<th>Deneme Adı</th>
		<th>Sınıf</th>
		<th>Tarih</th>
		<th>ID</th>
	</tr> 
	<tr>
		<td>
			<input type="text" name="examName" id="examName" placeholder="Sınav Adı">
		</td>
		<td>
			<input type="date" name="examDate" id="examDate">
		</td>
		<td>
			<select name="examType" id="examType">
				<option value="LGS">LGS</option>
				<option value="TYT">TYT</option>
				<option value="YKS">YKS</option>
			</select>			
		</td>
		<td>
			<input type="submit" name="examEkle" id="examEkle" onclick="addExam('<?php echo $addExamURL; ?>')">
		</td>
	</tr>
</table>

<script>
    
 jQuery(document).ready(function(){

    var getUrl = "<?php echo $getExamURL;?>";         
    getExams(getUrl);

});
</script>
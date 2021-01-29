
<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");
$generateQuestionsURL = site_url().'/wp-content/plugins/meeting-parents/exams/generateQuestions.php';
$setAnswerUrl = site_url().'/wp-content/plugins/meeting-parents/exams/setAnswer.php';
$selectPhotoUrl = site_url().'/wp-content/plugins/meeting-parents/exams/selectPhoto.php';
$setTitleURL = site_url().'/wp-content/plugins/meeting-parents/exams/setTitle.php';
$setURLUrl = site_url().'/wp-content/plugins/meeting-parents/exams/setURL.php';


if (isset($_POST['getExam']) && $_POST['getExam'] == '1') {

	global $wpdb;
	$content = '';


	$examInfo = $_POST['exam'];
	$infoes = explode("-", $examInfo);
	$examID = $infoes[0];
	$examType = $infoes[1];

	$wholeexams = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_questions, {$wpdb->prefix}ex_branch WHERE {$wpdb->prefix}ex_questions.exbranch_id = {$wpdb->prefix}ex_branch.exbranch_id AND exam_id = '$examID' ORDER BY {$wpdb->prefix}ex_questions.exbranch_id, {$wpdb->prefix}ex_questions.question_rating ASC;", ARRAY_A);
	if ($wholeexams == null) {
		$content .= '<input type="hidden" name="examid" id="examid" value="'.$examID.'">';
		$content .= '<input type="hidden" name="examtype" id="examtype" value="'.$examType.'">';
		$content .= '<input type="submit" name="getir" onclick="generateQuestions(\''.$generateQuestionsURL.'\')" value="Deneme Sorularını Oluştur">';
	}else{
		$content .= '<tr>';
		$content .= '<th>Branş</th>';
		$content .= '<th>Soru</th>';
		$content .= '<th>Cevap - A</th>';
		$content .= '<th>B</th>';
		$content .= '<th>Fotoğraf</th>';
		$content .= '<th>Çözüm Linki</th>';
		$content .= '<th>Konu 1</th>';
		$content .= '<th>Konu 2</th>';
		$content .= '<th>Konu 3</th>';
		$content .= '<tr>';
	}

	foreach ($wholeexams as $we){
		$content .= '<tr>';
		$content .= '<td>'.$we["exbranch_name"].'</td>';
		$content .= '<td>'.$we["question_rating"].'</td>';
		$content .= '<td><input style="width: 50px;" type="text" name="'.$we["question_id"].'answer" id="'.$we["question_id"].'answer" value="'.$we["question_answer"].'" maxlength="1"  onfocusout="setAnswer(\''.$we["question_id"].'\',\''.$setAnswerUrl.'\',\'\')"></td>';		
		$content .= '<td><input style="width: 50px;" type="text" name="'.$we["question_id"].'answerb" id="'.$we["question_id"].'answerb" value="'.$we["question_answer_b"].'" maxlength="2"  onfocusout="setAnswer(\''.$we["question_id"].'\',\''.$setAnswerUrl.'\',\'b\')"></td>';
		$content .= '<td><img name="'.$we["question_id"].'img" id="'.$we["question_id"].'img" style="width: 50px;" onclick="bigImg(this)" onmouseout="normalImg(this)" src="data:image/jpeg;base64,'.base64_encode($we["question_pic"]).'"><input type="file" name="'.$we["question_id"].'photo" id="'.$we["question_id"].'photo" accept="image/*" oninput="selectPhoto(\''.$we["question_id"].'\',\''.$selectPhotoUrl.'\', this)" ></td>';
		$content .= '<td><input type="text" value="'.$we["question_solvelink"].'" id="'.$we["question_id"].'solvelink" name="'.$we["question_id"].'solvelink" onfocusout="setURL(\''.$we["question_id"].'\',\''.$setURLUrl.'\')"><br><a href="'.$we["question_solvelink"].'" id="'.$we["question_id"].'a" name="'.$we["question_id"].'a">Linke Git</a></td>';

		$barid = $we["exbranch_id"];
		$content .= '<td>';
		$content .= '<select name="'.$we["question_id"].'title1" id="'.$we["question_id"].'title1" onchange="setTitle(\''.$we["question_id"].'\',\''. $setTitleURL .'\',\'1\')">';
		$content .= '<option></option>';
		$aracontent = '';
		$wholeTitles = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_titles WHERE exbranch_id = '$barid'", ARRAY_A);
		foreach ($wholeTitles as $wt){
			$content .= '<option value="'.$wt["title_id"].'">'.$wt["title_id"].' - '.$wt["title_name"].'</option>';
			if ($wt["title_id"] == $we["question_title_1"]) {
				$aracontent .= $wt["title_name"];
			}
		}
		$content .= '</select>';
		$content .= '<p id="'.$we["question_id"].'title1content1">'.$aracontent.'</p>';
		$content .= '</td>';

		$content .= '<td>';
		$content .= '<select name="'.$we["question_id"].'title2" id="'.$we["question_id"].'title2" onchange="setTitle(\''.$we["question_id"].'\',\''. $setTitleURL .'\',\'2\')">';
		$content .= '<option></option>';
		$aracontent = '';
		$wholeTitles = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_titles WHERE exbranch_id = '$barid'", ARRAY_A);
		foreach ($wholeTitles as $wt){
			$content .= '<option value="'.$wt["title_id"].'">'.$wt["title_id"].' - '.$wt["title_name"].'</option>';
			if ($wt["title_id"] == $we["question_title_2"]) {
				$aracontent .= $wt["title_name"];
			}
		}
		$content .= '</select>';
		$content .= '<p id="'.$we["question_id"].'title1content2">'.$aracontent.'</p>';
		$content .= '</td>';

		$content .= '<td>';
		$content .= '<select name="'.$we["question_id"].'title3" id="'.$we["question_id"].'title3" onchange="setTitle(\''.$we["question_id"].'\',\''. $setTitleURL .'\',\'3\')">';
		$content .= '<option></option>';
		$aracontent = '';
		$wholeTitles = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ex_titles WHERE exbranch_id = '$barid'", ARRAY_A);
		foreach ($wholeTitles as $wt){
			$content .= '<option value="'.$wt["title_id"].'">'.$wt["title_id"].' - '.$wt["title_name"].'</option>';
			if ($wt["title_id"] == $we["question_title_3"]) {
				$aracontent .= $wt["title_name"];
			}
		}
		$content .= '</select>';
		$content .= '<p id="'.$we["question_id"].'title1content3">'.$aracontent.'</p>';
		$content .= '</td>';
		$content .= '</tr>';
	}

	$content .= '
	<script>
	function setAnswer(id, setUrl, type){
		var fdrntl = new FormData();
		fdrntl.append(\'setAnswer\',\'1\'); 
		fdrntl.append(\'queid\',id); 
		fdrntl.append(\'type\',type); 
		fdrntl.append(\'answer\',jQuery("#"+id+"answer"+type).val()); 
		posttophp(fdrntl, setUrl, setAnswerCallback);
	}

	function setAnswerCallback(data){
		console.log(\'mission also success\');

		var jdata = JSON.parse(data);
		console.log(jdata.success);
		console.log(\'test\');
		if (jdata.success == 1) {
			console.log(\'mission success\');
			var content = jdata.content;
			var queid = jdata.queid;
			var type = jdata.type;
			jQuery("#"+queid+"answer"+type).val(content);
			jQuery("#"+queid+"answer"+type).css("background-color","#A7D9D4");
		}
	}

	function selectPhoto(id, setUrl, input){
		var fdrntl = new FormData();
		fdrntl.append(\'selectPhoto\',\'1\'); 

		console.log(input)
		var filler = jQuery(input)[0].files;

		console.log(jQuery(input).prop("files"));

		console.log("filler: " + filler[0]);
		fdrntl.append(\'queid\',id); 
		fdrntl.append(\'photo\',filler[0]); 
		
		
		console.log(fdrntl[\'photo\']); 
		

		posttophp(fdrntl, setUrl, selectPhotoCallback);
	}

	function selectPhotoCallback(data){
		console.log(\'mission also success\');

		var jdata = JSON.parse(data);
		console.log(jdata.success);
		console.log(\'test\');
		if (jdata.success == 1) {
			console.log(\'mission success\');
			var content = jdata.content;
			var queid = jdata.queid;
			
			jQuery("#"+queid+"img").attr("src", src="data:image/jpeg;base64, " + content);
			jQuery("#"+queid+"img").css("background-color","#A7D9D4");
		}
	}

	function bigImg(x) {
		x.style.width = "500px";
	}

	function normalImg(x) {
		x.style.width = "50px";
	}

	function setTitle(id, setUrl, wt){
		var fdrnt2 = new FormData();
		fdrnt2.append(\'setTitle\',\'1\'); 
		fdrnt2.append(\'queid\',id); 
		fdrnt2.append(\'titleb\',jQuery("select[name="+id+"title"+wt+"] option").filter(":selected").val()); 
		fdrnt2.append(\'wt\',wt); 
		console.log(jQuery("select[name="+id+"title"+wt+"] option").filter(":selected").val())
		posttophp(fdrnt2, setUrl, setTitleCallback);
	}

	function setTitleCallback(data){
		console.log(\'mission also success\');

		var jdata = JSON.parse(data);
		console.log(jdata.success);
		console.log(\'test\');
		if (jdata.success == 1) {
			console.log(\'mission success\');
			var content = jdata.content;
			var wt = jdata.wt;
			var queid = jdata.queid;
			console.log(wt);

			jQuery("#"+queid+"title1content"+wt).text(content);
			jQuery("#"+queid+"title1content"+wt).css("background-color","#A7D9D4");
		}
	}


	function setURL(id, setUrl){
		var fdrnt2 = new FormData();
		fdrnt2.append(\'setURL\',\'1\'); 
		fdrnt2.append(\'queid\',id); 
		fdrnt2.append(\'solvelink\',jQuery("#"+id+"solvelink").val()); 
		console.log(jQuery("#"+id+"solvelink").val());

		posttophp(fdrnt2, setUrl, setURLCallback);
	}

	function setURLCallback(data){
		console.log(\'mission also success\');

		var jdata = JSON.parse(data);
		console.log(jdata.success);
		console.log(jdata.content);
		console.log(\'test\');
		if (jdata.success == 1) {
			console.log(\'mission success\');
			var content = jdata.content;
			var queid = jdata.queid;
			console.log(content);

			jQuery("#"+queid+"a").attr("href", content);
			jQuery("#"+queid+"a").css("background-color","#A7D9D4");
		}
	}

	</script>';
	$content .= '<style type="text/css">
	input[type="file"]::before{
		content: \'Seç\';
		display: inline-block;
		background: linear-gradient(top, #f9f9f9, #e3e3e3);
		border: 1px solid #999;
		border-radius: 3px;
		padding: 5px 8px;
		outline: none;
		white-space: nowrap;
		cursor: pointer;
		font-weight: 700;
		font-size: 10pt;
		visibility: visible;
	}
	input[type="file"]:hover::before{
		content: \'Seç\';
		display: inline-block;
		background: black;
		padding: 5px 8px;
		outline: none;
		color: white;		
	}
	input[type="file"]{		
		visibility: hidden;
		width: 40px;
	}
	</style>';
	$returning = [];
	$returning['success'] = 1;
	$returning['content'] = $content;
	echo json_encode($returning);
} 
?>


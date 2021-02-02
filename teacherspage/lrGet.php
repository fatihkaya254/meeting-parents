<?php 

class lrGet{
	private $wpdb;
	public $branchID = 0;
	private $wholebranch;
	private $name;
	public $groupStudents = array(0,0,0,0,0,0);
	public $exHomework = 'Önceki ödev bilgisi yok';
	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;
	}

	function getBranchID ($branchName): int {
		global $wpdb;
		$this->wholebranch = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_branch WHERE name = '$branchName';", ARRAY_A);
		foreach ($this->wholebranch as $wb){
			$this->branchID = $wb['branch_id'];
		}
		return $this->branchID;
	}

	function getStudentNames ($studentID){
		global $wpdb;
		$this->wholebranch = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE student_id = '$studentID';", ARRAY_A);
		foreach ($this->wholebranch as $wb){
			$this->name = $wb['name'].' '.$wb['surname'];
		}
		return $this->name;
	}

	function getGroupStudents ($groupName){
		global $wpdb;
		$this->wholebranch = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_group WHERE group_name = '$groupName';", ARRAY_A);
		foreach ($this->wholebranch as $wb){
			$this->groupStudents[0] = $wb['1_student_id'];
			$this->groupStudents[1] = $wb['2_student_id'];
			$this->groupStudents[2] = $wb['3_student_id'];
			$this->groupStudents[3] = $wb['4_student_id'];
			$this->groupStudents[4] = $wb['5_student_id'];
			$this->groupStudents[5] = $wb['6_student_id'];
		}
		return $this->groupStudents;
	}

	function getExHomework ($tarih, $teacherid, $studentID){
		global $wpdb;
		$this->wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE teacher_id = '$teacherid' AND student_id = '$studentID' AND date_info < '$tarih' ORDER BY date_info DESC LIMIT 0,1;", ARRAY_A);
		foreach ($this->wholerecords as $wr){ 
			$this->exHomework = $wr['next_homework'];
		}
		return $this->exHomework;
	}


	function getRI ($teacherid, $studentID, $dateInfo, $rI){
		global $wpdb;
		
		$this->wholerecords  = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE teacher_id = '$teacherid' AND student_id = '$studentID' AND date_info = '$dateInfo' ORDER BY date_info ASC LIMIT 0,1;", ARRAY_A);
					foreach ($this->wholerecords  as $tr){ 
						$rI['cssClassL'] = 'lesson_cont la';
						$rI['cssClassR'] = 'lesson_cont ra';
						$rI['recordID'] = $tr['lr_id'];
						$rI['cssClasslist']  = 'active';

						if ($tr['lesson_status'] != "0") {
							$rI['lessonTopic']= $tr['lesson_status'];
						}
						if ($tr['next_homework'] != "0") {
							$rI['nextHomework']= $tr['next_homework'];
						}
						if ($tr['homework_status'] != "0") {
							$rI['homeworkStatus'] = $tr['homework_status'];
						}	
					}
					return $rI;
	}

	function getGRI ($teacherid, $studentID, $dateInfo, $gRI){
		global $wpdb;
	
		for ($i=0; $i < 6 ; $i++) { 
		
			$this->wholerecords  = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE teacher_id = '$teacherid' AND student_id = '$studentID[$i]' AND date_info = '$dateInfo' ORDER BY date_info ASC LIMIT 0,1;", ARRAY_A);
			foreach ($this->wholerecords  as $tr){ 
				$gRI['cssClassL'] = 'lesson_cont la';
				$gRI['cssClassR'] = 'lesson_cont ra';
				$gRI['cssClasslist']  = 'active';
							
				$gRI['recordID'][$i] = $tr['lr_id'];
							
				if ($tr['lesson_status'] != "0") {
					$gRI['lessonTopic'][$i]= $tr['lesson_status'];
				}
				if ($tr['next_homework'] != "0") {
					$gRI['nextHomework'][$i]= $tr['next_homework'];
				}
				if ($tr['homework_status'] != "0") {
					$gRI['homeworkStatus'][$i] = $tr['homework_status'];
				}	
			}
		}
		
		return $gRI;
		
	}

	function homeworkStatus($url, $styleClass, $vwid, $homeworkStatus, $content){

		$content .= '<div class="'.$styleClass.' '.$vwid.'b">';
		$content .= '<label>Önceki Derste Verilen Ödev</label><br>';
		$content .= '<label class="container">Tam Yaptı';

		if ($homeworkStatus == tam) {
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" checked="checked" name="radiobtn'.$vwid.'" id="tam'.$vwid.'" value="tam">';
		}else{
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" name="radiobtn'.$vwid.'" id="tam'.$vwid.'" value="tam">';
		}		

		$content .= '<span class="checkmark"></span>';
		$content .= '</label>';
		$content .= '<label class="container">Eksik/Özensiz';

		if ($homeworkStatus == eksik) {
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" checked="checked" id="eksik'.$vwid.'" name="radiobtn'.$vwid.'" value="eksik">';
		}else{
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" name="radiobtn'.$vwid.'" id="eksik'.$vwid.'" value="eksik">';
		}

		$content .= '<span class="checkmark"></span>';
		$content .= '</label>';
		$content .= '<label class="container">Yapmadı';

		if ($homeworkStatus == yok) {
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" checked="checked" id="yok'.$vwid.'" name="radiobtn'.$vwid.'" value="yok">';
		}else{
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" name="radiobtn'.$vwid.'" id="yok'.$vwid.'" value="yok">';
		}

		$content .= '<span class="checkmark"></span>';
		$content .= '</label>';
		$content .= '<label class="container">Verilmemişti';

		if ($homeworkStatus == verilmedi) {
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" checked="checked" id="verilmedi'.$vwid.'" name="radiobtn'.$vwid.'" value="verilmedi">';
		}else{
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" name="radiobtn'.$vwid.'" id="verilmedi'.$vwid.'" value="verilmedi">';
		}	
		
		$content .= '<span class="checkmark"></span>';
		$content .= '</label>';
		$content .= '<label class="container">Katılmadı';

		if ($homeworkStatus == katilmadi) {
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" checked="checked" id="katilmadi'.$vwid.'" name="radiobtn'.$vwid.'" value="katilmadi">';
		}else{
			$content .= '<input type="radio" onclick="radioFunction(\''.$url.'\',\''.$vwid.'\')" name="radiobtn'.$vwid.'" id="katilmadi'.$vwid.'" value="katilmadi">';
		}	

		$content .= '<span class="checkmark"></span>
		</label>
		</div>';

		return $content;
	}

	function homeworkStatusG($url, $styleClass, $vwid, $homeworkStatus, $content, $gRI, $i){
		// tüm butonların isimlerine ve idlerine $i ekle
		$content .= '<div class="'.$styleClass.' '.$vwid.'b">';
		$content .= '<label>'.$gRI['names'][$i].'</label><br>';
		$content .= '<label name="lTG'.$vwid.$i.'" id="lTG'.$vwid.$i.'">'.$gRI['lessonTopic'][$i].'</label><br>';
		$content .= '<label name="nHG'.$vwid.$i.'" id="nHG'.$vwid.$i.'">'.$gRI['nextHomework'][$i].'</label><br>';
		$content .= '<label class="container">Tam Yaptı';

		if ($homeworkStatus == tam) {
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" checked="checked" name="radiobtn'.$vwid.$i.'" id="tam'.$vwid.$i.'" value="tam">';
		}else{
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" name="radiobtn'.$vwid.$i.'" id="tam'.$vwid.$i.'" value="tam">';
		}		

		$content .= '<span class="checkmark"></span>';
		$content .= '</label>';
		$content .= '<label class="container">Eksik/Özensiz';

		if ($homeworkStatus == eksik) {
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" checked="checked" id="eksik'.$vwid.$i.'" name="radiobtn'.$vwid.$i.'" value="eksik">';
		}else{
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" name="radiobtn'.$vwid.$i.'" id="eksik'.$vwid.$i.'" value="eksik">';
		}

		$content .= '<span class="checkmark"></span>';
		$content .= '</label>';
		$content .= '<label class="container">Yapmadı';

		if ($homeworkStatus == yok) {
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" checked="checked" id="yok'.$vwid.$i.'" name="radiobtn'.$vwid.$i.'" value="yok">';
		}else{
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" name="radiobtn'.$vwid.$i.'" id="yok'.$vwid.$i.'" value="yok">';
		}

		$content .= '<span class="checkmark"></span>';
		$content .= '</label>';
		$content .= '<label class="container">Verilmemişti';

		if ($homeworkStatus == verilmedi) {
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" checked="checked" id="verilmedi'.$vwid.$i.'" name="radiobtn'.$vwid.$i.'" value="verilmedi">';
		}else{
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" name="radiobtn'.$vwid.$i.'" id="verilmedi'.$vwid.$i.'" value="verilmedi">';
		}		

		$content .= '<span class="checkmark"></span>';
		$content .= '</label>';
		$content .= '<label class="container">Katılmadı';

		if ($homeworkStatus == katilmadi) {
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" checked="checked" id="katilmadi'.$vwid.$i.'" name="radiobtn'.$vwid.$i.'" value="katilmadi">';
		}else{
			$content .= '<input type="radio" onclick="radioFunctionG(\''.$url.'\',\''.$vwid.'\',\''.$i.'\')" name="radiobtn'.$vwid.$i.'" id="katilmadi'.$vwid.$i.'" value="katilmadi">';
		}	

		$content .= '<span class="checkmark"></span>
		</label>
		</div>';

		return $content;
	}

}

?>
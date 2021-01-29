<?php 

class lrGet{
	public $deneme;
	private $wpdb;
	public $branchID = 0;
	private $wholebranch;
	public $groupStudents = array(0,0,0,0,0,0);
	public $exHomework = 'Önceki ödev bilgisi yok.';
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

	function getExHomework ($tarih){
		global $wpdb;
		$this->wholerecords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_lesson_records WHERE teacher_id = '$teacherid' AND student_id = '$studentID' AND date_info < '2021.01.09' ORDER BY date_info ASC LIMIT 0,1;", ARRAY_A);
		foreach ($wholerecords as $wr){ 
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

}

?>
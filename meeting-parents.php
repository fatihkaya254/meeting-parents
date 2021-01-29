<?php

/**
* @package MeetingParents
*/
/*
Plugin Name: Meeting Parents
Plugin URI: https://isleyenzihinler.com.tr
Description: Görüşme programını düzenlemek için oluşturulmuştur.
Version: 1.0.7
Author: Fatih Kaya
Author URI: https://isleyenzihinler.com.tr
License: GNU
Text Domain: meeting-parents
*/


if ( ! defined('ABSPATH') ) {	die;   }


function foobar_func($params = array()) {
	ob_start();
	include (dirname(__FILE__, 1) . '/templates/helloTeacher.php');
	$ob_str=ob_get_contents();
	ob_end_clean();
	return $ob_str;
}
add_shortcode( 'foobar', 'foobar_func' );

function sensmsmshortcode_func($params = array()) {
	ob_start();
	include (dirname(__FILE__, 1) . '/templates/sendsms.php');
	$ob_str=ob_get_contents();
	ob_end_clean();
	return $ob_str;
}
add_shortcode( 'smssendmp', 'sensmsmshortcode_func' );

function see_all($params = array()) {
	ob_start();
	include (dirname(__FILE__, 1) . '/templates/helloadmin.php');
	$ob_str=ob_get_contents();
	ob_end_clean();
	return $ob_str;
}
add_shortcode( 'see', 'see_all' );


function see_process($params = array()) {
	ob_start();
	include (dirname(__FILE__, 1) . '/templates/hellostudent.php');
	$ob_str=ob_get_contents();
	ob_end_clean();
	return $ob_str;
}

// register shortcode
add_shortcode('yourprocess', 'see_process');


function whole_exams($params = array()) {
	ob_start();
	include (dirname(__FILE__, 1) . '/templates/wholeexam.php');
	$ob_str=ob_get_contents();
	ob_end_clean();
	return $ob_str;
}

// register shortcode
add_shortcode('mp-whole-exams', 'whole_exams');


function student_answers($params = array()) {
	ob_start();
	include (dirname(__FILE__, 1) . '/templates/studentAnswers.php');
	$ob_str=ob_get_contents();
	ob_end_clean();
	return $ob_str;
}

// register shortcode
add_shortcode('mp-student-answers', 'student_answers');


function teachers_page($params = array()) {
	ob_start();
	include (dirname(__FILE__, 1) . '/templates/teacherspage.php');
	$ob_str=ob_get_contents();
	ob_end_clean();
	return $ob_str;
}

// register shortcode
add_shortcode('mp-teachers-page', 'teachers_page');



function exam_questions($params = array()) {
	ob_start();
	include (dirname(__FILE__, 1) . '/templates/examQuestions.php');
	$ob_str=ob_get_contents();
	ob_end_clean();
	return $ob_str;
}

// register shortcode
add_shortcode('mp-exam-questions', 'exam_questions');


function meet_parents_js(){
	$jsway = site_url().'/wp-content/plugins/meeting-parents/assets/myscript.js';
	$cssway = site_url().'/wp-content/plugins/meeting-parents/assets/mystyle.css';
	?>
	<style src="<?php echo $cssway;?>" type="text/css"></style>
	<script src="<?php echo 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js';?>"></script> 
	<script src="<?php echo $jsway;?>"></script> 
	<?php
}
add_action( 'wp_footer', 'meet_parents_js');
add_action('admin_enqueue_scripts', 'meet_parents_js');


function control_everydays(){
	$lrgeturl = site_url().'/wp-content/plugins/meeting-parents/lessonrecords/';
	$content = '';
	$content .= '<h4>Merhaba Dünya<h4/>';
	$content .= '<input type="date" name="tarih" id="tarih" placeholder="YYYY-AA-GG">';
	$content .= '<input type="text" name="teaid" id="teaid" placeholder="Öğretmen ID">';
	$content .= '<input type="submit" name="cgetir" id="cgetir" onclick="getlessonrecord(\''.$lrgeturl.'\')" value="Getir">';
	$content .= '<div id="lessonrecords_cont"></div>';
	return $content;	
}
add_shortcode('mp-control-everyday', 'control_everydays');


function see_all_timelines(){

	$tlgeturl = site_url().'/wp-content/plugins/meeting-parents/timelines/';
	$content = '';
	$content .= '<h4>Merhaba Dünya<h4/>';
	$content .= '<input type="text" name="stuid" id="stuid" placeholder="Öğrenci ID">';
	$content .= '<input type="submit" name="cgetir" id="cgetir" onclick="gettimeline(\''.$tlgeturl.'\')" value="Getir">';
	$content .= '<div id="timeline_cont"></div>';
	return $content;	
}
add_shortcode('mp-see-alltimelines', 'see_all_timelines');

class iz_panel_Activate
{

	public function iz_activate(){
		flush_rewrite_rules();
	}

}



require_once  plugin_dir_path( __FILE__ )."izinc/Izinit.php";
//include_once plugin_dir_path( __FILE__ )."izinc/Base/Activate.php";
require_once  plugin_dir_path( __FILE__ )."izinc/Base/Deactivate.php";

//if(class_exists('iz_panel_Activate')){
$semih = new iz_panel_Activate();
//}

register_activation_hook( __FILE__ , array( $semih, 'iz_activate' ) );
register_deactivation_hook( __FILE__ , array( 'Deactivate', 'deactivate' ) );

//if ( class_exists('\inc\Init')){
Izinit::register_services();
//}
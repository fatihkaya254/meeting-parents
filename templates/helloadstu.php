<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);

require_once($path."wp-load.php");

if(isset($_POST["limit"], $_POST["start"])){
	global $wpdb;
	$query = "SELECT * FROM wp_mp_student ORDER BY student_id DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
	$resultset = $wpdb->get_results($query, ARRAY_A);
	foreach ($resultset as $row){
		echo '
		<h3>'.$row["name"].'</h3>
		<p>'.$row["surname"].'</p>
		<p class="text-muted" align="right">By - '.$row["number"].'</p>
		<hr />
		';
	}
}
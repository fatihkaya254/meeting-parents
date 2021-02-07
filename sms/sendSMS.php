<?php 

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['send']) && $_POST['send'] == '1') {

    $recordID = $_POST['recordID'];
    


	$returning = [];
	$returning['success'] = 1;
	$returning['who'] = $recordID;
	echo json_encode($returning);

}
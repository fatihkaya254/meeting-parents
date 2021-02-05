<?php

class timeTime
{ 
    //kullancı adı
    function getUserlogin($username){
	    global $current_user;
        wp_get_current_user();
        $username = $current_user->user_login;
        return $username;
    }
    //Kullanıcının gerçek adı
    function getUsername($username){
	    global $current_user;
        wp_get_current_user();
        $username = $current_user->display_name;
        return $username;
    }
    // Kullanıcı bir öğretmen mi
    function isThisTeacher($userlogin){
        $dizi = explode ("_",$userlogin);
    	if ($dizi[0] == "T") {
            return true;
        }else{
            return false;
        }
    }
    function getIDByUsername($username, $id){
        $dizi = explode ("_",$username);
        $id = $dizi[1];
        return $id;
    }
    // şuanki saat
    function getCurrentTime($time){
	    date_default_timezone_set('Europe/Istanbul');
	    $time=date('H:i:s');
        return $time;
    }
    //bugünün tarihi
    function getCurrentDate($date){
	    date_default_timezone_set('Europe/Istanbul');
        $t=date('d-m-Y');
        $date = date("Y-m-d",strtotime($t));
        return $date;
    }
    //bugün haftanın hangi günü
    function getCurrentDay($bugun){
	    date_default_timezone_set('Europe/Istanbul');
        $t=date('d-m-Y');
        $today = date("D",strtotime($t));

        if ($today == "Mon")    $bugun = "paz";
		
		if ($today == "Tue")	$bugun = "sal";

		if ($today == "Wed")	$bugun = "car";

		if ($today == "Thu") 	$bugun = "per";

		if ($today == "Fri") 	$bugun = "cum";

		if ($today == "Sat") 	$bugun = "cts";

		if ($today == "Sun") 	$bugun = "paz";
        
        return $bugun;
    }
	//günün ders saatlerini getirir
    function getLesssonHours($saatler){
	    date_default_timezone_set('Europe/Istanbul');
        $t=date('d-m-Y');
        $today = date("D",strtotime($t));

        if ($today == "Mon")    $saatler = array('10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00');
		
		if ($today == "Tue")	$saatler = array('10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00');

		if ($today == "Wed")	$saatler = array('10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00');

		if ($today == "Thu") 	$saatler = array('10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00');

		if ($today == "Fri") 	$saatler = array('10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00');

		if ($today == "Sat") 	$saatler = array('8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00');

		if ($today == "Sun")    $saatler = array('8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00');
        
        return $saatler;
    }

}

?>
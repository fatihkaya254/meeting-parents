<?php require_once dirname(__FILE__, 2).'/assets/mystyle.css';

global $wpdb;
date_default_timezone_set('Europe/Istanbul');


$t=date('Y-m-d H:i:s');
echo $t;
$sty = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student WHERE active = 1;", ARRAY_A);
foreach ($sty as $stu) {
	$userlogin = "S_".$stu['student_id']."_".$stu['number'];
	echo "Kullanıcı Adı: ".$userlogin."</br>";
	$userpass = "\$P\$BD3BQqhhHWrDfQyMqAPnwSr1qvH8Ps.";
	echo "Parola: ".$userpass."</br>";
	$usernicename = "S_".$stu['student_id']."_".$stu['number'];
	echo "nicename: ".$usernicename."</br>";
	$useremail = $stu['number']."@isleyenzihin.com";
	echo "e posta: ".$useremail."</br>";
	$userregistered = $t;
	echo "registered: ".$userregistered."</br>";
	$userstatus = "0";
	echo "user_status: ".$userstatus."</br>";
	$displayname = $stu['name']." ".$stu['surname'];
	echo "displayname: ".$displayname."</br></br>";

	$user = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users WHERE user_login = '$userlogin';", ARRAY_A);
	if ($user == null) {
		echo "böye bir Kullanıcı yok </br></br> ";
		$wpdb -> query("INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES (NULL, '$userlogin', '$userpass', '$usernicename', '$useremail', '', '$userregistered', '', '0', '$displayname')");
	}else{
		foreach ($user as $userrow) {
				$userid = $userrow['ID'];
			
			$usermeta = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}usermeta WHERE user_id = '$userid';", ARRAY_A);
			if ($usermeta == null) {
				$nickname = $userrow['user_login'];
				echo "ID: ".$userid."</br>";
				$firsname = $stu['name'];
				$secondname = $stu['surname'];

				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'nickname', '$nickname')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'first_name', '$firsname')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'last_name', '$secondname')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'description', '')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'rich_editing', 'true')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'syntax_highlighting', 'true')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'comment_shortcuts', 'false')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'admin_color', 'fresh')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'use_ssl', '0')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'show_admin_bar_front', 'true')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'locale', '')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'wp_capabilities', 'a:1:{s:10:\"subscriber\";b:1;}')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'wp_user_level', '0')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'um_member_directory_data', 'a:5:{s:14:\"account_status\";s:8:\"approved\";s:15:\"hide_in_members\";b:0;s:13:\"profile_photo\";b:0;s:11:\"cover_photo\";b:0;s:8:\"verified\";b:0;}')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'um_user_profile_url_slug_user_login', '$nickname')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'full_name', '$firsname $secondname')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'account_status', 'approved')");
				$wpdb -> query ("INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '$userid', 'dismissed_wp_pointers', '')");
			}else{
				echo "already set";
			}




		}
	}
}

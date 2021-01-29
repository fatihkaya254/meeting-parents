<?php 

global $wpdb;
global $current_user;
wp_get_current_user();
date_default_timezone_set('Europe/Istanbul');
$saaat=date('H:i:s');
$t=date('d-m-Y');
$today = date("D",strtotime($t));
$bugun = "<br>bugun<br>";
$tarih = date("Y-m-d",strtotime($t));
$username = $current_user->user_login;
$dizi = explode ("_",$username);
$yol = dirname(__FILE__, 1) . "/helloadstu.php";
$helloadstuURL = site_url().'/wp-content/plugins/meeting-parents/templates/helloadstu.php';
// -Öğretmenler giremez- Giriş yapmış kullanıcı bir öğretmen ise bu konu çalıştırmayan kontrolcü
if ($dizi[0] == "T") {
	die();	
}
// -Öğretmenler giremez-.
$gfway = site_url().'/wp-content/plugins/meeting-parents/templates/loader.gif';


// -Öğrenci kabul- Giriş yapan öğrenciyse içeriye al
if ($dizi[0] == "S") {

	?>

	<div class="container">
		<h2 align="center">Auto Load More Data on Page Scroll with Jquery & PHP</a></h2>
		<br />
		<div id="load_data"></div>
		<div id="load_data_message"></div>
	</div>	
	<?php

}
// -Öğrenci kabul-.
?>


<script>

	jQuery(document).ready(function(){

		var limit = 7;
		var start = 0;
		var action = 'inactive';
		function load_country_data(limit, start)
		{
			jQuery.ajax({
				url:"<?php echo $helloadstuURL ?>",
				method:"POST",
				data:{limit:limit, start:start},
				cache:false,
				success:function(data)
				{
					jQuery('#load_data').append(data);
					if(data == '')
					{
						jQuery('#load_data_message').html("<button type='button' class='btn btn-info'>No Data Found</button>");
						action = 'active';
					}
					else
					{
						jQuery('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
						action = "inactive";
					}
				}
			});
		}

		if(action == 'inactive')
		{
			action = 'active';
			load_country_data(limit, start);
		}
		jQuery(window).scroll(function(){
			if(jQuery(window).scrollTop() + jQuery(window).height() > jQuery("#load_data").height() && action == 'inactive')
			{
				action = 'active';
				start = start + limit;
				setTimeout(function(){
					load_country_data(limit, start);
				}, 1000);
			}
		});

	});
</script>

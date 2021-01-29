<?php require_once dirname(__FILE__, 2).'/teacherspage/tpstyle.css'; 

$getLessonsURL = site_url().'/wp-content/plugins/meeting-parents/teacherspage/getLessons.php/';

?>

<div id="process-content">
	<ul id="progressbar" class="progressbar">
       
      </ul>
</div>

<div id="main-content">
	
</div>



<script>
	jQuery(document).ready(function(){

		getLessons('<?php echo $getLessonsURL; ?>', 1);
	
	});

</script>
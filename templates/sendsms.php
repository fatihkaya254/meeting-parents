
<style type="text/css">             
    .collapsible {
        background-color: #FA675F;
        color: white;
        cursor: pointer;
        padding: 10px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        margin-top: 15px;
    }
    .collapsibleStart {
        background-color: #F4CB89;
        color: white;
        cursor: pointer;
        padding: 10px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        margin-top: 15px;
        color: black;
    }
    .collapsibleFinish {
        background-color: #509400;
        color: white;
        cursor: pointer;
        padding: 10px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        margin-top: 15px;
    }
    .startButton {
        border: 0px;
        margin: 10px;
        background-color: #F4CB89;
        min-height: 30px;
        min-width: 200px;
        color: black;
    }
    .finishbutton {
        border: 0px;
        margin: 10px;
        background-color: #509400;
        min-height: 30px;
        color: white;
        min-width: 200px;
    }
    .content {
        padding: 0 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;
    }
</style>


<?php 
$smstuURL = site_url().'/wp-content/plugins/meeting-parents/smsprocess/';
$generatesmsmURL = site_url().'/wp-content/plugins/meeting-parents/getsms/generatesms.php/';

global $wpdb;
date_default_timezone_set('Europe/Istanbul');


$saaat=date('H:i:s');
$t=date('d-m-Y');
$today = date("D",strtotime($t));
$bugun = "<br>bugun<br>";
$tarih = date("Y-m-d",strtotime($t));
$saatler = array('11','12','13','14','15','16','17','18','19');
$smstuURL = site_url().'/wp-content/plugins/meeting-parents/smsprocess/';
$smsgetURL = site_url().'/wp-content/plugins/meeting-parents/getsms/';

?> <div> <h4><?php echo $tarih." ".date('H:i:s'); ?></h4></div> 
<div id="wholesms"></div>


<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
</script>
<script>
    var colls = document.getElementsByClassName("collapsibleStart");
    var j;

    for (j = 0; j < colls.length; j++) {
        colls[j].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
</script>
<script>
    var collf = document.getElementsByClassName("collapsibleFinish");
    var k;

    for (k = 0; k < collf.length; k++) {
        collf[k].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
</script>
<script>
    function send_a_sms(stuid)
    {
        console.log('sms gonder');
        var fd = new FormData();
        fd.append('smsgonder','1');
        fd.append('stuid', stuid);
        fd.append('smsid',jQuery("#"+ stuid +"smsid").val());
        console.log('sms gonder');

        fd.append('numara',jQuery("#"+ stuid +"numara").val());
        console.log('sms gonder');
        
        fd.append('mesaj',jQuery("#"+ stuid +"mesaj").val());
        console.log('sms gonder');
        
        var url = "<?php echo $smstuURL; ?>";
        console.log('sms gonder');

        posttophp(fd, url, submid_send_sms_callback);
        console.log('sms gonder');

    }
</script>

<script>
    function generatesms()
    {

        var generateUrl = '<?php echo $generatesmsmURL; ?>';


        var generetafd = new FormData();
        generetafd.append('generate','1'); 
        posttophp(generetafd, generateUrl, no_callback);
    }
</script>

<script>
    
 jQuery(document).ready(function(){

    generatesms();
    var getUrl = "<?php echo $smsgetURL;?>";         
    getsmsdata(getUrl);

});
</script>
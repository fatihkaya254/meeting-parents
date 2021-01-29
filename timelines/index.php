<?php 
$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path."wp-load.php");

if (isset($_POST['gettl']) && $_POST['gettl'] == '1' ) {
	$content = '';
	$content .= '';
	$content .= '<style type="text/css">
	:root {
		--base-grid: 8px;
		--colour-body-background: #d84c6e;
		--colour-body-backgroundeksik: #D9D162;
		--colour-body-backgroundtam: #95C9DB;
		--colour-background: #fff;
		--colour-background-folded: #f5f5f5;
		--colour-background-stripes: rgba(255,255,255,.5);
		--colour-text: #1a1a1a;
	}

  *, :after, :before {
	box-sizing: border-box;
	margin: 0;
}

body {
	background: var(--colour-body-background);
	font-family: Bitter;
	padding: calc(var(--base-grid)*10);
}

.articles {
	margin: calc(var(--base-grid)*2) auto calc(var(--base-grid)*5);
	display: grid;
	grid-row-gap: calc(var(--base-grid)*8);
	grid-column-gap: calc(var(--base-grid)*6);
	grid-template-columns: repeat(auto-fit,minmax(calc(var(--base-grid)*35),1fr));
	justify-items: center;
}

.articles__article {
	cursor: pointer;
	display: block;
	position: relative;
	perspective: 1000px;
	animation-name: animateIn;
	animation-duration: .35s;
	animation-delay: calc(var(--animation-order)*100ms);
	animation-fill-mode: both;
	animation-timing-function: ease-in-out;
}

.articles__article:before {
	content: "";
	position: absolute;
	top: calc(var(--base-grid)*-2);
	left: calc(var(--base-grid)*-2);
	border: 2px dashed var(--colour-background);
	background-image: repeating-linear-gradient(-24deg,transparent,transparent 4px,var(--colour-background-stripes) 0, var(--colour-background-stripes) 5px);
	z-index: -1;
}


/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
	.articles__article,
	.articles__article:before {
		width: calc(var(--base-grid)*35);
		height: calc(var(--base-grid)*50);
	}

}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
	.articles__article,
	.articles__article:before {
		width: calc(var(--base-grid)*90);
		height: calc(var(--base-grid)*35);
	}

}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
	.articles__article,
	.articles__article:before {
		width: calc(var(--base-grid)*90);
		height: calc(var(--base-grid)*35);
	}

}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
	.articles__article,
	.articles__article:before {
		width: calc(var(--base-grid)*90);
		height: calc(var(--base-grid)*35);
	}

}

.articles__linktam {
	background-color:var(--colour-body-backgroundtam);
	border: 2px solid var(--colour-background);
	display: block;
	width: 100%;
	height: 100%;
}
.articles__linkeksik {
	background-color: var(--colour-body-backgroundeksik);
	border: 2px solid var(--colour-background);
	display: block;
	width: 100%;
	height: 100%;
}
.articles__linkyok {
	background-color: var(--colour-body-background);
	border: 2px solid var(--colour-background);
	display: block;
	width: 100%;
	height: 100%;
}

.articles__linktam:after {
	content: "";
	position: absolute;
	top: 50%;
	right: calc(var(--base-grid)*3);
	width: calc(var(--base-grid)*2);
	height: calc(var(--base-grid)*2);
	margin-top: calc(var(--base-grid)*-1);
	clip-path: polygon(75% 0,100% 50%,75% 100%,0 100%,25% 50%,0 0);
	-webkit-clip-path: polygon(75% 0,100% 50%,75% 100%,0 100%,25% 50%,0 0);
	background-color: var(--colour-background);
	opacity: 0;
	transition: opacity .5s ease-in,transform .3s ease-in-out 0ms;
}
.articles__linkeksik:after {
	content: "";
	position: absolute;
	top: 50%;
	right: calc(var(--base-grid)*3);
	width: calc(var(--base-grid)*2);
	height: calc(var(--base-grid)*2);
	margin-top: calc(var(--base-grid)*-1);
	clip-path: polygon(75% 0,100% 50%,75% 100%,0 100%,25% 50%,0 0);
	-webkit-clip-path: polygon(75% 0,100% 50%,75% 100%,0 100%,25% 50%,0 0);
	background-color: var(--colour-background);
	opacity: 0;
	transition: opacity .5s ease-in,transform .3s ease-in-out 0ms;
}
.articles__linkyok:after {
	content: "";
	position: absolute;
	top: 50%;
	right: calc(var(--base-grid)*3);
	width: calc(var(--base-grid)*2);
	height: calc(var(--base-grid)*2);
	margin-top: calc(var(--base-grid)*-1);
	clip-path: polygon(75% 0,100% 50%,75% 100%,0 100%,25% 50%,0 0);
	-webkit-clip-path: polygon(75% 0,100% 50%,75% 100%,0 100%,25% 50%,0 0);
	background-color: var(--colour-background);
	opacity: 0;
	transition: opacity .5s ease-in,transform .3s ease-in-out 0ms;
}

.articles__content {
	background-color: var(--colour-background);
	color: var(--colour-text);
	position: absolute;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	padding: calc(var(--base-grid)*2);
	display: flex;
	flex-direction: column;
	border: 2px solid var(--colour-background);
}

.articles__content--lhs {
	clip-path: polygon(0 0,51% 0,51% 100%,0 100%);
	-webkit-clip-path: polygon(0 0,51% 0,51% 100%,0 100%);
}

.articles__content--rhs {
	clip-path: polygon(50% 0,100% 0,100% 100%,50% 100%);
	-webkit-clip-path: polygon(50% 0,100% 0,100% 100%,50% 100%);
	transition: transform .5s ease-in-out,background-color .4s ease-in-out;
}

.articles__title {
	font-size: calc(var(--base-grid)*4);
	line-height: 1.125;
	font-weight: 700;
	letter-spacing: -.02em;
}

.articles__footer {
	margin-top: auto;
	font-size: calc(var(--base-grid)*2);
	line-height: calc(var(--base-grid)*2);
	display: flex;
	justify-content: space-between;
}

.articles__linktam:hover .articles__content--rhs {
	background-color: var(--colour-background-folded);
	transform: rotateY(-50deg);
}

.articles__linktam:hover:after {
	opacity: 1;
	transform: translateX(calc(var(--base-grid)*1.5));
	transition: opacity .5s ease-in,transform .3s ease-in-out .25s;
}

.articles__linkeksik:hover .articles__content--rhs {
	background-color: var(--colour-background-folded);
	transform: rotateY(-50deg);
}

.articles__linkeksik:hover:after {
	opacity: 1;
	transform: translateX(calc(var(--base-grid)*1.5));
	transition: opacity .5s ease-in,transform .3s ease-in-out .25s;
}

.articles__linkyok:hover .articles__content--rhs {
	background-color: var(--colour-background-folded);
	transform: rotateY(-50deg);
}

.articles__linkyok:hover:after {
	opacity: 1;
	transform: translateX(calc(var(--base-grid)*1.5));
	transition: opacity .5s ease-in,transform .3s ease-in-out .25s;
}
</style>';
$linkclass = 'articles__link';
$odev = '';
$ayadi ='';
$tarih = '';
$retarih = '';
$pazartesiBirTarih = new DateTime('2019-4-1');	
$saatler = [];
$daysofweek = array('Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi','Pazar');

$saat = '';
$link = '';
$haftasonu = array('9','10','11','12','13','14','15','16','17');
$haftaici = array('11','12','13','14','15','16','17','18','19');
$aylar = array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');

$stuid = $_POST['stuid'];

$content .= '<p>'.$stuid.'</p>';
$content .= '<div style="margin-bottom: 150px;">';

$sty = $wpdb->get_results("SELECT {$wpdb->prefix}mp_lesson_records.hangiders, {$wpdb->prefix}mp_lesson_records.lesson_status, {$wpdb->prefix}mp_lesson_records.homework_status, {$wpdb->prefix}mp_lesson_records.next_homework, {$wpdb->prefix}mp_lesson_records.date_info, {$wpdb->prefix}mp_lesson_records.lesson_url, {$wpdb->prefix}mp_teacher.name, {$wpdb->prefix}mp_teacher.surname, {$wpdb->prefix}mp_branch.realname  FROM {$wpdb->prefix}mp_lesson_records, {$wpdb->prefix}mp_teacher, {$wpdb->prefix}mp_branch WHERE {$wpdb->prefix}mp_lesson_records.student_id = '$stuid'  AND {$wpdb->prefix}mp_lesson_records.teacher_id = {$wpdb->prefix}mp_teacher.teacher_id AND {$wpdb->prefix}mp_lesson_records.branch_id = {$wpdb->prefix}mp_branch.branch_id;", ARRAY_A);
foreach ($sty as $stu){
	$link = $stu['lesson_url'];
	$tarih = $stu['date_info'];	
	$girilentarih= new DateTime($tarih);
	$interval= $pazartesiBirTarih->diff($girilentarih);
	$gunfarkı = (int)$interval->format('%a');
	$today = $daysofweek[$gunfarkı % 7];
	$newdate = explode('-', $tarih);
	$ayadi = $aylar[$newdate[1]-1];
	$retarih = $newdate[2].' '.$ayadi.' '.$newdate[0];
	$odev = $stu['homework_status'];

	if ($today == 'Pazar' || $today == 'Cumartesi')
		$saat = $haftasonu;
	else
		$saat = $haftaici;

	if ($odev == 'tam') {
		$content .= '<div style="background-color: #95C9DB; ">';		
		$linkclass = 'articles__linktam';
	}

	else if ($odev == 'eksik') {
		$linkclass = 'articles__linkeksik';
		$content .= '<div style="background-color: #D9D162; ">';
	}

	else if ($odev == 'yok') {
		$content .= '<div style="background-color: #D84C6E; ">';
		$linkclass = 'articles__linkyok';
	}

	$content .= '<br/>';
	$content .= '<br/>';
	$content .= '<ol class="articles">';
	$content .= '<li class="articles__article" style="--animation-order:1">';
	if ($link == '')
	$content .= '<a class="'.$linkclass.'" onclick="myFunction()">';
	else
	$content .= '<a class="'.$linkclass.'" href="'.$link.'">';
	
	$content .= '<div class="articles__content articles__content--lhs">';
	$content .= '<h4 class="articles__title">'.$stu['lesson_status'].'</h4>';
	$content .= '<br/>';
	$content .= '<p>Ödev:</p>';
	$content .= '<p>'.$stu['next_homework'].'</p>';
	$content .= '<br/>';
	$content .= '<br/>';
	$content .= '<p>-'.$stu['name'].' '.$stu['surname'].'</p>';
	$content .= '<div class="articles__footer">';
	$content .= '<p>'.$stu['realname'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><time>'.$retarih.' '.$today.'</time></div>';
	$content .= '</div>';
	$content .= '<div class="articles__content articles__content--rhs" aria-hidden="true">';
	$content .= ' <h4 class="articles__title">'.$stu['lesson_status'].'</h4>';
	$content .= '<br/>';
	$content .= '<p>Ödev:</p>';
	$content .= '<p>'.$stu['next_homework'].'</p>';
	$content .= '<br/>';
	$content .= '<br/>';
	$content .= '<p>-'.$stu['name'].' '.$stu['surname'].'</p>';
	$content .= '<div class="articles__footer">';
	$content .= '<p>'.$stu['realname'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><time>'.$retarih.' '.$today.'</time></div>';
	$content .= '</div>';
	$content .= '</a>';
	$content .= '</li>';
	$content .= '</ol>';
	$content .= '<br/>';
	$content .= '<br/>';
	$content .= '</div>';

}

$content .= '</div>';
$content .= '<script>';
$content .= 'function myFunction() {';
$content .= '  alert("Bu dersin video kaydı bulunmuyor.");';
$content .= '}';
$content .= '</script>';

$returning = [];
$returning['success'] = 1;
$returning['content'] = $content;
echo json_encode($returning);

}
?>







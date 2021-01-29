<?php require_once dirname(__FILE__, 2).'/assets/mystyle.css'; ?>


<style type="text/css">
	div.kutu{
		position: relative;
		width: 200px;
		height: 300px;
		overflow: scroll;
		border-style: line;
		margin-top: 20px;
	}	
</style>

<?php global $wpdb;
$servername = "94.73.148.32:3306";
$username = "u9091004_larvac";
$password = "ZLeen-hNN4-01";
$dbname = "u9091004_wp3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$lastid=0;
$randevular = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student ORDER BY student_id DESC LIMIT 0,1; " , ARRAY_A);
foreach($randevular as $row){
	$lastid = $row['student_id'];
}


?>
<div class="kutu">
	<?php 
	$randevular = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student ORDER BY student_id DESC; " , ARRAY_A);
	foreach($randevular as $row){
		?>
		<ul>
			<li><?php 	echo $row['name']." ".$row['surname']; ?></li>
		</ul>

		<?php 
	}
	?>
</div>
<form method="POST">
	<input type="submit" name="Yenile" value="Öğrenci Listesini Yenile">
</form>

<?php 

if (isset($_POST['Yenile'])) {
	# code...


	$conn->Set_charset("utf8");

	$sql = "SELECT * FROM wp_student WHERE active = 1 AND student_id > $lastid";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
  // output data of each row
		while($row = $result->fetch_assoc()) {
			echo $row['name'];
			$student_id = $row['student_id'];
			$name = $row['name'];
			$surname = $row['surname'];
			$number = $row['number'];
			$phone_number = $row['phone_number'];
			$e_mail = $row['e_mail'];
			$adress = $row['adress'];
			$grade_id = $row['grade_id'];
			$program_id = $row['program_id'];
			$active = $row['active'];
			$scholarship = $row['scholarship'];
			$wpdb->query
			("
				INSERT INTO `{$wpdb->prefix}mp_student` (`student_id`, `name`, `surname`, `number`, `phone_number`, `e_mail`, `adress`, `grade_id`, `program_id`, `active`, `scholarship`) VALUES ('$student_id', '$name', '$surname', '$number', '$phone_number', '$e_mail', '$adress', '$grade_id', '$program_id', '$active', '$scholarship')
				"
			);
		}
	} 

	$sql = "SELECT * FROM wp_student WHERE active = 0";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
  // output data of each row
		while($row = $result->fetch_assoc()) {
			echo $row['name'];
			$student_id = $row['student_id'];
			$wpdb->query
			("
				UPDATE `{$wpdb->prefix}mp_student` SET `active`=0 WHERE `student_id` = '$student_id'
				"
			);
		}
	}
}

// BURADAN SONRA ÜYELER 


$lastid=0;
$randevular = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student ORDER BY student_id DESC LIMIT 0,1; " , ARRAY_A);
foreach($randevular as $row){
	$lastid = $row['student_id'];
}


?>
<div class="kutu">
	<?php 
	$randevular = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_student ORDER BY student_id DESC; " , ARRAY_A);
	foreach($randevular as $row){
		?>
		<ul>
			<li><?php 	echo $row['name']." ".$row['surname']; ?></li>
		</ul>

		<?php 
	}
	?>
</div>
<form method="POST">
	<input type="submit" name="Yenile" value="Öğrenci Listesini Yenile">
</form>

<?php 

if (isset($_POST['Yenile'])) {
	# code...


	$conn->Set_charset("utf8");

	$sql = "SELECT * FROM wp_student WHERE active = 1 AND student_id > $lastid";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
  // output data of each row
		while($row = $result->fetch_assoc()) {
			echo $row['name'];
			$student_id = $row['student_id'];
			$name = $row['name'];
			$surname = $row['surname'];
			$number = $row['number'];
			$phone_number = $row['phone_number'];
			$e_mail = $row['e_mail'];
			$adress = $row['adress'];
			$grade_id = $row['grade_id'];
			$program_id = $row['program_id'];
			$active = $row['active'];
			$scholarship = $row['scholarship'];
			$wpdb->query
			("
				INSERT INTO `{$wpdb->prefix}mp_student` (`student_id`, `name`, `surname`, `number`, `phone_number`, `e_mail`, `adress`, `grade_id`, `program_id`, `active`, `scholarship`) VALUES ('$student_id', '$name', '$surname', '$number', '$phone_number', '$e_mail', '$adress', '$grade_id', '$program_id', '$active', '$scholarship')
				"
			);
		}
	} 

	$sql = "SELECT * FROM wp_student WHERE active = 0";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
  // output data of each row
		while($row = $result->fetch_assoc()) {
			echo $row['name'];
			$student_id = $row['student_id'];
			$wpdb->query
			("
				UPDATE `{$wpdb->prefix}mp_student` SET `active`=0 WHERE `student_id` = '$student_id'
				"
			);
		}
	}
}
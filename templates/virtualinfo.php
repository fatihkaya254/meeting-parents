<?php global $wpdb;
$a = 0;
$virwe = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualstudent, {$wpdb->prefix}mp_grade, {$wpdb->prefix}mp_student WHERE {$wpdb->prefix}mp_virtualstudent.student_id = {$wpdb->prefix}mp_student.student_id AND {$wpdb->prefix}mp_grade.grade_id = {$wpdb->prefix}mp_student.grade_id AND {$wpdb->prefix}mp_student.active = 1 ORDER BY {$wpdb->prefix}mp_grade.grade_name, {$wpdb->prefix}mp_student.name ASC;" , ARRAY_A);
foreach($virwe as $row){
  $a += 1;
  ?>
  <ul>
    <li><?php  echo  $a." ".
    $row['grade_name']." ".
    $row['name']." ".
    $row['surname']." ".
    $row['sal1']." ".
    $row['sal2']." ".
    $row['sal3']." ".
    $row['sal4']." ".
    $row['sal5']." ".
    $row['sal6']." ".
    $row['sal7']." ".
    $row['sal8']." ".
    $row['sal9']." ".
    $row['car1']." ".
    $row['car2']." ".
    $row['car3']." ".
    $row['car4']." ".
    $row['car5']." ".
    $row['car6']." ".
    $row['car7']." ".
    $row['car8']." ".
    $row['car9']." ".
    $row['per1']." ".
    $row['per2']." ".
    $row['per3']." ".
    $row['per4']." ".
    $row['per5']." ".
    $row['per6']." ".
    $row['per7']." ".
    $row['per8']." ".
    $row['per9']." ".
    $row['cum1']." ".
    $row['cum2']." ".
    $row['cum3']." ".
    $row['cum4']." ".
    $row['cum5']." ".
    $row['cum6']." ".
    $row['cum7']." ".
    $row['cum8']." ".
    $row['cum9']." ".
    $row['cts1']." ".
    $row['cts2']." ".
    $row['cts3']." ".
    $row['cts4']." ".
    $row['cts5']." ".
    $row['cts6']." ".
    $row['cts7']." ".
    $row['cts8']." ".
    $row['cts9']." ".
    $row['paz1']." ".
    $row['paz2']." ".
    $row['paz3']." ".
    $row['paz4']." ".
    $row['paz5']." ".
    $row['paz6']." ".
    $row['paz7']." ".
    $row['paz8']." ".
    $row['paz9']." ".
  $row['grade_name']." </br>";  ?></li>
</ul>

<?php 
}

?>

<form method="POST">
  <input type="submit" name="Yenile" value="Yenile">
</form>

<?php 
$servername = "94.73.148.32:3306";
$username = "u9091004_larva";
$password = "ZLeen-hNN4-01";
$dbname = "u9091004_wp3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$lastid=0;
$holasw = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_virtualstudent ORDER BY student_id DESC LIMIT 0,1; " , ARRAY_A);
foreach($holasw as $row){
  $lastid = $row['student_id'];
}

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
      $wpdb->query
      ("
        INSERT INTO `{$wpdb->prefix}mp_virtualstudent` (`student_id`) VALUES ('$student_id')
        "
      );
    }
  }

 
}
<title>Posta Gönderme Sonuç Raporu</title>  
<meta http-equiv="Content-Type" content="text/html;">
<h1>merhaba</h1>
<meta charset="UTF-8">
<?php
$servername = "localhost";
$username = "u9091004_fatih";
$password = "Fk.251120336.Fk";
$dbname = "u9091004_wp3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$conn->Set_charset("utf8");
require_once dirname(__FILE__, 2).'/notifications/mailphp/class.phpmailer.php';// PHPMailer dosyamizi çagiriyoruz

$mail = new PHPMailer(); // Sinifimizi $mail degiskenine atadik
$mail->IsSMTP(true);  // Mailimizin SMTP ile gönderilecegini belirtiyoruz
$mail->From     = "bilgi@liseyegecissinavi.site";//"admin@localhost"; //Gönderen kisminda yer alacak e-mail adresi
$mail->Sender   = "bilgi@liseyegecissinavi.site";//"admin@localhost";//Gönderen Mail adresi
//$mail->ReplyTo  = ($_POST["mailiniz"]);//"admin@localhost";//Tekrar gönderimdeki mail adersi
$mail->AddReplyTo=("bilgi@liseyegecissinavi.site");//"admin@localhost";//Tekrar gönderimdeki mail adersi
$mail->FromName = "İZ Bilgilendirme";//"PHP Mailer";//gönderenin ismi
$mail->Host     = "mail.liseyegecissinavi.site";//"localhost"; //SMTP server adresi
$mail->SMTPAuth = true; //SMTP server'a kullanici adi ile baglanilcagini belirtiyoruz
$mail->SMTPSecure = false;
$mail->SMTPAutoTLS = false;
$mail->Port     = 587; //Natro SMPT Mail Portu
$mail->CharSet = 'uft-8'; //Türkçe yazı karakterleri için CharSet  ayarını bu şekilde yapıyoruz.
$mail->Username = "bilgi@liseyegecissinavi.site";//"admin@localhost"; //SMTP kullanici adi
$mail->Password = "ZLen-hN4-01";//""; //SMTP mailinizin sifresi
$mail->WordWrap = 50;
$mail->IsHTML(true); //Mailimizin HTML formatinda hazirlanacagini bildiriyoruz.
$mail->Subject  = "konumuz neydi bizim"." /PHP SMTP Ayarları/Mail Konusu";//"Deneme Maili"; // Mailin Konusu Konu
//Mailimizin gövdesi: (HTML ile)
$body  = "<div style='width:920px;  margin:0 auto;'>";
$body .=
"<div style=' padding:20px;  width:880px; background:#5F9595; height: 60px;  position:relative;'>
<img src='https://isleyenzihinler.com.tr/wp-content/uploads/2020/07/mailLogow.png' alt='İşleyen Zihinler' margin-right:50px; style='float:left; width: 70px; height: 60px'><h1 style='color:#F7F3F0; margin-right:200px; text-aling:center;float:left'>İşleyen Zihinler Günlük Rapor</h1>
</div>" .

" <div style='background:#5F9595; margin:20px; padding:20px; float:left; max-width:880px; position:relative;'>
<h2 style='color:#F7F3F0;'>Randevular</h2>

<table>
<thead>
<tr>

<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Sıra</td>
<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Tarih ve Saat</td>
<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Notlar</td>
<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Veli</td>
<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Telefon</td>
<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrenci</td>
<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrencinin Okulu/Sınıfı</td>

</tr>";
$sql = "SELECT * FROM wp_appointment WHERE a_takestat != '1'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
	while($row = $result->fetch_assoc()) {
		$sırao=0;
		$isnpid = $row["isnp_id"];
		$sqlb = "SELECT * FROM wp_isnp WHERE isnp_id = $isnpid;";
		$bilgiler = $conn->query($sqlb);
		if ($bilgiler->num_rows > 0) {
			while($key = $bilgiler->fetch_assoc()) {
				$sirao = $sirao+1;
				$body .= "<tr>
				<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$sirao."</td>
				<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".date_format(new DateTime($row['a_date']),'d.m.Y H:i:s')."</td>
				<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["a_statements"]."</td>

				<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$key["i_parent_name"] . "&nbsp;" .   $key["i_parent_surname"]."</td>
				<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$key["i_parent_phone"]."</td>
				<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$key["i_student_name"] . "\n" .   $key["i_student_surname"]."</td>
				<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$key["i_student_school"]   . "\n" .   $key["i_student_grade"]."</td>


				</tr>";
			}
		}}
	} 



	$body .= "</table></div>";
	$body .= " <div style='background:#5F9595; margin:20px; padding:20px; float:left; max-width:880px; position:relative;'>
	<h2 style='color:#F7F3F0;'>Öğrenci Listesi</h2>

	<table>
	<thead>
	<tr>

	<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Sıra</td>
	<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Numarası</td>
	<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Adı</td>
	<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Telefon</td>
	<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Sınıf</td>
	<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Program</td>
	<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Kayıt Tarihi</td>

	</tr>";


	$sql = "SELECT * FROM wp_student WHERE active=1 AND scholarship =0;";
	
	$sty = $conn->query($sql);
	$sirao=0;
	
  // output data of each row
	while($mailrow = $sty->fetch_assoc()) {
		$sirao = $sirao+1;
		$grade_id=$mailrow["grade_id"];
		$program_id=$mailrow["program_id"];
		$stu_id=$mailrow["number"];

		$sqla = "SELECT * FROM wp_grade WHERE grade_id = '$grade_id';";
		$sqlb = "SELECT * FROM wp_program WHERE program_id = '$program_id';";
		$sqlc = "SELECT * FROM wp_registration WHERE student_id = '$stu_id';";

		$grade = $conn->query($sqla);
		$program = $conn->query($sqlb);
		$regs = $conn->query($sqlc);


		while($gra = $grade->fetch_assoc()) {			
			while($pro = $program->fetch_assoc()) {							
				while($reg = $regs->fetch_assoc()) {




					$body .= "<tr>
					<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$sirao."</td>
					<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$mailrow['number']."</td>
					<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$mailrow['name']."&nbsp;".$mailrow['surname']."</td>
					<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$mailrow['phone_number']."</td>
					<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$gra['grade_name']."</td>
					<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$pro['program_name']."</td>
					<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".date_format(new DateTime($reg['registration_date']),'d.m.Y')."</td>
					</tr>";
				}}}}

				$body .= "</table></div>";


				
				$body .= " <div style='background:#5F9595; margin:20px; padding:20px; float:left; max-width:880px; position:relative;'>
				<h2 style='color:#F7F3F0;'>Öğrenci Listesi</h2>

				<table>
				<thead>
				<tr>

				<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Sıra</td>
				<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Numarası</td>
				<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Adı</td>
				<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Telefon</td>
				<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Sınıf</td>
				<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Program</td>
				<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Kayıt Tarihi</td>

				</tr>";


				$sql = "SELECT * FROM wp_student WHERE active=1 AND scholarship =1;";

				$sty = $conn->query($sql);
				$sirao=0;

  // output data of each row
				while($mailrow = $sty->fetch_assoc()) {
					$sirao = $sirao+1;
					$grade_id=$mailrow["grade_id"];
					$program_id=$mailrow["program_id"];
					$stu_id=$mailrow["number"];

					$sqla = "SELECT * FROM wp_grade WHERE grade_id = '$grade_id';";
					$sqlb = "SELECT * FROM wp_program WHERE program_id = '$program_id';";
					$sqlc = "SELECT * FROM wp_registration WHERE student_id = '$stu_id';";

					$grade = $conn->query($sqla);
					$program = $conn->query($sqlb);
					$regs = $conn->query($sqlc);


					while($gra = $grade->fetch_assoc()) {			
						while($pro = $program->fetch_assoc()) {							
							while($reg = $regs->fetch_assoc()) {




								$body .= "<tr>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$sirao."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$mailrow['number']."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$mailrow['name']."&nbsp;".$mailrow['surname']."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$mailrow['phone_number']."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$gra['grade_name']."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$pro['program_name']."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".date_format(new DateTime($reg['registration_date']),'d.m.Y')."</td>
								</tr>";
							}}}}

							$body .= "</table></div>";
							$body .= 



							" <div style='background:#5F9595; margin:20px; padding:20px; float:left; max-width:880px; position:relative; '>
							<h2 style='color:#F7F3F0;'>Görüşme Halindeki Veliler</h2>

							<table>
							<thead>
							<tr>

							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Sıra</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Tanışma Zamanı</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >İsim</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrenci Adı</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrencinin Okulu/Sınıf</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Referans Şekli</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Referans Açıklaması</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Durum Açıklaması</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Notlar</td>


							</tr>";
							$sql = "SELECT * FROM wp_isnp WHERE i_status !='active' AND i_status !='left' AND i_status !='negative';";
							$sira=1;
							$veliler = $conn->query($sql);
							while($row = $veliler->fetch_assoc()) {
								$body .= "<tr>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$sira."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".date_format(new DateTime($row["i_contact_date"]),'d.m.Y')."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_parent_name"] . " " . $row["i_parent_surname"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_student_name"] . " " . $row["i_student_surname"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_student_school"] . " / " . $row["i_student_grade"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_preference"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_preference_statement"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_status_statement"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_notes"]."</td>
								</tr>";
								$sira = $sira+1;
							}

							$body .= "</table></div>";


							$body .= 







							" <div style='background:#5F9595; margin:20px; padding:20px; float:left; max-width:880px; position:relative; '>
							<h2 style='color:#F7F3F0;'>Başka Bir Zaman İçin</h2>

							<table>
							<thead>
							<tr>

							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Sıra</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Tanışma Zamanı</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >İsim</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrenci Adı</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrencinin Okulu/Sınıf</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Referans Şekli</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Referans Açıklaması</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Durum Açıklaması</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Notlar</td>


							</tr>";

							$sql = "SELECT * FROM wp_isnp WHERE i_status ='nextime';";
							$sira=1;
							$veliler = $conn->query($sql);
							while($row = $veliler->fetch_assoc()) {
								$body .= "<tr>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$sira."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".date_format(new DateTime($row["i_contact_date"]),'d.m.Y')."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_parent_name"] . " " . $row["i_parent_surname"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_student_name"] . " " . $row["i_student_surname"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_student_school"] . " / " . $row["i_student_grade"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_preference"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_preference_statement"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_status_statement"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_notes"]."</td>
								</tr>";
								$sira = $sira+1;
							}

							$body .= "</table></div>";

							$body .= 



							" <div style='background:#5F9595; margin:20px; padding:20px; float:left; max-width:880px; position:relative; '>
							<h2 style='color:#F7F3F0;'>Telefonla Konuşuldu (Olumsuz)</h2>

							<table>
							<thead>
							<tr>

							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Sıra</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Tanışma Zamanı</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >İsim</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrenci Adı</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrencinin Okulu/Sınıf</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Referans Şekli</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Referans Açıklaması</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Durum Açıklaması</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Notlar</td>


							</tr>";

							$sql = "SELECT * FROM wp_isnp WHERE i_status ='negative';";
							$sira=1;
							$veliler = $conn->query($sql);
							while($row = $veliler->fetch_assoc()) {
								$body .= "<tr>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$sira."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".date_format(new DateTime($row["i_contact_date"]),'d.m.Y')."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_parent_name"] . " " . $row["i_parent_surname"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_student_name"] . " " . $row["i_student_surname"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_student_school"] . " / " . $row["i_student_grade"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_preference"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_preference_statement"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_status_statement"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_notes"]."</td>
								</tr>";
								$sira = $sira+1;
							}

							$body .= "</table></div>";

							$body .= 



							" <div style='background:#5F9595; margin:20px; padding:20px; float:left; max-width:880px; position:relative; '>
							<h2 style='color:#F7F3F0;'>Veli Bilgileri</h2>

							<table>
							<thead>
							<tr>

							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Sıra</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Tanışma Zamanı</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >İsim</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrenci Adı</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Öğrencinin Okulu/Sınıf</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Referans Şekli</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Referans Açıklaması</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Durum Açıklaması</td>
							<td style='background-color:#FEB89F; padding:5px; color:#ffffff; text-align:center; vertical-align:top' >Notlar</td>


							</tr>";

							$sql = "SELECT * FROM wp_isnp WHERE i_status ='active';";
							$sira=1;
							$veliler = $conn->query($sql);
							while($row = $veliler->fetch_assoc()) {
								$body .= "<tr>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$sira."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".date_format(new DateTime($row["i_contact_date"]),'d.m.Y')."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_parent_name"] . " " . $row["i_parent_surname"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_student_name"] . " " . $row["i_student_surname"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_student_school"] . " / " . $row["i_student_grade"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_preference"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_preference_statement"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_status_statement"]."</td>
								<td style='color:#5F9595; padding:5px; border:2px; border-color:black; background-color:#F7F3F0; text-align:left;vertical-align:top'>".$row["i_notes"]."</td>
								</tr>";
								$sira = $sira+1;
							}


							$body .= "</table></div>"."<br></div>";
							echo $body;
							$conn->close();
//  $body = $_POST["mesaj"];//"Bu mail bir deneme mailidir. SMTP server ile gönderilmistir.";
// HTML okuyamayan mail okuyucularda görünecek düz metin:
$textBody = $body;//"Bu mail bir deneme mailidir. SMTP server ile gönderilmistir.";
$mail->Body = $body;
$mail->AltBody = $text_body;
if ($mail->Send()) echo "Sorunuz gönderildimiştir. <br>Natro Sistem Uzmanlarımız müsait olduğunda yanıtlayacaktır.";
else echo "Form göndermede hata oldu! Daha sonra tekrar deneyiniz.";
$mail->ClearAddresses();
$mail->ClearAttachments();
//$mail->AddAttachment('images.png'); //mail içinde resim göndermek için
//$mail->addCC('mailadi@alanadiniz.site');// cc email adresi
//$mail->addBCC('mailadi@alanadiniz.site');// bcc email adresi
$mail->AddAddress("fatihkaya254@gmail.com"); // Mail gönderilecek adresleri ekliyoruz.
$mail->AddAddress("ysfasln.80@gmail.com");
$mail->AddAddress("irfantokcan@gmail.com");
$mail->AddAddress("av.oguzhankocer@gmail.com");
$mail->Send();
$mail->ClearAddresses();
$mail->ClearAttachments(); 
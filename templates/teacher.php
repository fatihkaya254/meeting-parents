

<style type="text/css">
	
	.zf-backgroundBg{
		background-color: red;
	}
	.zf-templateWidth{
		background-color: #ffffff;
		margin: auto;
		max-width: 40%;
		float: left;
	}
	.zf-templateWrapper{
		padding-bottom: 0px;
	}
	.zf-tempHeadBdr{
		background-color: green;
		height: 50px;
		vertical-align: middle;
	}
	.zf-tempHeadContBdr{
		background-color: #000000;

	}
	.zf-frmTitle{
		vertical-align: middle;
		color: white;
		padding: 20px;
	}
	.zf-frmDesc{
	}
	.zf-clearBoth{
	}
	.zf-subContWrap{
	}
	.zf-tempFrmWrapper{
		padding: 20px;
		padding-right: 50px;
		max-width: 100%;
		float: left;
	}
	.zf-labelName{
		font-size: 14px;
		font-weight: bold;
		color: black;
		opacity: 80%;
	}

	textarea {
		width: 30%;
		height: 40px;
		padding: 12px 20px;
		box-sizing: border-box;
		border: none;
		border-radius: 0;
		border-bottom: 2px solid black;;  
		opacity: 60%;
		resize: none;
		margin: 20px;
		width: 100%;
	}

	input[type=text] {
		border: none;
		border-radius: 0;
		border-bottom: 2px solid black;;
		margin: 20px;
		opacity: 60%;
		height: 40px;
		width: 100%;
	}

	input[type=date] {
		border: none;
		height: 40px;
		border-radius: 0;
		border-bottom: 2px solid black;;
		opacity: 60%;
		width: 100%;
		margin: 20px;
	}

	.murtaza{
		float: left;
		max-width: 40%;
		background-color: #C4D7D1;
		padding: 10px;
		margin: 20px;
	}

	.zf-tempContDivkayit{
		border: none;
		height: 40px;
		border-radius: 0;
		border-bottom: 2px solid black;;
		opacity: 60%;
		width: 100%;
		margin: 20px;
	}

	.MyButtonkayit {
		background-color: #3d8ca7;
		color: #ffffff;
		cursor: pointer;
		padding: 10px;
		width: 100%;
		border: none;
		text-align: center;
		outline: none;
		font-size: 15px;

	}
	.MyButtonkayit:hover {
		background-color:#000000;
	}
</style>
<div class="zf-templateWidth">

	<div class="zf-templateWrapper">
		<ul class="zf-tempHeadBdr">
			<li class="zf-tempHeadContBdr"><h2 class="zf-frmTitle"><em>Öğretmen Ekle</em></h2>
				<p class="zf-frmDesc"></p>
				<div class="zf-clearBoth"></div></li></ul>
				<div  class="zf-subContWrap"><ul>

					<li class="zf-tempFrmWrapper">
						<form action ="" name="ogr" method="POST">
							<label class="zf-labelName" for="pname">Adı:</label>
							<input  placeholder="Adı" type="text" id="sname" name="sname" maxlength="40"required>
							<label class="zf-labelName" for="pname">Soyadı:</label>
							<input  placeholder="Adı" type="text" id="ssname" name="ssname" maxlength="40"required>
							<label class="zf-labelName" for="pphone">Telefon Numarası:</label>
							<input  type="text" id="dnum" name="dnum" placeholder="05054443322" maxlength="11">
							<label class="zf-labelName" for="school">Adresi:</label>
							<textarea  name="adress" rows="2" cols="30" maxlength="300"></textarea>
							<label class="zf-labelName" for="register_date">Doğum Tarihi:</label>
							<input  type="date" id="registerdate" name="registerdate">						

							<input type="submit" class="MyButtonkayit" name="addteacher" ></input></ul>

						</form>


						<?php 
						global $wpdb;

						if(isset($_POST['addteacher']))
						{

							$name = $_POST['sname'];
							$surname = $_POST['ssname'];
							$number = $_POST['dnum'];
							$registerdate = $_POST['registerdate'];
							$adress = $_POST['adress'];
							$active = 1;


							$wpdb->query
							("
								INSERT INTO `{$wpdb->prefix}mp_teacher` 
								(`name`, `surname`, `phone_number`, `adress`, `birthday`, `active`) 
								VALUES ('$name', '$surname', '$number', '$adress', '$registerdate', '$active');"
							);
							if ($wpdb) {
								?> 

								<script type="text/javascript">window.location.reload()</script>

								<?php

							}

						}


						global $wpdb;

						$students = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_teacher WHERE active = 1 " , ARRAY_A);
						$i=1;
						foreach($students as $row)
						{ 
							?>				
							<li> <?php echo
							$i . "\t ". "|". "\t" .
							$row['name'] . "\t". " \t" .
							$row['surname'] ."\t ". "|". "\t" .
							$row['phone_number'] . "\t" ." |" ." \t" .
							$row['adress'] . "\t ". "|". "\t" .
							$row['birthday'];
							$i++;
							?></li>
							<?php 
						}
						?>

					</li>











				</div>





				<div class="zf-clearBoth"></div></li>
			</ul></div></div>
			<ul><li class="zf-fmFooter">


				<div class="murtaza">
					<h1>Branş ve Yeterlilik </h1>

					<form action='' name="brans" method='POST'>
						<label >Öğretmen</label>
						<select   name="ogretmen" id="ogretmen" >
							<option selected="true" value="" required></option>
							<?php
							global $wpdb;
							$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_teacher", ARRAY_A);
							foreach($ogr as $row)
							{
								?>
								<option value="<?php echo $row["teacher_id"]; ?>"><?php echo $row["name"] . " " . $row["surname"]; ?></option>
							<?php } ?>
						</select>
						<label >Branş</label>
						<select  class="zf-form-sBox" name="brans" checktype="c1">
							<option selected="true" value="" required></option>
							<?php
							global $wpdb;
							$ogr = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_branch ORDER BY name", ARRAY_A);
							foreach($ogr as $row)
							{
								?>
								<option value="<?php echo $row["branch_id"]; ?>"><?php echo $row["name"]; ?></option>
							<?php } ?>
						</select>
						<label for="point">Seviye:</label>

						<select name="point" id="point">
							<option selected="true" value="" required></option>
							<option value="1">Kötü</option>
							<option value="2">Orta</option>
							<option value="3">İyi</option>
						</select>
						<br><br><input class="MyButtonkayit" type="submit" value="gönder" name="teabra">
					</form>
					<?php 

					if(isset($_POST['teabra']))
					{

						$tid = $_POST['ogretmen'];
						$bid = $_POST['brans'];
						$point = $_POST['point'];

						$wpdb->query
						("
							INSERT INTO `{$wpdb->prefix}mp_tea_bra_match` 
							(`branch_id`, `teacher_id`, `match_point`) 
							VALUES ('$bid', '$tid', '$point');"
						);
						if ($wpdb) {

							
						}

					}

					$teaname = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_teacher", ARRAY_A);
					foreach($teaname as $tearow){
						?><br><h2>
						<?php echo $tearow["name"] . " " . $tearow["surname"];?></h2>
						<?php 
						$teaid = $tearow["teacher_id"];
						$teabra = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_tea_bra_match WHERE teacher_id='$teaid' ORDER BY match_point;", ARRAY_A);
						foreach($teabra as $tbmrow){
							$gradeid = $tbmrow["branch_id"];
							$braname = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mp_branch WHERE branch_id='$gradeid';", ARRAY_A);
							foreach($braname as $brarow){
								$tbmpoint = $tbmrow["match_point"];
								$durum = "bilinmiyor";
								if ($tbmpoint == 1) {
									$durum = "Kötü";
								}
								if ($tbmpoint == 2) {
									$durum = "Orta";
								}
								if ($tbmpoint == 3) {
									$durum = "İyi";
								}
								?>
							
									<?php echo $brarow["name"] . " - " . $durum; ?>
								
								<?php 
							}


						}

					}


					?> 
				</div>

				
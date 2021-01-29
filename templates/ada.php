			<div style="width: 250px; border-style: solid; border-color: black;">
				<h3>Salı 1. Ders</h3>



				<?php
				$virtualweek = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virtualweek WHERE `vw_name` = '$teaid - 1. Saat'", ARRAY_A);
				


				$kontrol =0;
				foreach($virtualweek as $vwrow){
					$kontrol++;					
					?>
					<form method="POST">
						<label><?php echo $vwrow['sal']; ?> </label>
						


						<input type="hidden" name="teaid" value="<?php echo $row["teacher_id"]; ?>">
						<input type="hidden" name="kim" value="<?php echo $vwrow['sal']; ?>">
						


						<button class="hellobutton" name="exstu">Boşalt</button>
						<select name="ekelme" checktype="c1"><option selected="true" value="" required></option>
							<?php
							global $wpdb;
							$selectBra = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tea_bra_match WHERE `teacher_id` = '$teaid'", ARRAY_A);
							foreach($selectBra as $brom)
							{
								$braid = $brom['branch_id'];
								echo $braid;
								$getBraName = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}branch WHERE `branch_id` = '$braid'", ARRAY_A);
								foreach($getBraName as $brow){
									$braname = $brow['name'];									
									$getWicgroup = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}teachmeg WHERE `$braname` != '0'", ARRAY_A);
									foreach($getWicgroup as $gwgrow){
										$groupid = $gwgrow['group_id'];
										$indeksgroup = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lesson_group WHERE `group_id` = '$groupid'", ARRAY_A);										
										foreach($indeksgroup as $igrow){
											$std1 = $igrow['1_student_id'];
											$std2 = $igrow['2_student_id'];
											$std3 = $igrow['3_student_id'];
											$std4 = $igrow['4_student_id'];
											$std5 = $igrow['5_student_id'];
											$std6 = $igrow['6_student_id'];

											

											$birinciwanted = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wanted WHERE `student_id` = '$std1' AND `sal1` != '0' ", ARRAY_A);
											foreach($birinciwanted as $bw){
												$birincimus = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virtualstudent WHERE `student_id` = '$std1' AND `sal1` = '0' ", ARRAY_A);
												foreach($birincimus as $bm){
													$ikinciwanted = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wanted   WHERE `student_id` = '$std2' AND `sal1` != '0' ", ARRAY_A);
													foreach($ikinciwanted as $iw){
														$ikincimus = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virtualstudent   WHERE `student_id` = '$std2' AND `sal1` = '0' ", ARRAY_A);
														foreach($ikincimus as $im){
															$birinciwanted = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wanted   WHERE `student_id` = '$std3' AND `sal1` != '0' ", ARRAY_A);
															foreach($birinciwanted as $bw){
																$birincimus = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virtualstudent   WHERE `student_id` = '$std3' AND `sal1` = '0' ", ARRAY_A);
																foreach($birincimus as $bm){
																	$birinciwanted = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wanted   WHERE `student_id` = '$std4' AND `sal1` != '0' ", ARRAY_A);
																	foreach($birinciwanted as $bw){
																		$birincimus = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virtualstudent   WHERE `student_id` = '$std4' AND `sal1` = '0' ", ARRAY_A);
																		foreach($birincimus as $bm){
																			$birinciwanted = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wanted   WHERE `student_id` = '$std5' AND `sal1` != '0' ", ARRAY_A);
																			foreach($birinciwanted as $bw){
																				$birincimus = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virtualstudent   WHERE `student_id` = '$std5' AND `sal1` = '0' ", ARRAY_A);
																				foreach($birincimus as $bm){
																					$birinciwanted = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wanted   WHERE `student_id` = '$std6' AND `sal1` != '0' ", ARRAY_A);
																					foreach($birinciwanted as $bw){
																						$birincimus = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virtualstudent   WHERE `student_id` = '$std6' AND `sal1` = '0' ", ARRAY_A);
																						foreach($birincimus as $bm){
																							$name = $braname . " ". $igrow['group_name'];
																							?>
																							<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
																							<?php 
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}


									
									$getWicstu = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}teachmes WHERE `$braname` != '0'", ARRAY_A);
									foreach($getWicstu as $gwrow){
										$stdntid = $gwrow['student_id'];
										$getStuInf = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student WHERE `student_id` = '$stdntid'", ARRAY_A);
										foreach($getStuInf as $sturow){
											$getClockInf = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wanted WHERE `student_id` = '$stdntid' AND `sal1` != '0' ", ARRAY_A);



											foreach($getClockInf as $clockinf){
												$getClockisInf = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virtualstudent WHERE `student_id` = '$stdntid' AND `sal1` = '0' ", ARRAY_A);


												
												foreach($getClockisInf as $clockisinf){
													$name = $sturow['student_id']." ".$sturow['name']." ".$sturow['surname'];

													?>
													<option value="<?php echo $braname." ".$name; ?>"><?php echo $braname." ".$name; ?></option>
													<?php
												}}
											}
										}
									}
								} ?>
							</select>
							<input type="submit" name="ekle" value="Ekle">

						</form>
						<?php
					}
					?>
				</div>
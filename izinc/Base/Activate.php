<?php

/**
* @package MeetingParents
*/

class Activate
{

public function activate(){
		
	 global $wpdb;

   if ($wpdb->get_var("SHOW TABLES LİKE $wpdb->prefix.'appointment'") != $wpdb->prefix.'appointment')
   {
     $wpdb->query
     ("
      CREATE TABLE `{$wpdb->prefix}appointment` (
      `appoint_id` int(6) NOT NULL,
      `isnp_id` int(6) NOT NULL,
      `a_takestat` tinyint(1) DEFAULT NULL,
      `a_date` datetime NOT NULL,
      `a_status` enum('possitive','negative','kayit') COLLATE utf8_turkish_ci NOT NULL,
      `a_statements` varchar(500) COLLATE utf8_turkish_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;"
  );
   } 
   if ($wpdb->get_var("SHOW TABLES LİKE $wpdb->prefix.'deletedappointment'") != $wpdb->prefix.'deletedappointment')
   {
    $wpdb->query
    ("
      CREATE TABLE `{$wpdb->prefix}deletedappointment` (
      `appoint_id` int(6) NOT NULL,
      `isnp_id` int(6) NOT NULL,
      `a_takestat` tinyint(1) DEFAULT NULL,
      `a_date` datetime NOT NULL,
      `a_status` enum('possitive','negative','kayit') COLLATE utf8_turkish_ci NOT NULL,
      `a_statements` varchar(500) COLLATE utf8_turkish_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;"
  );
  } 


  if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}isnp'") != $wpdb->prefix.'isnp')
  {
   $wpdb->query
   ("
    CREATE TABLE `{$wpdb->prefix}isnp` (
    `isnp_id` int(6) NOT NULL,
    `i_parent_name` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
    `i_parent_surname` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
    `i_student_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_student_surname` varchar(40) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_student_grade` enum('1','2','3','4','5','6','7','8','9','10','11','12','m') CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_student_school` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_preference` enum('sahis','kurscom','kursbudur','internetsitesi') CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_preference_statement` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_notes` varchar(500) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_parent_phone` int(11) NOT NULL,
    `i_student_phone` int(11) DEFAULT NULL,
    `i_status_statement` varchar(500) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_contact_date` date NOT NULL,
    `i_status` enum('active','left','possitive','negative','nextime') CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;
    "
  );
 } 

 if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}isnpDeleted'") != $wpdb->prefix.'isnpDeleted')
 {
   $wpdb->query
   ("
    CREATE TABLE `{$wpdb->prefix}isnpDeleted` (
    `isnp_id` int(6) NOT NULL,
    `i_parent_name` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
    `i_parent_surname` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
    `i_student_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_student_surname` varchar(40) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_student_grade` enum('1','2','3','4','5','6','7','8','9','10','11','12','m') CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_student_school` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_preference` enum('sahis','kurscom','kursbudur','internetsitesi') CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_preference_statement` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_notes` varchar(500) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_parent_phone` int(11) NOT NULL,
    `i_student_phone` int(11) DEFAULT NULL,
    `i_status_statement` varchar(500) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `i_contact_date` date NOT NULL,
    `i_delete_date` datetime NOT NULL,
    `i_status` enum('active','left','possitive','negative','nextime') CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;
    "
  );
 } 

 $wpdb->query
  ("
  ALTER TABLE `{$wpdb->prefix}appointment`
  ADD PRIMARY KEY (`appoint_id`),
  ADD KEY `isnp_id` (`isnp_id`);
  "
  );

 $wpdb->query
 ("
   ALTER TABLE `{$wpdb->prefix}isnp`
   ADD PRIMARY KEY (`isnp_id`);
   "
 );




 $wpdb->query
 ("
  ALTER TABLE `{$wpdb->prefix}appointment`
  MODIFY `appoint_id` int(6) NOT NULL AUTO_INCREMENT;
  "
 );


 $wpdb->query
 ("
  ALTER TABLE `{$wpdb->prefix}isnp`
  MODIFY `isnp_id` int(6) NOT NULL AUTO_INCREMENT;
  "
 );
 

 $wpdb->query
 ("
  ALTER TABLE {$wpdb->prefix}appointment
  ADD CONSTRAINT `appointmen_ibfk_1` FOREIGN KEY (`isnp_id`) REFERENCES {$wpdb->prefix}isnp (`isnp_id`) ON DELETE CASCADE ON UPDATE CASCADE;
  COMMIT;
  "
 );
 


if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}branch'") != $wpdb->prefix.'branch')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}branch` (
    `branch_id` int(6) NOT NULL,
    `grade_id` int(6) NOT NULL,
    `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

  ");
}


$wpdb->query("


  INSERT INTO `{$wpdb->prefix}branch` (`branch_id`, `grade_id`, `name`) VALUES
  (1, 5, 'Matematik 8'),
  (2, 5, 'Fen Bilgisi 8'),
  (3, 5, 'İnkılap Tarihi ve Atatürkçülük 8'),
  (4, 5, 'Türkçe 8'),
  (5, 5, 'İngilizce 8'),
  (6, 5, 'Din Kültürü ve Ahlak Bilgisi 8'),
  (7, 4, 'Fen Bilgisi 7'),
  (8, 4, 'Sosyal Bilgiler 7'),
  (9, 4, 'Türkçe 7'),
  (10, 4, 'İngilizce 7'),
  (11, 4, 'Din Kültürü ve Ahlak Bilgisi 7'),
  (12, 4, 'Matematik 7'),
  (13, 9, 'Matematik 12'),
  (14, 9, 'Türkçe TYT'),
  (15, 9, 'Coğrafya TYT'),
  (16, 9, 'Tarih TYT'),
  (17, 9, 'Din Kültürü ve Ahlak Bilgisi TYT'),
  (18, 9, 'Felsefe TYT'),
  (19, 9, 'Fizik TYT'),
  (20, 9, 'Kimya TYT'),
  (21, 9, 'Biyoloji TYT'),
  (22, 9, 'Matematik AYT'),
  (23, 9, 'Türk Dili ve Edebiyatı AYT'),
  (24, 9, 'Coğrafya 1 AYT'),
  (25, 9, 'Coğrafya 2 AYT'),
  (26, 9, 'Tarih aYT'),
  (27, 9, 'Din Kültürü ve Ahlak Bilgisi AYT'),
  (28, 9, 'Felsefe AYT'),
  (29, 9, 'Fizik AYT'),
  (30, 9, 'Kimya AYT'),
  (31, 9, 'Biyoloji AYT'),
  (32, 10, 'Matematik TYT'),
  (33, 10, 'Türkçe TYT'),
  (34, 10, 'Coğrafya TYT'),
  (35, 10, 'Tarih TYT'),
  (36, 10, 'Din Kültürü ve Ahlak Bilgisi TYT'),
  (37, 10, 'Felsefe TYT'),
  (38, 10, 'Fizik TYT'),
  (39, 10, 'Kimya TYT'),
  (40, 10, 'Biyoloji TYT'),
  (41, 10, 'Matematik AYT'),
  (42, 10, 'Türk Dili ve Edebiyatı AYT'),
  (43, 10, 'Coğrafya 1 AYT'),
  (44, 10, 'Coğrafya 2 AYT'),
  (45, 10, 'Tarih aYT'),
  (46, 10, 'Din Kültürü ve Ahlak Bilgisi AYT'),
  (47, 10, 'Felsefe AYT'),
  (48, 10, 'Fizik AYT'),
  (49, 10, 'Kimya AYT'),
  (50, 10, 'Biyoloji AYT'),
  (51, 8, 'Matematik 11'),
  (52, 8, 'Türk Dili ve Edebiyatı 11'),
  (53, 8, 'Coğrafya 11'),
  (54, 8, 'Tarih 11'),
  (55, 8, 'Din Kültürü ve Ahlak Bilgisi 11'),
  (56, 8, 'Felsefe 11'),
  (57, 8, 'Fizik 11'),
  (58, 8, 'Kimya 11'),
  (59, 8, 'Biyoloji 11'),
  (60, 7, 'Matematik 10'),
  (61, 7, 'Türk Dili ve Edebiyatı 10'),
  (62, 7, 'Coğrafya 10'),
  (63, 7, 'Tarih 10'),
  (64, 7, 'Din Kültürü ve Ahlak Bilgisi 10'),
  (65, 7, 'Felsefe 10'),
  (66, 7, 'Fizik 10'),
  (67, 7, 'Kimya 10'),
  (68, 7, 'Biyoloji 10'),
  (69, 6, 'Matematik 9'),
  (70, 6, 'Türk Dili ve Edebiyatı 9'),
  (71, 6, 'Coğrafya 9'),
  (72, 6, 'Tarih 9'),
  (73, 6, 'Din Kültürü ve Ahlak Bilgisi 9'),
  (74, 6, 'Felsefe 9'),
  (75, 6, 'Fizik 9'),
  (76, 6, 'Kimya 9'),
  (77, 6, 'Biyoloji 9');

  ");



if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}classroom'") != $wpdb->prefix.'classroom')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}classroom` (
    `id` int(3) NOT NULL,
    `quota` int(2) NOT NULL,
    `name` varchar(4) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
    `floor` int(1) NOT NULL,
    `window` tinyint(1) NOT NULL,
    `front` tinyint(1) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;


    ");
}


$wpdb->query("

  INSERT INTO `classroom` (`id`, `quota`, `name`, `floor`, `window`, `front`) VALUES
  (1, 1, 'b101', 1, 1, 1),
  (3, 1, 'b102', 1, 1, 1),
  (4, 1, 'b103', 1, 0, 1),
  (5, 1, 'b104', 1, 0, 1),
  (6, 1, 'b105', 1, 0, 0),
  (7, 1, 'b106', 1, 0, 0),
  (8, 1, 'b107', 1, 1, 0),
  (9, 6, 'g101', 1, 1, 1),
  (10, 6, 'g102', 1, 1, 0),
  (11, 6, 'g103', 1, 1, 0),
  (12, 20, 'e101', 1, 1, 1),
  (13, 1, 'b201', 2, 1, 1),
  (14, 1, 'b202', 2, 1, 1),
  (15, 1, 'b203', 2, 0, 1),
  (16, 1, 'b204', 2, 0, 1),
  (17, 1, 'b205', 2, 0, 0),
  (18, 1, 'b206', 2, 0, 0),
  (19, 1, 'b207', 2, 1, 0),
  (20, 6, 'g201', 2, 1, 1),
  (21, 6, 'g202', 2, 1, 0),
  (22, 6, 'g203', 2, 1, 0),
  (23, 20, 'e201', 2, 1, 1),
  (24, 1, 'b301', 3, 1, 1),
  (25, 1, 'b302', 3, 1, 1),
  (26, 1, 'b303', 3, 0, 1),
  (27, 1, 'b304', 3, 0, 1),
  (28, 1, 'b305', 3, 0, 0),
  (29, 1, 'b306', 3, 0, 0),
  (30, 1, 'b307', 3, 1, 0),
  (31, 6, 'g301', 3, 1, 1),
  (32, 6, 'g302', 3, 1, 0),
  (33, 6, 'g303', 3, 1, 0),
  (34, 20, 'e301', 3, 1, 1);

  ");





if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}grade'") != $wpdb->prefix.'grade')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}grade` (
    `grade_id` int(6) NOT NULL,
    `grade_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;


    ");
}

$wpdb->query("

  INSERT INTO `{$wpdb->prefix}grade` (`grade_id`, `grade_name`) VALUES
  (7, '10. Sınıf'),
  (8, '11. Sınıf'),
  (9, '12. Sınıf'),
  (2, '5. Sınıf'),
  (3, '6. Sınıf'),
  (4, '7. Sınıf'),
  (5, '8. Sınıf'),
  (6, '9. Sınıf'),
  (10, 'mezun');

  ");

if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}lesson_group'") != $wpdb->prefix.'lesson_group')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}lesson_group` (
    `group_id` int(6) NOT NULL,
    `1_student_id` int(6) DEFAULT NULL,
    `2_student_id` int(6) DEFAULT NULL,
    `3_student_id` int(6) DEFAULT NULL,
    `4_student_id` int(6) DEFAULT NULL,
    `5_student_id` int(6) DEFAULT NULL,
    `6_student_id` int(6) DEFAULT NULL,
    `grade_id` int(6) NOT NULL,
    `group_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;


    ");
}

if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}lesson_match'") != $wpdb->prefix.'lesson_match')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}lesson_match` (
    `teacher_id` int(11) DEFAULT NULL,
    `student_id` int(11) DEFAULT NULL,
    `group_id` int(6) DEFAULT NULL,
    `week_id` int(11) DEFAULT NULL,
    `day_id` int(11) DEFAULT NULL,
    `branch_id` int(11) DEFAULT NULL,
    `topic_id` int(11) DEFAULT NULL,
    `classroom_id` int(11) DEFAULT NULL,
    `grade_id` int(11) DEFAULT NULL,
    `id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;


    ");
}

if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}program'") != $wpdb->prefix.'program')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}program` (
    `program_id` int(6) NOT NULL,
    `fee` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
    `private` tinyint(1) NOT NULL,
    `lesson_hour` int(11) NOT NULL,
    `program_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
    `period` varchar(30) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;


    ");
}



$wpdb->query("

  INSERT INTO `{$wpdb->prefix}program` (`program_id`, `fee`, `private`, `lesson_hour`, `program_name`, `period`) VALUES
  (1, '900 TL', 1, 1, 'Özel 1 - 1920', 'Aylık'),
  (2, '1200 TL', 1, 2, 'Özel 2 - 1920', 'Aylık'),
  (3, '1800 TL', 1, 3, 'Özel 3 - 1920', 'Aylık'),
  (4, '2400 TL', 1, 4, 'Özel 4 - 1920', 'Aylık'),
  (5, '3000 TL', 1, 5, 'Özel 5 - 1920', 'Aylık'),
  (6, '3600 TL', 1, 6, 'Özel 6 - 1920', 'Aylık'),
  (7, '16500 TL', 1, 4, 'LGS Grup - 1920', 'Yıllık'),
  (8, '22500 TL', 1, 4, 'AYT Grup - 1920', 'Yıllık');


  ");


if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}student'") != $wpdb->prefix.'student')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}student` (
    `student_id` int(6) NOT NULL,
    `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
    `surname` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
    `number` int(6) NOT NULL,
    `phone_number` varchar(11) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `e_mail` varchar(40) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `adress` varchar(300) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `grade_id` int(6) NOT NULL,
    `program_id` int(6) DEFAULT NULL,
    `active` tinyint(1) NOT NULL DEFAULT '0',
    `scholarship` tinyint(1) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;


    ");
}

$wpdb->query("

  INSERT INTO `{$wpdb->prefix}student` (`student_id`, `name`, `surname`, `number`, `phone_number`, `e_mail`, `adress`, `grade_id`, `program_id`, `active`, `scholarship`) VALUES
  (5, 'Zeynel', 'Bindallı', 100, '0956333', '', 'zeynel@placo.vom', 2, NULL, 0, 1),
  (6, 'Samet', 'Zavkallı', 101, '5568896', 'zeynel@placo.vom', 'Bursa karayolu', 8, NULL, 1, 0);


  ");

if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}teacher'") != $wpdb->prefix.'teacher')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}teacher` (
    `teacher_id` int(6) NOT NULL,
    `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
    `active` tinyint(1) NOT NULL,
    `surname` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
    `phone_number` varchar(11) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `adress` varchar(300) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `birthday` date DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;



    ");
}

if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}teacher'") != $wpdb->prefix.'teacher')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}teacher` (
    `teacher_id` int(6) NOT NULL,
    `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
    `active` tinyint(1) NOT NULL,
    `surname` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
    `phone_number` varchar(11) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `adress` varchar(300) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
    `birthday` date DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;



    ");
}

if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}teacher'") != $wpdb->prefix.'teacher')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}tea_bra_match` (
    `tea_bra_match_id` int(6) NOT NULL,
    `branch_id` int(6) NOT NULL,
    `teacher_id` int(6) NOT NULL,
    `match_point` int(1) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;



    ");
}

if ($wpdb->get_var("SHOW TABLES LİKE '{$wpdb->prefix}teacher'") != $wpdb->prefix.'teacher')
{
  $wpdb->query("

    CREATE TABLE `{$wpdb->prefix}topic` (
    `topic_id` int(6) NOT NULL,
    `branch_id` int(6) NOT NULL,
    `name` varchar(50) CHARACTER SET latin1 NOT NULL,
    `rank` int(3) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;


    ");
}







$wpdb->query("

  ALTER TABLE `{$wpdb->prefix}branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `grade_id` (`grade_id`);

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}classroom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

  ");

$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD UNIQUE KEY `grade_name` (`grade_name`);


  ");


$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}lesson_group`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `1_student_id` (`1_student_id`),
  ADD KEY `2_student_id` (`2_student_id`),
  ADD KEY `3_student_id` (`3_student_id`),
  ADD KEY `4_student_id` (`4_student_id`),
  ADD KEY `5_student_id` (`5_student_id`),
  ADD KEY `6_student_id` (`6_student_id`),
  ADD KEY `grade_id` (`grade_id`);

  ");


$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}lesson_match`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classroom_id` (`classroom_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `week_id` (`week_id`),
  ADD KEY `day_id` (`day_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `grade_id` (`grade_id`),
  ADD KEY `group_id` (`group_id`);
  ");




$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}program`
  ADD PRIMARY KEY (`program_id`);

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `number` (`number`),
  ADD KEY `grade_id` (`grade_id`),
  ADD KEY `program_id` (`program_id`);

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}teacher`
  ADD PRIMARY KEY (`teacher_id`);



  ");


$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}tea_bra_match`
  ADD PRIMARY KEY (`tea_bra_match_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `teacher_id` (`teacher_id`);

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}topic`
  ADD PRIMARY KEY (`topic_id`),
  ADD UNIQUE KEY `rank` (`rank`),
  ADD KEY `branch_id` (`branch_id`);

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}branch`
  MODIFY `branch_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;


  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}classroom`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;


  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}grade`
  MODIFY `grade_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

  ");




$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}lesson_group`
  MODIFY `group_id` int(6) NOT NULL AUTO_INCREMENT;

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}lesson_match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}program`
  MODIFY `program_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;


  ");


$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}student`
  MODIFY `student_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}teacher`
  MODIFY `teacher_id` int(6) NOT NULL AUTO_INCREMENT;

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}tea_bra_match`
  MODIFY `tea_bra_match_id` int(6) NOT NULL AUTO_INCREMENT;

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}topic`
  MODIFY `topic_id` int(6) NOT NULL AUTO_INCREMENT;


  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`grade_id`) REFERENCES `{$wpdb->prefix}grade` (`grade_id`) ON DELETE CASCADE ON UPDATE CASCADE;


  ");


$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}lesson_group`
  ADD CONSTRAINT `lesson_group_ibfk_1` FOREIGN KEY (`1_student_id`) REFERENCES `{$wpdb->prefix}student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_group_ibfk_2` FOREIGN KEY (`2_student_id`) REFERENCES `{$wpdb->prefix}student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_group_ibfk_3` FOREIGN KEY (`3_student_id`) REFERENCES `{$wpdb->prefix}student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_group_ibfk_4` FOREIGN KEY (`4_student_id`) REFERENCES `{$wpdb->prefix}student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_group_ibfk_5` FOREIGN KEY (`5_student_id`) REFERENCES `{$wpdb->prefix}student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_group_ibfk_6` FOREIGN KEY (`6_student_id`) REFERENCES `{$wpdb->prefix}student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_group_ibfk_7` FOREIGN KEY (`grade_id`) REFERENCES `{$wpdb->prefix}grade` (`grade_id`) ON DELETE CASCADE ON UPDATE CASCADE;

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}lesson_match`
  ADD CONSTRAINT `lesson_match_ibfk_1` FOREIGN KEY (`classroom_id`) REFERENCES `{$wpdb->prefix}classroom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_match_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `{$wpdb->prefix}teacher` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_match_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `{$wpdb->prefix}student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_match_ibfk_4` FOREIGN KEY (`topic_id`) REFERENCES `{$wpdb->prefix}topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_match_ibfk_5` FOREIGN KEY (`branch_id`) REFERENCES `{$wpdb->prefix}branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_match_ibfk_6` FOREIGN KEY (`group_id`) REFERENCES `{$wpdb->prefix}lesson_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_match_ibfk_7` FOREIGN KEY (`grade_id`) REFERENCES `{$wpdb->prefix}grade` (`grade_id`) ON DELETE CASCADE ON UPDATE CASCADE;


  ");

$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`grade_id`) REFERENCES `{$wpdb->prefix}grade` (`grade_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `{$wpdb->prefix}program` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE;

  ");



$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}tea_bra_match`
  ADD CONSTRAINT `tea_bra_match_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `{$wpdb->prefix}branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tea_bra_match_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `{$wpdb->prefix}teacher` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;
  ");




$wpdb->query("
  ALTER TABLE `{$wpdb->prefix}topic`
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `{$wpdb->prefix}branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;
  COMMIT;
  ");
	flush_rewrite_rules();
}
	


}
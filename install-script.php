<?php
global $wpdb;
$add_subject = "CREATE TABLE IF NOT EXISTS `emarksheet_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT  CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;";
$wpdb->query($add_subject);

$add_quiz = "CREATE TABLE IF NOT EXISTS `emarksheet_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `marks` TEXT NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=4 ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$wpdb->query($add_quiz);

$add_question = "CREATE TABLE IF NOT EXISTS `emarksheet_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `district` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `name_of_principal` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=5 ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$wpdb->query($add_question);

$result = "CREATE TABLE IF NOT EXISTS `emarksheet_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `roll_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_n` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_n` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `father_n` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob_date` int(11) NOT NULL,
  `dob_month` int(11) NOT NULL,
  `dob_year` int(11) NOT NULL,
  `enroll_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mother_n` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=6 ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$wpdb->query($result);

$result1 = "CREATE TABLE IF NOT EXISTS `emarksheet_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` int(11) NOT NULL,
  `sub_name` varchar(255) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `min_pass` int(11) DEFAULT 33,
  PRIMARY KEY (`id`)
)AUTO_INCREMENT=6 ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$wpdb->query($result1);
?>

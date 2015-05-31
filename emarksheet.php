<?php
/*
Plugin Name: Online Marksheet Creator : eMarksheet
Plugin URI: http://impulsesoftech.com
Description: This is a simple and unique wordpress plugin to create a simple marksheet using wordpress. You can also give a link to your users to see the result and print it.
Author: rohitashv
Version: 2.8
Author URI: http://impulsesoftech.com
*/
register_activation_hook( __FILE__, 'emarksheet_InstallScript' );
function emarksheet_InstallScript()
{
	include('install-script.php');
}
add_action('admin_menu','emarksheet_menu');
function emarksheet_menu()
{
	add_menu_page('eMarksheet','eMarksheet','administrator','eMarksheet-main');
	add_submenu_page( 'eMarksheet-main', 'eMarksheet', ' Add Class', 'administrator', 'eMarksheet-main', 'emark_add_class' );
	add_submenu_page( 'eMarksheet-main', 'eMarksheet', ' Add Subject', 'administrator', 'eMarksheet-subject', 'emark_add_subject' );
	add_submenu_page( 'eMarksheet-main', 'eMarksheet', ' Enroll Student', 'administrator', 'eMarksheet-student', 'emark_add_student');
	add_submenu_page( 'eMarksheet-main', 'eMarksheet', 'Students List', 'administrator', 'eMarksheet-student-list', 'emark_add_student_list');
	add_submenu_page( 'eMarksheet-main', 'eMarksheet', 'Add Marks', 'administrator', 'eMarksheet-add-marks', 'emark_add_marks');
	add_submenu_page( 'eMarksheet-main', 'eMarksheet', 'Settings', 'administrator', 'eMarksheet-settings', 'emark_settings');
	add_submenu_page( 'eMarksheet-main', 'eMarksheet', 'Print Marksheet', 'administrator', 'eMarksheet-print', 'emark_print');
	add_submenu_page( 'eMarksheet-main', 'eMarksheet', 'Help & Support', 'administrator', 'eMarksheet-help', 'emark_help');
	add_submenu_page( 'eMarksheet-main', 'eMarksheet', 'Un-Install', 'administrator', 'eMarksheet-remove', 'emark_uninstall');
}
function emark_add_class()
{
	include('menu-pages/emark_add_class.php');
}
function emark_add_subject()
{
	include('menu-pages/emark_add_sub.php');
}
function emark_add_student()
{
	include('menu-pages/emark_add_student.php');
}
function emark_add_student_list()
{
	include('menu-pages/emark_add_student_list.php');
}
function emark_add_marks()
{
	include('menu-pages/emark_add_marks.php');
}
function emark_settings()
{
	include('menu-pages/settings.php');
}
function emark_print()
{
	include('menu-pages/print.php');
}
function emark_help()
{
	include('menu-pages/help.php');
}
function emark_uninstall()
{
	include('menu-pages/uninstall.php');
}
?>

<?php
require 'class.data.php';

if (!$_SESSION['user']) {
	header('Location: login.php');
	exit();
}

$timeclock = New data($_SESSION['user']);

$timeclock->template->print_head();

$timeclock->print_header();

$timeclock->print_report();

$timeclock->template->print_foot();
?>
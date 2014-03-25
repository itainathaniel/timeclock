<?php
require 'class.data.php';

if (!$_SESSION['user']) {
	header('Location: login.php');
	exit();
}

$timeclock = New data($_SESSION['user']);

if ($timeclock->update($_POST)) {
	if ($timeclock->month != date('n') OR $timeclock->year != date('Y')) {
		header('Location: index.php?month='.$timeclock->month.'&year='.$timeclock->year);
	} else {
		header('Location: index.php');
	}
} else {
	echo 'error?';
}
?>
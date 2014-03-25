<?php
session_start();
require 'class.user.php';

$user = New user($_SESSION['user']);

if (!$_SESSION['user']) {
	if ($_POST['email'] AND $_POST['password']) {
		if ($user->login($_POST['email'], $_POST['password'])) {
			$_SESSION['user'] = $user->user;
			header('Location: index.php');
			exit();
		} else {
			echo 'error in login form';
		}
	} else {
		?>
<form action="login.php" method="post">
<input type="text" name="email" />
<br />
<input type="password" name="password" />
<br />
<input type="submit" name="submit" value="Log In" />
</form>
		<?
	}
} else {
	header('Location: index.php');
	exit();
}
?>
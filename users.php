<?php
require 'class.user.php';

if (!$_SESSION['user']) {
	header('Location: login.php');
	exit();
}

$timeclock = New user($_SESSION['user']);

$timeclock->template->print_head();

$timeclock->print_header();

?>

<div id="main">
	<div id="content">
		<?php
		$q = $timeclock->get_all_users();
		if (mysql_num_rows($q) > 0) {
			echo '<table>';
			echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Active</th><th>Admin</th><th>Actions</th></tr>';
			while ($r = mysql_fetch_assoc($q)) {
				echo '<tr>';
				echo '<td>'.$r['id'].'</td>';
				echo '<td>'.$r['name'].'</td>';
				echo '<td>'.$r['email'].'</td>';
				echo '<td>XXXXX</td>';
				echo '<td>'.$r['active'].'</td>';
				echo '<td>'.$r['admin'].'</td>';
				echo '<td>&nbsp;</td>';
				echo '</tr>';
			}
			echo '<tr><td>New:</td><td><input type="text" name="name" /></td><td><input type="text" name="email" /></td><td><input type="text" name="password" /></td><td><select name="active"><option vlaue="1">Active</option><option vlaue="0">Not Active</option></select></td><td><select name="admin"><option vlaue="0">Not Admin</option><option vlaue="1">Admin</option></select></td><td><input type="submit" name="submit" value="Add" /></td></tr>';
			echo '</table>';
		}
		?>
	</div>
</div>

<?php
$timeclock->template->print_foot();
?>
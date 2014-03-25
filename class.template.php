<?php
class template {

	var $month = '';
	var $year = '';

	function template() {
		$this->month = 0;
		$this->year = 0;
		return true;
	}
	
	function set_month($month){
		$this->month = $month;
	}

	function set_year($year){
		$this->year = $year;
	}

	function print_head () {
		echo '<!DOCTYPE html>';
		echo '<html dir="ltr" lang="en-US">';
		echo '<head>';
		echo '	<meta charset="UTF-8" />';
		echo '	<title> :: timeclock :: </title>';
		echo '	<link rel="shortcut icon" href="favicon.ico" >';
		echo '	<link rel="stylesheet" type="text/css" media="all" href="style.css" />';
		//echo '	<script type="text/javascript"></script>';
		echo '</head>';
		echo '<body>';
	}
	
	function print_header($user, $now) {
		echo '<div id="header">';
		echo '	<h1>Wibiya Time Clock</h1>';
		echo '	<ul id="nav">';
		echo '		<li><a class="user" href="#">'.$user.'</a></li>';
		echo '		<li><a class="users" href="users.php">Users</a></li>';
		echo '		<li><a class="report" href="report.php?month='.date('n', $now).'&year='.date('Y', $now).'">report</a></li>';
		echo '		<li><a class="logout" href="logout.php">log out</a></li>';
		echo '	</ul>';
		echo '</div>';
	}
	
	function print_foot () {
		echo '</body>';
		echo '</html>';
	}

	function print_month($query){
		$data = array();
		while ($r = mysql_fetch_assoc($query)) {
			$day = explode('-', $r['day']);
			$data[(int)$day[2]]['in']		= ($r['time_in'] != 0) ? date('H:i', $r['time_in']) : '';
			$data[(int)$day[2]]['out']		= ($r['time_out'] != 0) ? date('H:i', $r['time_out']) : '';
			$data[(int)$day[2]]['notes']	= $r['notes'];
		}

		$month_time = mktime(0, 0, 0, $this->month, 1, $this->year);
		
		$days_in_month = date('t', $month_time);
		if ($this->month == date('m') AND $this->year == date('Y')) {
			$days_in_month = date('j');
		}
		
		echo '<table>';
		for ($i=1; $i <= $days_in_month; $i++) {
			$day_time = mktime(0, 0, 0, $this->month, $i, $this->year);
			if ($i == 1 OR (date('w', $day_time) == 0)) {
				echo '<tr><td>&nbsp;</td><td>In</td><td>Out</td><td>Notes</td><td>&nbsp;</td></tr>';
			}
			echo '<form action="update.php" method="post">';
			echo '<input type="hidden" name="date" value="'.$i.'_'.$this->month.'_'.$this->year.'" />';
			echo '<tr>';
			echo '<td class="date">'.date('l, F jS', $day_time).'</td>';
			echo '<td class="in"><input type="text" name="in" value="'.$data[$i]['in'].'" class="time" /></td>';
			echo '<td class="out"><input type="text" name="out" value="'.$data[$i]['out'].'" class="time" /></td>';
			echo '<td class="notes"><input type="text" name="notes" value="'.$data[$i]['notes'].'" class="remarks" /></td>';
			echo '<td class="submit"><input type="submit" name="submit" value="Update" /></td>';
			echo '</tr>';
			echo '</form>';
		}
		echo '</table>';
	}

	function print_month_report($query){
		$data = array();
		while ($r = mysql_fetch_assoc($query)) {
			$day = explode('-', $r['day']);
			$data[(int)$day[2]]['in']		= ($r['time_in'] != 0) ? $r['time_in'] : '';
			$data[(int)$day[2]]['out']		= ($r['time_out'] != 0) ? $r['time_out'] : '';
			$data[(int)$day[2]]['notes']	= $r['notes'];
		}

		$month_time = mktime(0, 0, 0, $this->month, 1, $this->year);
		$days_in_month = date('t', $month_time);
		
		echo '<table border="1">';
		echo '<tr><td>Date</td><td>Day</td><td>In</td><td>Out</td><td>Hours</td><td>Remarks</td></tr>';
		$total_seconds = 0;
		for ($i=1; $i <= $days_in_month; $i++) {
			$day_time = mktime(0, 0, 0, $this->month, $i, $this->year);

			$hours = '';
			if ($data[$i]['in'] != '' AND $data[$i]['out'] != '') {
				$seconds = $data[$i]['out'] - $data[$i]['in'];
				$total_seconds += $seconds;
				$hoursDiff = floor($seconds / 3600); // 60 * 60
				$minutesDiffRemainder = ($seconds % 3600) / 60; // 60 * 60
				$hours = $hoursDiff . 'h ' . $minutesDiffRemainder . 'm';
			}
			
			$_date = date('j-M-Y', $day_time);
			$_day = date('l', $day_time);
			$_in = ($data[$i]['in'] != '' ? date('g:i A', $data[$i]['in']) : '');
			$_out = ($data[$i]['out'] != '' ? date('g:i A', $data[$i]['out']) : '');

			echo '<tr>';
			echo '<td class="date">'.$_date.'</td>';
			echo '<td class="date">'.$_day.'</td>';
			echo '<td class="in">'.$_in.'</td>';
			echo '<td class="out">'.$_out.'</td>';
			echo '<td class="notes">'.$hours.'</td>';
			echo '<td class="notes">'.$data[$i]['notes'].'</td>';
			echo '</tr>';
		}
		$hoursDiff = floor($total_seconds / 3600); // 60 * 60
		$minutesDiffRemainder = ($total_seconds % 3600) / 60; // 60 * 60
		$hours = $hoursDiff . 'h ' . $minutesDiffRemainder . 'm';
		echo '<tr><td>Total</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.$hours.'</td><td>&nbsp;</td></tr>';
		echo '</table>';
	}
}
?>
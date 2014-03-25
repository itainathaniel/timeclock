<?php
require 'class.user.php';

class data extends user {

	function data($userid){
		parent::__construct($userid);
		return true;
	}
	
	function update($post) {
		//echo '<pre>'.print_r($post,1).'</pre><hr />';
		$date = explode('_', $post['date']);
		$in = explode(':', $post['in']);
		$out = explode(':', $post['out']);
		$day = $date[2].'-'.$date[1].'-'.$date[0];
		$this->set_month($date[1]);
		$this->set_year($date[2]);
		
		$db_in = ($post['in'] != '') ? mktime($in[0], $in[1], 0, $date[1], $date[0], $date[2]) : 0;
		$db_out = ($post['out'] != '') ? mktime($out[0], $out[1], 0, $date[1], $date[0], $date[2]) : 0;
		
		$sql = "INSERT INTO ".$this->config['prefix']."info (uid, day, time_in, time_out, notes)";
		$sql.= " VALUES (".$this->userid.", '".$day."', ".$db_in.", ".$db_out.", '".$post['notes']."')";
		$sql.= " ON DUPLICATE KEY UPDATE time_in = ".$db_in.", time_out = ".$db_out.", notes = '".$post['notes']."';";
		if (mysql_query($sql)) {
			//echo $sql.'<br />';
			return true;
		} else {
			//echo $sql.'<br />';
			return false;
		}
	}
	
	function print_report() {
		?>
		<div id="main">
			<div id="content">
				<?php
				$in		= mktime(0, 0, 0, $this->month, 1, $this->year);
				$out	= strtotime('+1 month', $in);
				$query = mysql_query("SELECT * FROM wibiya_timeclock_info WHERE uid = ".$this->userid." AND YEAR(day) = '".$this->year."' AND MONTH(day) = '".$this->month."';", $this->conn);
				
				$this->template->set_month($this->month);
				$this->template->set_year($this->year);
				$this->template->print_month_report($query);
				?>
			</div>
		</div>
		<?php
		return true;
	}
	
	function print_month_table(){
		?>
		<div id="main">
			<div id="content">
				<div id="month">
					<a class="prev" href="index.php?<?php echo 'month='.date('n', $this->prev).'&year='.date('Y', $this->prev); ?>">«</a>
					<span class="curr"><?php echo date('F Y', $this->now); ?></span>
					<a class="next" href="index.php?<?php echo 'month='.date('n', $this->next).'&year='.date('Y', $this->next); ?>">»</a>
				</div>
				<?php
				$in		= mktime(0, 0, 0, $this->month, 1, $this->year);
				$out	= strtotime('+1 month', $in);
				$query = mysql_query("SELECT * FROM wibiya_timeclock_info WHERE uid = ".$this->userid." AND YEAR(day) = '".$this->year."' AND MONTH(day) = '".$this->month."';", $this->conn);
				
				$this->template->set_month($this->month);
				$this->template->set_year($this->year);
				$this->template->print_month($query);
				?>
			</div>
		</div>
		<?php
	}

}
?>
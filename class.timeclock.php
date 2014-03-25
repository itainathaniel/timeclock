<?php
session_start();

class timeclock {
	
	var $salt = 'wibiyahq';
	var $config = array();
	var $month = '';
	var $year = '';

	function timeclock(){
		require 'config.php';
		$this->config = $config;

		require 'class.template.php';
		$this->template = New template();

		$this->conn = mysql_connect($config['database'], $config['db_user'], $config['db_pass']);
		mysql_select_db($config['db_name'], $this->conn);

		if ($_GET['month'] AND (int)$_GET['month']) {
			$this->month = (int)$_GET['month'];
		} else {
			$this->month = date('n');
		}
		if ($_GET['year'] AND (int)$_GET['year']) {
			$this->year = (int)$_GET['year'];
		} else {
			$this->year = date('Y');
		}

		$this->now = mktime(0,0,0,$this->month,1,$this->year);
		$this->prev = strtotime('-1 month', $this->now);
		$this->next = strtotime('+1 month', $this->now);

		return true;
	}
	
	function set_month($month){
		$this->month = $month;
	}

	function set_year($year){
		$this->year = $year;
	}
	
	function print_header(){
		$this->template->print_header($this->name, $this->now);
	}

}
?>
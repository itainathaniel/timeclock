<?php
require 'class.timeclock.php';

class user extends timeclock {
	
	var $userid = 0;
	var $name = '';
	var $email = '';
	var $password = '';
	var $active = 0;
	var $admin = 0;

	function user($userid){
		parent::__construct();
		$this->userid = (int)$userid;
		$this->get_user();
		return true;
	}
	
	function get_user(){
		$query = mysql_query("SELECT * FROM ".$this->config['prefix']."users WHERE id = ".$this->userid.";", $this->conn);
		if (mysql_num_rows($query) == 1) {
			$r = mysql_fetch_assoc($query);
			$this->id = 1;
			$this->name = $r['name'];
			$this->email = $r['email'];
			$this->password = $r['password'];
			$this->active = $r['active'];
			$this->admin = $r['admin'];
			return true;
		} else {
			return false;
		}
	}
	
	function get_all_users(){
		$query = mysql_query("SELECT * FROM ".$this->config['prefix']."users;", $this->conn);
		if (mysql_num_rows($query) > 0) {
			return $query;
		} else {
			return false;
		}
	}
	
	function login($email, $password) {
		$query = mysql_query("SELECT id FROM ".$this->config['prefix']."users WHERE email = '".$email."' AND password = '".md5($password.$this->salt)."';", $this->conn);
		if (mysql_num_rows($query) == 1) {
			while ($r = mysql_fetch_assoc($query)) {
				$this->user = $r['id'];
			}
			return true;
		} else {
			return false;
		}
	}
	
	function add($name, $email, $password, $active, $admin){
		mysql_query("INSERT INTO ".$this->config['prefix']."users (name,email,password,active,admin) SET ('".$name."', '".$email."', '".md5($password.$this->salt)."', ".$active.", ".$admin.");", $this->conn);
	}
	
	function logout(){
		return true;
	}

}
?>
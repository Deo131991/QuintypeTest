<?php
session_start();
require_once 'User.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		$user=new User();
		$auth=$user->authenticateUser($_POST);

		print_r($auth);
		// return $auth;
}

?>
<?php
session_start();
require_once 'cabModel.php';

if($_SERVER["REQUEST_METHOD"] == "GET"){
	$cab=new cabModel();

	if ($_GET['action']=='findCab') {
		
		$nearestCab=$cab->getNearestCab($_GET);
		print_r($nearestCab);
		exit();
		// return $data;

	}
	else{
		// Get All Available Cab
		$data=$cab->getAllCabs();

		print_r($data);
		exit();
		// return $data;
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$cab=new cabModel();

	if ($_POST['action']=='bookCap') {
		
		$data=$cab->bookCab($_POST);

		print_r($data);
		exit();
		// return $data;	
	}

	if ($_POST['action']=='finishtrip') {
		
		$tripData=$cab->finishTrip($_POST);

		print_r($tripData);
		exit();

	}
	
}

?>
<?php 
	session_start();
	if (!empty($_SESSION['logged_in']))
	{
		header('Location: cabs.php');
	}    
 	include('header.php'); 
 	include("footer.php");
 ?>
 
 <title>Login</title>
<center>
	<div class="login">
		<h1 class="loginheading">BooK Cab</h1>
		<form class="form-horizontal login-form" method="post" onsubmit="authUser(); return false;" name="login">
		    <div class="form-group">
		      <label class="control-label col-sm-2" for="user">Email:</label>
		      <div class="col-sm-offset-1 col-sm-8" id="showError">
		        <input type="text" class="form-control" id="user" placeholder="Enter Full Name (Optional)" name="user_name">
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="control-label col-sm-2" for="mobile_no">Mobile Number:</label>
		      <div class="col-sm-offset-1 col-sm-8" id="showError">          
		        <input type="Number" class="form-control" id="mobile_no" placeholder="Enter Mobile Number" name="mobile_no" min="6200000000" max="9999999999" required/>
		      </div>
		    </div>
		    <div class="form-group">        
		      <div class="col-sm-12">
		        <button type="submit" id="login" class="btn btn-default">Submit</button>
		      </div>
		    </div>
		</form>
	</div>
</center>
<!-- import js file -->
<script src="js/index.js"></script>


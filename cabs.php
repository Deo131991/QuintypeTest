<?php 
	session_start();
	if (empty($_SESSION['logged_in']))
	{
		header('Location: index.php');
	}    

	include('header.php'); 
	include("footer.php");
?>
 <title>Cabs</title>
<input type="number" name="mobile_no" id="mobile_no" hidden="hidden" value="<?=$_SESSION['mobile_no']?>">
<nav class="text-right">
	<h2 style="margin-right: 20px;"><a href="logout.php"> Log Out </a></h2>
</nav>
<div class="col-sm-12 cab-contant">
	<div class="col-sm-offset-3 col-sm-6">
		<h2 class="text-center">Cabs Available</h2>
		<table class="table table-condensed">
			<thead>
			  <tr>
			  	<th>Sr No.</th>
			    <th>Cab</th>
			    <th>Number</th>
			    
			  </tr>
			</thead>
			<tbody class="carBody">
			  
			</tbody>
  		</table>
  		<div class="text-center bookCab">
  			<button class="btn btn-primary" onclick="showInputDirections()">Book Cab</button>
  		</div>
  		<div class="locations">
  			
  		</div>

  		<div class="initial_cab_information text-center">
  			
  		</div>

  		<form id="cabPickupForm" class="text-center" name="cabPickupForm"  method="post" onsubmit="pickuupCab(); return false;">
			  <div class="form-row inputStyle">
			  	<div class="col-sm-6">
			  		<input type="number" name="customer_pickup_longitude_postion" class="form-control customer_pickup_longitude_postion" placeholder="Enter Pickup Longitude" step="0.01" required>
			  	</div>
			  	<div class="col-sm-6">
			  		<input type="number" name="customer_pickup_latitude_position" class="form-control customer_pickup_latitude_position" placeholder="Enter Pickup Latitude" step="0.01" required/>
			  	</div>
			  </div>
			  <div class="clearfix"></div>
			  <div class="text-center Booknow">
  					<button class="btn btn-primary" type="submit">Book Now</button>
  				</div>
			  
			</form>
			<form id="cabBookingForm" class="text-center" name="cabBookingForm"  method="post" onsubmit="bookCab(); return false;">
				<div class="cab-available">
				
				</div>
				 <div class="btn-group btn-group-toggle col-sm-offset-4 col-sm-6" data-toggle="buttons" style="margin-top: 10px; margin-bottom: 10px;">
				  <label class="btn btn-primary active">
				    <input type="radio" name="cabColor" id="cabColor" value="Normal" autocomplete="off" checked> Normal Color
				  </label>
				  <label class="btn btn-default" style="background: #FFC0CB; color: #000;">
				    <input type="radio" name="cabColor" id="cabColor" value="Pink" autocomplete="off"> Pink Color
				  </label>
				</div>

			  <div class="form-row inputStyle">
			  	<div class="col-sm-6">
			  		<input type="number" name="customer_drop_longitude_postion" class="form-control customer_drop_longitude_postion" placeholder="Enter Drop Longitude" step="0.01" required>
			  	</div>
			  	<div class="col-sm-6">
			  		<input type="number" name="customer_drop_latitude_position" class="form-control customer_drop_latitude_position" placeholder="Enter Drop Latitude" step="0.01" required>
			  	</div>
			  </div>
			  <div class="clearfix"></div>
			  <div class="text-center Gonow">
  					<button class="btn btn-primary" type="submit">Let's Go</button>
  			  </div>			  
			</form>

			 <div class="text-center drop">
  					<button class="btn btn-primary" onclick="finishTrip();">Finish Trip</button>
  			  </div>

	</div>
	<div class="col-sm-12 text-center tripAmount">
		 
	</div>
</div>


<script src="js/cab.js"></script>
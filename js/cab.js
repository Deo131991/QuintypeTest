$(window).load(function(){

	// Get All Available Cab On Relaod
	getAllAvailableCabs();
});

function getAllAvailableCabs(){
	// get all cabs
	$.ajax({
		type:'GET',
		url: 'cabHandaler.php',
		data: '',
		success:function(result){
			
			if (result!='null') {

				var data=JSON.parse(result);
				var Carshtml='';
				var  travelingHtml='';

				console.log(result);

				for (var i = 0; i <data.length; i++) {
					if (data[i].available!=0) {

						Carshtml+='<tr><td>'+(i+1)+'</td><td>'+ data[i].cab_number +'</td><td>'+data[i].cab_make +" "+data[i].cab_model+'</td></tr>';
					}
					else{

						travelingHtml+='<h2>You Are Traveling With '+ data[i].cabColor +' '+ data[i].cab_make +' '+data[i].cab_model+ '-'+data[i].cab_number+'</h2>';

						// put pickup and drop time 
						$(".customer_pickup_longitude_postion").val(data[i].customer_pickup_longitude_postion);
						$(".customer_pickup_latitude_position").val(data[i].customer_pickup_latitude_position);
						$(".customer_drop_longitude_postion").val(data[i].customer_drop_longitude_postion);
						$(".customer_drop_latitude_position").val(data[i].customer_drop_latitude_position);
						pickup_time=data[i].pickup_time;
						bookingCabNumber=data[i].cab_number;

						$(".initial_cab_information").html(travelingHtml);
						$(".bookCab").css("display","none");
						$(".drop").css("display","block");
					}
					
				}

				$(".carBody").html(Carshtml);

			}
			else{
				$(".carBody").html('<tr style="text-align:center; width:100%;"><td>Sorry No Cab Available This Time</td></tr>');
				$(".bookCab").css("display","none");
			}
		}
	})
}


var AllCabs=[];
var bookingCabNumber='';
var pickupTime='';
function showInputDirections(){

	$(".bookCab").css("display","none");
	$("#cabPickupForm").css("display","block");
}

function pickuupCab(){
	// $("#cabPickupForm").css("display","none");
	$(".Booknow .btn-primary").text("Edit Pickup Location");
	$("#cabBookingForm").css("display","block");	

	$.ajax({
		type:'GET',
		url: 'cabHandaler.php',
		data: $("#cabPickupForm").serialize()+"&action="+"findCab",
		success:function(result){
		
			if (result!='null') {

				var data=JSON.parse(result);

				var cabHtml='<h2> Nearest Cab - '+data['cab_make']+" "+data['cab_model']+'</h2><p style="text-align:center"> Cab Number '+data['cab_number']+'</p>';
				
				bookingCabNumber=data['cab_number'];

				$(".cab-available").html(cabHtml);
			}
			else{
				$(".cab-available").html("<h2>Sorry No Cabs Available This Time</h2>");
			}


		}

	});
}

function bookCab(){

	$(".drop").css("display","block");
	$(".Gonow").css("display","none");


	 var mobile_no=$("#mobile_no").val();

	var data="cab_number="+bookingCabNumber+"&user_mobile_num="+mobile_no+"&"+$("#cabPickupForm").serialize()+'&'+$("#cabBookingForm").serialize()+" &action="+"bookCap";

	$.ajax({
		type:'POST',
		url: 'cabHandaler.php',
		data: data,
		success:function(result){

			if (result!='null') {

				var data=JSON.parse(result);
				pickup_time=data['pickup_time'];

				// Call to Update Available Cab
				getAllAvailableCabs();

			}
		}

	});

}

function finishTrip(){

	$(".drop").css("display","none");
	$(".initial_cab_information").css("display","none");
	$(".Booknow").css("display","block");


	var data="pickup_time="+pickup_time+"&cab_number="+bookingCabNumber+"&action="+"finishtrip"+"&"+$("#cabPickupForm").serialize()+'&'+$("#cabBookingForm").serialize();
	
	$.ajax({

		type:'POST',
		url :'cabHandaler.php',
		data: data,
		success:function(result){
			console.log(result);
			if (result!=='null') {
				var data=JSON.parse(result);
				// Call to Update Available Cab
				$(".tripAmount").html("<h2>Last Traveling</h2><p>Total Time : "+data['hours']+":"+data['minut']+":"+data['second']+"</p><p> Total Distance : "+ data['total_distance']+ " Km</p><p> Total Cost : "+ data['total_amount']+ " Dogecoins !</p>");
				getAllAvailableCabs();

				$("#cabPickupForm").css("display","none");
				$("#cabBookingForm").css("display","none");
				$(".drop").css("display","none");
				$(".bookCab").css("display","block");
			}
		}

	});
}
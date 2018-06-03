<?php
/**
* 
*/
session_start();
require "Connection.php";
/**
* 
*/
class CabModel
{
	
	private $db;

	function __construct(){
		$this->db=new Connection('localhost','root','root','Taxi_Service'); //creating connection
	}

	function getAllCabs(){
		$conn=$this->db->connect() or die('Error in connection') ; //connect function call 

		$sql="SELECT * FROM cabs WHERE available=1";
		
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {

			while ($row = $result->fetch_assoc()) {

				 $data[]=$row;
			}

			// finding user traveling or not at the time of reload page
			$cabRunningStatus="SELECT * FROM `cab_running_status` as cr join cabs on cr.cab_number=cabs.cab_number WHERE cr.available=0 AND user_mobile_num='".$_SESSION['mobile_no']."'";

			$res = mysqli_query($conn, $cabRunningStatus);

			// checking user allready exits or not
			if (mysqli_num_rows($res) > 0) {
				$row1 = $res->fetch_assoc();
				$data[]=$row1;
			}
		}

		return json_encode($data);
	}

	function getNearestCab($getData){

			$conn=$this->db->connect() or die('Error in connection') ; //connect function call 

			//get pickup point
			$x1=$getData['customer_pickup_longitude_postion'];
			$y1=$getData['customer_pickup_latitude_position'];

			// Find leatest cabs by their drop location which already traved
			
			$sql="SELECT DISTINCT cab_number, MAX(drop_time) as Dropdate FROM `cab_running_status` WHERE available=1 GROUP BY cab_number ORDER BY MAX(drop_time)";

			$result = mysqli_query($conn, $sql);

			$cabNumber='';

			$minDistance=1000000000; //initial distance will some large number (to find minimum num)
			$carNumber='';
			$dates='';
			$dis='';
			$data=array();

			if (mysqli_num_rows($result)>0) {
				while ($row = $result->fetch_assoc()) {

					$cabNumber.="'".$row['cab_number']."'".",";
					$dates.= "'".$row['Dropdate']."'".",";

				}

				$cabNumber=rtrim($cabNumber,',');
				$dates=rtrim($dates,',');


				// find their drop longitude and latitude location 
				$findDropLocation="SELECT * FROM cab_running_status as cr join cabs on cr.cab_number=cabs.cab_number WHERE cr.available=1 AND cr.drop_time IN ($dates)";

			
				$locResult = mysqli_query($conn, $findDropLocation);

				if (mysqli_num_rows($locResult)>0) {
					
					while ($r = $locResult->fetch_assoc()) {

						$distance=$this->findDistance($x1,$y1,$r['customer_drop_longitude_postion'],$r['customer_drop_latitude_position']);

						$dis.=$distance."  ---  ";

						if ($minDistance>$distance) {
							$minDistance=$distance;
							$data=$r;
							// $data['distance']=$minDistance;
						}
					}
				}

			}	

			if (mysqli_num_rows($result)<7) {
				// Find the cab with is not travel any more(Starting Point of cab)
				if ($cabNumber=='') {
					$cabNumber="'".''."'";
				}
				$sql1="SELECT * FROM cabs WHERE available=1 AND cab_number NOT IN ($cabNumber)";
				
				$result1 = mysqli_query($conn, $sql1);

				if (mysqli_num_rows($result1)>0) {
				
					while ($row1 = $result1->fetch_assoc()) {
					
						$distance=$this->findDistance($x1,$y1,$row1['cab_staring_longitude_position'],$row1['cab_starting_latitude_position']);
						$dis.=$distance."  ---  ";
						if ($minDistance>$distance) {
							$minDistance=$distance;
							$data=$row1;
							$data['distance']="'".$minDistance."'";
						}
		
					}

				}	

			}
		// print_r($dis);die;
			return json_encode($data);
	}

	function bookCab($postData){
		$conn=$this->db->connect() or die('Error in connection') ; //connect function call 

		// insert pickup time 
		$postData['pickup_time']=date('Y-m-d H:i:s');
		$postData['available']=0;

		$sql="INSERT INTO cab_running_status (cab_number,cabColor,user_mobile_num,customer_pickup_longitude_postion,customer_pickup_latitude_position,customer_drop_longitude_postion,customer_drop_latitude_position,pickup_time,available) VALUES ('".$postData[cab_number]."','".$postData[cabColor]."','".$postData[user_mobile_num]."',$postData[customer_pickup_longitude_postion],$postData[customer_pickup_latitude_position],$postData[customer_drop_longitude_postion],$postData[customer_drop_latitude_position],'".$postData[pickup_time]."',$postData[available])";

			if ($conn->query($sql) === TRUE) {
				// Updating cab table 

				$sqlUpdate="UPDATE cabs SET available=0 WHERE cab_number='".$postData['cab_number']."'";

				if ($conn->query($sqlUpdate) === TRUE) {
				    $postData['massage']="successfull";
				} 
				else {
				    $postData['massage']="failed";
				}
			} 
			else{
				$postData['massage']="failed";
			}

		return json_encode($postData);	
	}

	function finishTrip($postData){
		$conn=$this->db->connect() or die('Error in connection') ; //connect function call 

		$postData['drop_time']=date('Y-m-d H:i:s');
		$postData['available']=1;

		// Calculate Total Time
		$dteStart = new DateTime($postData['pickup_time']); 
   		$dteEnd   = new DateTime($postData['drop_time']); 

		$Total_Time=date_diff($dteEnd,$dteStart);

		$Total_Hours=$Total_Time->h+$Total_Time->i/60+$Total_Time->s/3600;

		// Calculate Total Distance
		$Total_Distance=$this->findDistance($postData['customer_pickup_longitude_postion'],$postData['customer_pickup_latitude_position'],$postData['customer_drop_longitude_postion'],$postData['customer_drop_latitude_position']);

		// dogicoin for fraction part( travel in minut) 
		$speed=$Total_Distance/$Total_Hours;
		$Total_Minut=($Total_Distance/$speed)*60; //Total Time


		$Distance_Int=(int)$Total_Distance;            //distance integer part
		$Distance_Float=$Total_Distance-$Distance_Int;  //distance fraction part


		$time_To_Travel_fraction_Distance=($Distance_Float/$speed)*60; //fraction time .70km

		
		$TotalDogeCoin=2*$Distance_Int; // DogeCoins With 2* KM

		$TotalDogeCoin=$TotalDogeCoin+(1*$time_To_Travel_fraction_Distance); // Total Amounts 2* KM + 1* Total Minut

		
		if ($postData['cabColor']=='Pink') {
			
			$TotalDogeCoin+=5;     //5 DogeCoins Extra with Pink Color Cab
		}
		
		$data=array();
		$data['total_distance']=sprintf("%.2f",$Total_Distance);
		$data['total_amount']=sprintf("%.4f",$TotalDogeCoin);
		$data['hours']=sprintf("%02d",$Total_Time->h);
		$data['minut']=sprintf("%02d",$Total_Time->i);
		$data['second']=sprintf("%02d",$Total_Time->s);

		// Update Database 
		$sql="UPDATE cab_running_status SET drop_time='".$postData['drop_time']."', total_distance=$Total_Distance,total_fare=$TotalDogeCoin, available=1 WHERE cab_number='".$postData['cab_number']."' AND pickup_time='".$postData['pickup_time']."'";
		
			if ($conn->query($sql) === TRUE) {

			   $sqlUpdate="UPDATE cabs SET available=1 WHERE cab_number='".$postData['cab_number']."'";

				if ($conn->query($sqlUpdate) === TRUE) {
				    $data['massage']="successfull";
				} 
				else {
				    $data['massage']="failed";
				}
			} 
			else {
			    $data['massage']="failed";
			}

		return json_encode($data);

	}

	// finding distance between two points
	function findDistance($x1,$y1,$x2,$y2){

		$distance=sqrt((pow(($x2-$x1), 2)+pow(($y2-$y1), 2)));

		return $distance;
	}

}

?>
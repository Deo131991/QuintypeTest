<?php
/**
* 
*/
session_start();
require "Connection.php";
class User {
	
	private $db;

	function __construct(){
		$this->db=new Connection('localhost','root','root','Taxi_Service'); //creating connection
	}

	//authenticate of user
	public function authenticateUser($postData){
		$conn=$this->db->connect() or die('Error in connection') ; //connect function call 
		
		$postData['user_name']=$_POST['user_name'];
		$postData['mobile_no']=$_POST['mobile_no'];


		$sql="SELECT * FROM user WHERE mobile_num=".$postData['mobile_no'];
		
		$result = mysqli_query($conn, $sql);

		// checking user allready exits or not
		if (mysqli_num_rows($result) > 0) {
			// user allready exit
			
			$_SESSION['logged_in']=1;
			$_SESSION['mobile_no']=$postData['mobile_no'];
			$postData['massage']="user exist";

			return $postData;
	
		}
		
		// get last id

		$getId = "SELECT MAX(id) as last_id FROM user";

		$idResult = mysqli_query($conn, $getId);

		// checking user allready exits or not

		if (mysqli_num_rows($idResult) > 0) {
			// get last id 
			$row = $idResult->fetch_assoc();

			$postData['id']=$row['last_id']+1;
			
		}
		else{
			// no record exit (first record)
			$postData['id']=1;
		}

		// insert time when record is created
		$postData['created_at']=date('Y-m-d H:i:s');

		$sqlInsert="INSERT INTO user (id,mobile_num,user_name, created_at) VALUES('$postData[id]','$postData[mobile_no]','$postData[user_name]','$postData[created_at]')";


		if ($conn->query($sqlInsert) === TRUE) {
			$postData['massage']="New record created successfully";

			$_SESSION['logged_in']=1;
			$_SESSION['mobile_no']=$postData['mobile_no'];
		
		} 
		else{
			$postData['massage']="failed";
		}
		
		return $postData;
	} 

}

?>
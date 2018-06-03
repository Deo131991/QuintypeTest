<?php
class Connection {

	private $servername;
	private $username; 
	private $password;
	private $dbname;

	function __construct($host,$username,$password,$dbname){
		$this->servername=$host;
		$this->username=$username;
		$this->password=$password;
		$this->dbname=$dbname;
	}
		

	public function connect(){
		$conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	}
}
 

?>
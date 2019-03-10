<?php

class mysqlConector {

    public function mysqliOpen($servername, $username, $password, $dbname)
    {
        // Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			var_dump('fallo');
		    die("Connection failed: " . $conn->connect_error);
		} 
		return $conn;
    }

    public function mysqliQuery($conn, $query)
    {
		$result = $conn->query($query);
		if ($result->num_rows > 0) {
		    // output data of each row
		    return mysqli_fetch_all($result,MYSQLI_ASSOC);
		} else {
		   	return false;
		}
    }

    public function mysqliInsert($conn, $query)
    {
		if ($conn->query($query) === TRUE) {
		    echo "New record created successfully<br>";
		    //return true;
		} else {
		    echo "Error: " . $query . "<br>" . $conn->error;
		    //return false;
		}
    }

    public function mysqliClose($conn){
    	$conn->close();
    }
}
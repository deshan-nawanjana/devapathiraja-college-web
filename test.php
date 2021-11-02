<?php

	// sql database login
	$srvrname = "localhost";
	$username = "root";
	$password = "";
	$conn = new mysqli($srvrname, $username, $password);
	if($conn->connect_error) { echo "0"; exit(); }

?>
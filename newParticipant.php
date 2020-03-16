<?php

define("SERVER_NAME", "sql204.byethost9.com");
define("DBF_USER_NAME", "b9_20707120");
define("DBF_PASSWORD", "zaagOnEm");
define("DATABASE_NAME", "b9_20707120_RaceRegistration");

// Create connection object
$conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
	
//Select Database
$conn->select_db(DATABASE_NAME);

$firstName = $_POST['txtFirstName'];
$lastName = $_POST['txtLastName'];
$phoneNumber = $_POST['txtPhoneNumber'];
$emailAddress = $_POST['txtEmailAddress'];

// Insert values in post form into database upon clicking "submit"
/*if (isset($_POST['btnSubmit'])) {
	$sql = "INSERT INTO participant (id, firstName, lastName, phoneNumber, emailAddress)
			VALUES (NULL, '" 
			. $_POST['txtFirstName'] . "', '" 
			. $_POST['txtLastName'] . "', '"
			. $_POST['txtPhoneNumber'] . "', '"
			. $_POST['txtEmailAddress'] . "')";
	$result = $conn->query($sql); 
} */

$sql = "INSERT INTO participant (id, firstName, lastName, phoneNumber, emailAddress) VALUES (NULL, ?,?,?,?)";
// Set up a prepared statement
if($stmt = $conn->prepare($sql)) {
		// Pass the parameters
		$stmt->bind_param("ssss", $firstName, $lastName, $phoneNumber, $emailAddress) ;
		if($stmt->errno) {
		displayMessage("stmt prepare( ) had error.", "red" ); 
		}
		
		// Execute the query
		$stmt->execute();
		if($stmt->errno) {
		displayMessage("Could not execute prepared statement", "red" );
		}
		
		// Store the result
		$stmt->store_result( );
		$totalCount = $stmt->num_rows;
						
		// Free results
		$stmt->free_result( );
		// Close the statement
		$stmt->close( );
} // end if( prepare( ))

$conn->close();
	
?>
<?php
   /* ================================
	*   Author: Zach Petersen
    *   Created: 10/14/2017
    *   Revised: 10/14/2017 - Initial Rev
    *   This is used for the group 3 project CSC 235
    
   */
// The JSON standard MIME header. Output as JSON, not HTML
   header('Content-type: application/json');

   // Check for the limit value
   if(isset($_POST['limit'])){
      $limit = preg_replace('#[^0-9]#', '', $_POST['limit']);
   }
   else {  // a limit variable doesn't exist. 
     $limit = 2;   
   }
      // Set up connection constants
      // Using default username and password for AMPPS   -- UPDATE FOR SERVER
      define("SERVER_NAME",   "localhost");
      define("DBF_USER_NAME", "root");
      define("DBF_PASSWORD",  "mysql");
      define("DATABASE_NAME", "group3project");
      // Global connection object
      $conn = NULL;
   
      // Connect to database
      createConnection();
      
     // Get all participants with instances of races registered for
      $sql = "SELECT P.FirstName, P.LastName, P.PhoneNumber, P.EmailAddress, RG.DateTime AS RegistrationDate, RD.RaceName, RD.Location, RD.Date AS RaceDate, RD.Distance 
      FROM Participant AS P LEFT OUTER JOIN 
      Registration AS RG ON RG.ParticipantId = P.Id LEFT OUTER JOIN 
      RaceDetails AS RD ON RD.Id = RG.RaceId";
      $result = $conn->query($sql);

       // Loop through the $result to create JSON formatted data   
 		$dataArray = array();
		while($thisRow = $result->fetch_assoc( )) {
    	$dataArray[] = $thisRow;
 		}
 	 //echo json_encode($dataArray); -- Show data DEBUG
 		
 	   // Save query results to .json file	
       $json_data = json_encode($dataArray);
	   file_put_contents('queryResults.json', $json_data);


/*************** FUNCTIONS (Alphabetical) *************************/
/* -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
 * createConnection( ) - Create a database connection
 -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - */
function createConnection( ) {
   global $conn;
   // Create connection object
   $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   } 
   // Select the database
   $conn->select_db(DATABASE_NAME);
} // end of createConnection( )

?>
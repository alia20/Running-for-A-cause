<?php
 // Tell server that you will be tracking session variables
 session_start( );
?>
<!doctype html>


<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

 <title>Analytics</title>
</head>

<body>
<nav>
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="readMe.html">Members</a></li>
        <li><a href="template.html">About Us</a></li>
        <li><a href="AminRace.php">Race Registration</a></li>
        <li><a href="ZackraceresultsForm.php">Race Results</a></li>
        <li><a href="Genesis Participant lookup Form.php">New Participants</a></li>
        <li><a href="AndynewParticipantForm.php">Participants Registration</a></li>
    </ul>
    <img id="headerImage" src="graphic/run.jpg" alt="run">
</nav>

<article>
<div class="container">

<h1>Below is a table that displays analytics data populated by a database.</h1>
<br>
<?php

// This allows you call $self on as the action on a 
// form instead of the file name
$self = $_SERVER['PHP_SELF'];

// Set up connection constants
// Using default username and password for AMPPS  
define("SERVER_NAME", "localhost");
define("DBF_USER_NAME", "root");
define("DBF_PASSWORD", "mysql");
define("DATABASE_NAME", "group3project");

// Create connection object
$conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);

// Start with a new database to start primary keys at 1
$sql = "DROP DATABASE " . DATABASE_NAME;
runQuery($sql, "DROP " . DATABASE_NAME, true);
	
/*****************
* CREATE DATABASE
******************/
	function createDatabase() {
		global $conn;
		$sql = "CREATE DATABASE IF NOT EXISTS " . DATABASE_NAME;
		if ($conn->query($sql) === TRUE) {
			echo "The database " . DATABASE_NAME . " exists or was created successfully!<br /><br>";
		} else {
			echo "Error creating database " . DATABASE_NAME . ": " . $conn->error;
			echo "<br />";
		}
	}
// Create the database if it doesn't already exist
createDatabase();

// Select the database
$conn->select_db(DATABASE_NAME);

/********************************
* CREATE QUERY FUNCTION *
*********************************/	
	function runQuery($sql, $msg, $echoSuccess) {
		global $conn;
			
		// run the query
		if ($conn->query($sql) === TRUE) {
			if($echoSuccess) {
				echo $msg . " successful.<br />";
			}
		} else {
			echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $conn->error;
		}   
	}
	
/********************************
* CREATE CONNECTION TO DATABASE *
*********************************/
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
	} 	// end of createConnection
	
	
	
/*****************
* CREATE TABLES
******************/
$sql = "CREATE TABLE IF NOT EXISTS participant (
        id 				INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL, 
        firstName		VARCHAR(100) NOT NULL,
        lastName		VARCHAR(100) NOT NULL,
        phoneNumber		VARCHAR(50) NOT NULL,
        emailAddress	VARCHAR(100) NOT NULL
        )";
runQuery($sql, "Table:participant", false);

$sql = "CREATE TABLE IF NOT EXISTS raceDetail (
        id 				INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL, 
		raceName		VARCHAR(100) NOT NULL,
		location		VARCHAR(100) NOT NULL,
		date			DATE NOT NULL,
		distance		FLOAT NOT NULL,
		distanceUnits	VARCHAR(50) NOT NULL
        )";
runQuery($sql, "Table:raceDetail", false);

$sql = "CREATE TABLE IF NOT EXISTS raceResult (
        id 				INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL, 
        registrationId  INT(11) NOT NULL,
        startTime		DATETIME NOT NULL,
		endTime			DATETIME NOT NULL,
		place			INT(11)
        )";
runQuery($sql, "Table:raceResult", false);

/* dateTime uses the 'TIMESTAMP' data type because in a MySQL database, 
columns with this data type will be automatically populated with the 
record creation timestamp.*/
$sql = "CREATE TABLE IF NOT EXISTS registration (
        id 				INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL, 
		participantId	INT(11)
		raceId	 		INT(11),
		dateTime		TIMESTAMP
        )";
runQuery($sql, "Table:registration", false);

// Create Table:race - amin

    $sql = "CREATE TABLE race ( 
                raceID INT AUTO_INCREMENT PRIMARY KEY,
                raceName VARCHAR(25),
                raceCourse VARCHAR(50))";
    $conn->query($sql);



/***********************************
* POPULATE TABLES USING SAMPLE DATA
***********************************/

// Populate participant table
$participantArray = array (
	
	);

foreach($participantArray as $participant) {
	$sql = "INSERT INTO participant (firstName, lastName, phoneNumber, emailAddress) "
		. "VALUES (NULL, '" . $participant[0] . "', '" 
							. $participant[1] . "', '"
							. $participant[2] . "', '"
							. $participant[3] . "')";
runQuery($sql, "Insert value $participant[1]", false);
}



// Populate race detail table
$raceDetailArray = array (
	
	);

foreach($raceDetailArray as $raceDetail) {
	$sql = "INSERT INTO raceDetail (raceName, location, date, distance, distanceUnits) "
		. "VALUES (NULL, '" . $raceDetail[0] . "', '" 
							. $raceDetail[1] . "', '"
							. $raceDetail[2] . "', '"
							. $raceDetail[3] . "', '"
							. $raceDetail[4] . "')";
runQuery($sql, "Insert value $raceDetail[0]", false);
}

// Populate race result table
$raceResultArray = array (
	
	);

foreach($raceResultArray as $raceResult) {
	$sql = "INSERT INTO raceResult (registrationId, startTime, endTime, place) "
		. "VALUES (NULL, '" . $raceResult[0] . "', '" 
							. $raceResult[1] . "', '"
							. $raceResult[2] . "', '"
							. $raceResult[3] . "')";
runQuery($sql, "Insert value $raceResult[0]", false);
}
 // Populate Table:race

    $raceArray = array (
        array ("1", "TourdeCure", "5k"),
        array ("2", "raceName", "raceCourse"),
        array ("3", "raceName", "raceCourse"),
        array ("4", "raceName", "raceCourse"));

    foreach ($raceArray as $race) {
        $sql = "INSERT INTO race (raceID, raceName, raceCourse)
                VALUES ('"
            . $race[0] . "','"
            . $race[1] . "','"
            . $race[2] . "')";
        $conn->query($sql);
    }





/***********************************
* Function to build registration table
************************************/

function buildRegistration($firstName, $lastName, $raceName, $dateTime) {
	global $conn;
	
	// Determine participant
	$sql = "SELECT id FROM participant 
           WHERE firstName='" . $firstName 
           . "' AND lastName='" . $lastName . "'";
	$result = $conn->query($sql);
	$record = $result->fetch_assoc();
	$participantId = $record['id'];
	
	// Determine race
	$sql = "SELECT id FROM raceDetail WHERE raceName='" . $raceName . "'";
	$result = $conn->query($sql);
	$record = $result->fetch_assoc();
	$raceId = $record['id'];
	
	// Insert the data
	$sql = "INSERT INTO registration (participantId, raceId) 
         VALUES (" . $participantId . ", " . $raceId . ")";
    runQuery($sql, "Insert " . $participantId . " and " . $raceId, false);
}

/*****************
* DISPLAY TABLES
******************/
function displayData($result, $sql) {
	if ($result->num_rows > 0) {
		echo "<table class='table'>";
		// print headings (field names)
		$heading = $result->fetch_assoc( );
		echo "<tr>\n";
		// print field names 
		foreach($heading as $key=>$value){
			echo "<th>" . $key . "</th>\n";
		}
		echo "</tr>\n";
		
		// Print values for the first row
		echo "<tr>\n";
		foreach($heading as $key=>$value){
			if (empty($value)) {
				echo "<td><em>NULL</em></td>\n";
			} elseif (strpos($value, '0')) {
				echo "<td><em>NULL</em></td>\n";
			} else {
				echo "<td>" . $value . "</td>\n";
			}
		}
					
		// output rest of the records
		while($row = $result->fetch_assoc()) {
				//var_dump($row);
				//echo "<br />";
				echo "<tr>\n";
				// print data
				foreach($row as $key=>$value) {
					if (empty($value)) {
						echo "<td><em>NULL</em></td>\n";
					} elseif (strlen($value) > 0 && strlen(trim($value)) == 0) {
						echo "<td><em>NULL</em></td>\n";
					} else {
						echo "<td>" . $value . "</td>\n";
					}
					//var_dump($value);
				}
			
			echo "</tr>\n";
		}
		echo "</table>\n";
	} else {
		echo "<strong>zero results using SQL: </strong>" . $sql;
	}
}

function displayRaceResultsTable( ) {
	global $conn;
	$sql = "SELECT *
				
			FROM registration as reg
			
			INNER JOIN participant AS p on p.id = r.participantId,
			INNER JOIN race AS r on r.id = r.raceId
			";
	$result = $conn->query($sql);
	displayData($result, $sql);
}

displayRaceResultsTable();

    // Table:race

    echo "<h3>Race</h3>";
    $sql = "SELECT * FROM race";
    $result = $conn->query($sql);
    //print_r($result->fetch_assoc());
    //print_r($result->fetch_assoc());

    echo "<table border='1'>";
    echo "<tr>";
    $row = $result->fetch_assoc();
    foreach ($row as $key=>$value) {
        echo "<th>" . $key . "</th>";
    }
    echo "</tr>";
    $result->data_seek(0);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $key=>$value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<br />";

// Close the database
$conn->close();



/* END OF FUNCTIONS */

?>
</article>
<footer>
        <p>Footer content</p>
    </footer>


</div>

</body>
</html>
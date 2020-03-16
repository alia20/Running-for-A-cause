<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- FILENAME.php -  FILE DESCRIPTION
      Written: Amin Ali group 3 
      Revised:  
                
      -->
  	
    <title>TITLE OF WEBPAGE</title>

    <meta name="description" content="ADD DESCRIPTION OF WEBPAGE HERE"/>

    <!-- OPTION META DATA https://www.1and1.com/digitalguide/websites/web-development/the-most-important-meta-tags-and-their-functions/ -->
    <meta name="robots" content="noindex"/>
    <meta name="robots" content="nofollow"/>
	
    <!-- Bootstrap core CSS - UPDATE LIINKS AS NEEDED -->
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <!-- jQuery library 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    -->
    
    <!-- Latest compiled JavaScript 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    -->
	
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
		<div class="container-fluid">
		  <div id="nav" class="row" style="height:100%">
			<div class="col-lg-2">
			  <img src="graphic/finish.jpg" alt="finish line" class="center-block" height="100px">	
			</div>
			<div class="col-lg-10">	
				<nav>
					<ul>
						<li><a href="index.html" style="border: none;background-color: white">
							<img src="graphic/finish.jpg" alt="finish line" height="100px"></a></li>
						<li><a href="index.html">Home</a></li>
						<li><a href="readme.html">Members</a></li>
						<li><a href="template.html">About Us</a></li>
						<li><a href="aminRace.php">Race Registration</a></li>
						<li><a href="ViewResults.php">Race Results</a></li>
						<li><a href="newParticipant.html">Participants Registration</a></li>
						<li><a href="reflection.html">Reflections</a></li>
					</ul>
					<img id="headerImage" src="graphic/run.jpg" alt="run">
				</nav>
			</div>
		  </div>
		</div>

<div class="container-fluid">
  <div id="content" class="row" style="background-color:white;height:10em">
    <div class="col-lg-12">
      <p>
<h1>Race Results</h1>
<?PHP
/* Page to view race results
   Written by Zach Petersen
   10/1/2017
   CSC235  
*/
   
// Set up connection constants
// Using default username and password for AMPPS
define("SERVER_NAME","localhost");
define("DBF_USER_NAME", "root");
define("DBF_PASSWORD", "mysql");
define("DATABASE_NAME", "group3Project");

// Create connection object
$conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Select the database
$conn->select_db(DATABASE_NAME);

function showData()
{
global $conn;

//$sql = "SELECT * FROM raceResults";
// Replace with prepared statement
   /* ===========================================
    *  PREPARED STATEMENT by Zach Petersen
    * =========================================== 
    */
$query = "SELECT * FROM raceResults";
// Set up a prepared statement

$stmt = $conn->stmt_init();
if(!$stmt->prepare($query))
{
  print "Failed to prepare statement\n";
}
else {

 $stmt->execute();
 $result = $stmt->get_result();


if ($result->num_rows > 0) 
{
       echo "<table border='1'>\n";
        // print headings (field names)
          $heading = $result->fetch_assoc( );
          echo "<tr>\n";
          // Print field names as table headings
          foreach($heading as $key=>$value)
          {
             echo "<th>" . $key . "</th>\n";
          }
          echo "</tr>";
          // Print the values for the first row
          echo "<tr>";
          foreach($heading as $key=>$value)
          {
             echo "<td>" . $value . "</td>\n";
          }

        // output rest of the records
        while($row = $result->fetch_assoc()) 
        {
            //print_r($row);
            //echo "<br />";
            echo "<tr>\n";
            // print data
            foreach($row as $key=>$value) 
            {
               echo "<td>" . $value . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    // No results
    } else 
    {
       echo "<strong>zero results using SQL: </strong>" . $sql;
    } 

}
$stmt->close();
}


// Close the database
$conn->close();


?>

      
      
      
      
      
      
      </p>
      <button type-"button" class="center-block">DONATE</button>	
    </div>
  </div>
</div>

<div class="container-fluid">
  <div id="footer" class="row" style="background-color:black;height:10em">
    <div class="col-lg-12">
      <p style="color:white;height:2em">FOOTER GOES HERE</p>
    </div>
  </div>
</div>


</body>
</html>
<?php

   // Telling the server that we will be tracking session variables
   session_start( );
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
       
       <!-- Amin Ali RaceForm.php - Race Form.
         Project: Group Project
         alia20@csp.edu
         Written: 
         Revised: 
         -->
      
      <meta charset="utf-8">
      <meta name="description" content="Utelizing Bootstrap">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
      <link rel="stylesheet" type="text/css" href="style.css">
      <?PHP
       // Link to external library file
         //echo "PATH (Current Working Directory): " . getcwd( ) . "lib.php" . "<br />";
            require_once(getcwd( ) . "/lip.php"); 
         // Server Sniffer based on available connection:
         
             $whitelist = array('127.0.0.1', '::1');
         
             if(in_array($_SERVER['REMOTE_ADDR'], $whitelist))

            {
                 // Set up connection constants
                 // Using default username and password for AMPPS
                 define("SERVER_NAME","localhost");
                 define("DBF_USER", "root");
                 define("DBF_PASSWORD", "mysql");
                 define("DATABASE_NAME", "group3Project");
             }
         
             else
            {
                // credentials for http://sspgroup3.byethost9.com/
                define('SERVER_NAME', 'sql204.byethost9.com');
                define('DBF_USER', 'b9_20707120');
                define('DBF_PASSWORD', 'zaagOnEm');
                define('DATABASE_NAME', 'b9_20707120_RaceRegistration');
            }  
          // Truncate Race Table on load to clear data.
       /* $sql = "TRUNCATE TABLE RACE" ;
        runQuery($sql, "TRUNCATE RACE TABLE " , true);
     */
    // Set up constants for each of the choices in the drop down.
    define('AVAILABLE_RACE', '0');
	define('CLOSED_RACE', '1');
    define('FEATURE_RACE', '2');
	
	/**
	** PREPARED STATEMENT
	** Insert record to race table in the database
	**/ 	
	function prepareStatement() {
	//set database connection
	$con = new mysqli(SERVER_NAME, DBF_USER, DBF_PASSWORD, DATABASE_NAME);
	//prepare sql statement
	$myquery = mysqli_query($con, 'PREPARE statement FROM "INSERT INTO race
     VALUES(?,?,?)"')  or die(mysqli_error($con) . 'nooo');
	//set value to the columns
     $myquery = mysqli_query($con, 'SET @raceID = "10110", @raceName = "Testing", @raceCource = "60 K"
     ')  or die(mysqli_error($con));
	  //execute statement
      $myquery = mysqli_query($con, "EXECUTE statement USING @id, @uid, @fname") or die(mysqli_error($con));
	 //deallocate prepare statement
      $myquery = mysqli_query($con, "DEALLOCATE PREPARE statement")  or die(mysqli_error($con));
	   
		}
	
	/** END prepare statement **/
		
		
    $self = $_SERVER['PHP_SELF'];   
    //Define Array to be used below.
    $tableFormat = AVAILABLE_RACE;
    
    $sql = "SELECT raceName, raceCourse FROM race";
	// display the list of available races based on the selection
	if(isset($_POST['lstDisplay'])) {
		// Save item that was selected by the user
		$selection = $_POST['lstDisplay'];
         
       // Create connection object
         $conn = new mysqli(SERVER_NAME, DBF_USER, DBF_PASSWORD, DATABASE_NAME);
     
         // Check connection
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
    
         // Select the database
         $conn->select_db(DATABASE_NAME);
   
       //use of switch to control selection from drop down.
		switch($selection) {
			case "availableRace": 
                {
				$tableFormat=AVAILABLE_RACE;
                $sql= "SELECT raceName, raceCourse FROM race";
				break;
                }
            case "closedRace":
                {
            $tableFormat = CLOSED_RACE;
            $sql ="SELECT raceName, raceCourse from race where raceID > 3";
            break;
                }
                case "featureRace":
                {
            $tableFormat = FEATURE_RACE;
            $sql ="SELECT raceName, raceCourse from race where raceID > 6";
            break;
                }
	
			default: echo $selection .
                ' is not a valid choice from the list of displays<br />';
    
        
		}// end of switch( )
       
	 } // end of if(isset( ))
       
	//else // are you a first time visitor?
	//{
	//	echo '<h1>Welcome FIRST TIME to Race Form</h1>';
	//} // end of if new else returning
       
       if(array_key_exists('hidSubmitFlag', $_POST))
       {
          // echo "<h2>Welcome back!</h2>";
        $submitFlag = $_POST['hidSubmitFlag'];
        $raceEditArray = unserialize(urldecode($_SESSION['serializedArray']));
          switch($submitFlag)
         {
                 
         case "01": addRecord( );
         break;
              
         case "99": deleteRecord( );
         break;
         
         default: displayRaceForm($raceEditArray);
        
         }
       }
         else
         {
        // echo "<h2>Welcome to race edit form Page</h2>";
         // First time visitor? If so, create the array
         // Create the race edit array
         $raceEditArray = array( );
         $raceEditArray[0][1] =" Race";
         $raceEditArray[0][2] ="10 k";
    
         // Save this array as a serialized session variable
         $_SESSION['serializedArray'] = urlencode(serialize($raceEditArray));
         
         }
 
         ?>
      <title>Race Form</title>
   </head>
   <body>
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
<div class="cage"  align="center">
<div id="frame">
<form name="frmDBF"
		action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>'
		method="POST">
	<strong>What information would you like to view?</strong>
	<!-- Use JavaScript to automatically submit the selection -->
	<select name="lstDisplay" onchange="this.form.submit()">
		<option value="null">Select an item</option>
        <option value="availableRace">Availabe Races</option>
		<option value="closedRace">Closed Races</option>
		<option value="featureRace">Feature Races</option>
	</select>

	<!-- set up alternative button in case JavaScript is not active -->
	<noscript>
		&nbsp; &nbsp; &nbsp;
		<input type="submit" name="btnSubmit" value="View the list" />
		<br /><br />
	</noscript>

	<!-- Use a hidden field to tell server if return visitor -->
	<input type="hidden" name="hidIsReturning" value="true" />
</form>
    <br />
<?PHP
      displayData();
?>
    <br />
      <p>
         Please enter your information in the below form:<br />
         <?php 
            displayRaceForm( ); 
             
   // echo 'DEBUG: ';
     //     print_r($_POST);
            ?>
      </p>

      <form action="<?php $self ?>"
         method="POST"
         name="frmAdd">
         <fieldset id="fieldsetAdd">
            <legend>Add Race information.</legend>
            <label for="txtName">Name:</label>
            <input type="text" name="txtraceName" id="txtraceName" value="Tour DeFrance" />&nbsp;&nbsp;
            <input type="text" name="txtraceCourse" id="txtraceCourse" value="50 K" />
            <br /><br />
            <!-- This field is used to determine if the page has been viewed already Code 01 = Add
               -->
            <input type='hidden' name='hidSubmitFlag' id='hidSubmitFlag' value='01' />
            <input name="btnSubmit" type="submit" value="Add this race information" />
         </fieldset>
      </form>
      <br /> <br />
      <form action="<?php $self ?>"
         method="POST"
         name="frmDelete">
         <fieldset id="fieldsetDelete">
            <legend>Select the record to delete:</legend>
            <select name="lstItem" size="1">
            <?php
               // Populate the list box using data from the array
               foreach($raceEditArray as $index => $lstRecord)
               {
               // Make the value of the index and the text display the description from the array
               // The index will be used by deleteRecord( )
               echo "<option value='" . $index . "'>" . $lstRecord[0]  . "</option>\n";
               }
               ?>
            </select>
            <!-- This field is used to determine if the page has been viewed already Code 99 = Delete
               -->
            <input type='hidden' name='hidSubmitFlag' id='hidSubmitFlag' value='99' />
            <br /><br />
            <input name="btnSubmit" type="submit" value="Delete" />
         </fieldset>
      </form>
      <br /> <br />
</div>
       
<br />
</div>
        
            <!-- Link to the local CSS style sheet -->
     <!--    <link href="style.css" rel="stylesheet" /> -->
     <!-- (1) jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<!-- (2) Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- (3) Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<!-- (4) Bring in local JavaScript functions -->
<script src="script.js"></script>
<!-- (5) Connect to local CSS for this site -->
<link rel="stylesheet" type="text/css" href="style.css">
   </body>
</html>
<?PHP
 
   /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * displayResult( ) - Execute a query and display the result
   *    Parameters:  $rs -  result set to display as 2D array
   *                 $sql - SQL string used to display an error msg
   * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
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
        // Create connection object
         $conn = new mysqli(SERVER_NAME, DBF_USER, DBF_PASSWORD, DATABASE_NAME);
       
         // Check connection
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
    
         // Select the database
         $conn->select_db(DATABASE_NAME);
        /* =========================================
         Functions are alphabetical
         ========================================= */
         function addRecord( )
         {
        
         global $raceEditArray;
         // Add the new information into the array
         // items stacked for readability
         $raceEditArray[ ] = array(
         $_POST['txtraceName'],
         $_POST['txtraceCourse']
         );
     
         // The sort will be on the first column so we will use this to re-order the displays
         sort($raceEditArray);
         // Save the updated array in its session variable
         $_SESSION['serializedArray'] = urlencode(serialize($raceEditArray));
         
        foreach ($raceEditArray as $editRace)
         {
          $sql = "INSERT INTO race (raceID, raceName, raceCourse)"
              . "VALUES ('" . null . "','"
              . $_POST['txtraceName'] . "', '"
              . $_POST['txtraceCourse'] . "')";
            runQuery($sql, "Record inserted for: " . $_POST['txtraceName'], false);
         }//end of foreach
         } // end of addRecord( )
        
        function deleteRecord( )
         {
         global $raceEditArray;
         global $deleteMe;
         // Get the selected index from the lstItem
         $deleteMe = $_POST['lstItem'];
         // Remove the selected index from the array
         unset($raceEditArray[$deleteMe]);
         // Save the updated array in its session variable
         $_SESSION['serializedArray'] = urlencode(serialize($raceEditArray));
         echo "<h2>Record deleted</h2>";
         } // end of deleteRecord( )

        function displayRaceForm( )
         {
         global $raceEditArray; 
         echo ("<div class='row'>");
         echo ("<div class='center-block col-xs-8'>");
         echo ("<h2 id='places'>Bike Race Edit Form</h2>");         
         echo ("<div class='bs-example'>");
         echo ("<div class='table-responsive'>");
         echo("<table class= 'table table-bordered table-striped table-hover>'");
         // display the header
         echo "<tr>";
         echo "<th>Race Name</th>";
         echo "<th>Race Course</th>";
         echo "</tr>";
         
         // Walk through each record or row
         foreach($raceEditArray as $record)
         {
         echo "<tr>";
         // for each column in the row
         foreach($record as $value)
         {
         echo "<td>$value</td>";
         }
         echo "</tr>";
         }
         // stop the table
         echo "</table>";
         } // end of displayRaceForm( )


    function displayData( ) {
		global $sql;
		global $tableFormat;
        $db = new mysqli(SERVER_NAME, DBF_USER, DBF_PASSWORD, DATABASE_NAME);
		if($db->connect_errno > 0){
		 die('Unable to connect to database [' . $db->connect_error . ']');
		}

		// Get the data from the database using SQL
		if(!$result = $db->query($sql)){
		 die('There was an error running the query [' . $db->error . ']');
		}

        // Display the records in a table
        switch($tableFormat) {
        case AVAILABLE_RACE:
    {
        echo ("<div class='row'>");
        echo ("<div class='center-block col-xs-8'>");        
        echo ("<div class='bs-example'>");
        echo ("<div class='table-responsive'>");
        echo '<h2>List of Races </h2>';
        echo("<table class= 'table table-bordered table-striped table-hover>'");
        echo '<tr>';
        echo '<th>Race Name</th>';
        echo '<th>Race Course</th>';
        echo '</tr>';
        while($row = $result->fetch_assoc( ))
        {
            echo '<tr>';
            echo '<td>' . $row['raceName'] . '</td>';
            echo '<td>' . $row['raceCourse'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    }
            break;

     case CLOSED_RACE:
    {
        echo ("<div class='row'>");
        echo ("<div class='center-block col-xs-8'>");        
        echo ("<div class='bs-example'>");
        echo ("<div class='table-responsive'>");
        echo '<h2>List of Races </h2>';
        echo("<table class= 'table table-bordered table-striped table-hover>'");
        echo '<tr>';
        echo '<th>Race Name</th>';
        echo '<th>Race Course</th>';
        echo '</tr>';
        while($row = $result->fetch_assoc( ))
        {
            echo '<tr>';
            echo '<td>' . $row['raceName'] . '</td>';
            echo '<td>' . $row['raceCourse'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    }
            break;
     case FEATURE_RACE:
    {
        echo ("<div class='row'>");
        echo ("<div class='center-block col-xs-8'>");        
        echo ("<div class='bs-example'>");
        echo ("<div class='table-responsive'>");
        echo '<h2>List of Races </h2>';
        echo("<table class= 'table table-bordered table-striped table-hover>'");
        echo '<tr>';
        echo '<th>Race Name</th>';
        echo '<th>Race Course</th>';
        echo '</tr>';
        while($row = $result->fetch_assoc( ))
        {
            echo '<tr>';
            echo '<td>' . $row['raceName'] . '</td>';
            echo '<td>' . $row['raceCourse'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    }
            break;
	default:
	echo $tableFormat . ' is not a valid table format.<br />';
} // end of switch( )

		// Close the database object
		$db->close;
	}


/********************************************************************************/
   function displayResult($result, $sql) 
   {
 
   if ($result->num_rows > 0) {
     echo "<table border='1'>\n";
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
          foreach($row as $key=>$value) {
             echo "<td>" . $value . "</td>\n";
          }
          echo "</tr>\n";
      }
      echo "</table>\n";
   } else {
      echo "<strong>zero results using SQL: </strong>" . $sql;
   }
   } // end of displayResult( )
   
   /***************************************************
   * Display the tables
   ***************************************************/
   // Table:FourTableJoin
   function displayRace( ) {
   global $conn;
   $sql = "select raceName, raceCourse from race
   ";
   $result = $conn->query($sql);
   displayResult($result, $sql);
   
   } // end of displayFourTableJoin
   
       
   /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * runQuery( ) - Execute a query and display message
   * Parameters:  $sql - SQL String to be executed.
   *              $msg - Text of message to display on success or error
   *              $echoSuccess - boolean True=Display message on success
   * If $echoSuccess true: $msg successful. * Error Msg Format: $msg using SQL: $sql.
   * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
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
   } // end of runQuery( )
   
   ?>
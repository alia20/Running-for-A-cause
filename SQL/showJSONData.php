<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Amin Ali .
         Project: Team Project
         alia20@csp.edu
         Written: 
         Revised: 
         -->
    <title>TITLE OF WEBPAGE</title>

    <meta name="robots" content="noindex"/>
    <meta name="robots" content="nofollow"/>
    
    <script type="text/javascript">
        function getJSON(fileName) {
            console.log("here");
            // Perform an AJAX get request
            var request = new XMLHttpRequest();
            // Create a GET request
            request.open("GET", fileName, true);
            // Add content-type header
            request.setRequestHeader("Content-type", "application/json", true);

            request.onreadystatechange = function() {

                // if request is complete and request status is 200
                if (this.readyState == 4 && this.status == 200) {
                    var jsonData = JSON.parse(request.responseText);

                    // If we fetched some rows
                    if (jsonData.length > 0) {
                        // Create html to show in table
                        var htmlText = "<tr>" +
                        "<th>First Name</th>" +
                        "<th>Last Name</th>" +
                        "<th>Phone Number</th>" +
                        "<th>Email Address</th>" +
                        "<th>Registration Date</th>" +
                        "<th>Race Name</th>" +
                        "<th>Location</th>" +
                        "<th>Race Date</th>" +
                        "<th>Distance</th>" +
                        "</tr>";

                        // Iterate over each record in json data
                        for (var item in jsonData) {
                            var race = jsonData[item];
                            htmlText += "<tr>";


                            if (race.FirstName == null) {
                                htmlText += "<td>&nbsp;</td>";
                            } else {
                                htmlText += "<td>" + race.FirstName + "</td>";
                            }

                            if (race.LastName == null) {
                                htmlText += "<td>&nbsp;</td>";
                            } else {
                                htmlText += "<td>" + race.LastName + "</td>";
                            }

                            if (race.PhoneNumber == null) {
                                htmlText += "<td>&nbsp;</td>";
                            } else {
                                htmlText += "<td>" + race.PhoneNumber + "</td>";
                            }

                            if (race.EmailAddress == null) {
                                htmlText += "<td>&nbsp;</td>";
                            } else {
                                htmlText += "<td>" + race.EmailAddress + "</td>";
                            }


                            if (race.RegistrationDate == null) {
                                htmlText += "<td>&nbsp;</td>";
                            } else {
                                htmlText += "<td>" + race.RegistrationDate + "</td>";
                            }


                            if (race.RaceName == null) {
                                htmlText += "<td>&nbsp;</td>";
                            } else {
                                htmlText += "<td>" + race.RaceName + "</td>";
                            }

                            if (race.Location == null) {
                                htmlText += "<td>&nbsp;</td>";
                            } else {
                                htmlText += "<td>" + race.Location + "</td>";
                            }

                            if (race.RaceDate == null) {
                                htmlText += "<td>&nbsp;</td>";
                            } else {
                                htmlText += "<td>" + race.RaceDate + "</td>";
                            }

                            if (race.Distance == null) {
                                htmlText += "<td>&nbsp;</td>";
                            } else {
                                htmlText += "<td>" + race.Distance + "</td>";
                            }   
                        } 
                        // Append html to element with id tblResult
                        document.getElementById("tblResult").innerHTML = htmlText;
                    } else {
                        // Append html to element with id tblResult
                        document.getElementById("tblResult").innerHTML = "<tr><td>No records found</td></tr>";
                    }
                }
                
            }
            request.send();
        }
        window.onload = function() {
            getJSON('queryResults.json');
        }
    </script>
</head>

<body>

<div class="container-fluid">
  <div id="content" class="row" style="background-color:white;height:10em">
    <div class="col-lg-12">
      <p>
        <table id="tblResult" cellspacing="0" cellpadding="10" border="1">
            <tr><td>No records found</td></tr>
        </table>
      </p>
    </div>
  </div>
</div>
</body>
</html>
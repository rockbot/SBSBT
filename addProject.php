<?php
/* ******************************************************
    addProject.php
    Tracks projects and their status
    
    Part of the Super Basic Small Business Tracker
    Created by Raquel Vélez
   ****************************************************** */
  include "globals.php";

  $con = OpenServerConnection();
  
  date_default_timezone_set('America/New_York');
  $timeAdded = date('Y-m-d H:i:s');

  $projectName = mysql_real_escape_string($_GET['projectName']);
  $clientID = mysql_real_escape_string($_GET['client']);
  $status = mysql_real_escape_string($_GET['status']);

  boom($projectName . " " . $clientID . " " . $status);

  mysql_select_db($db_name, $con);

  mysql_query("INSERT INTO projects(project_name, client_id, current_status, time_added) 
              VALUES('$projectName', $clientID, '$status', '$timeAdded')");
  
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';
  
  mysql_close($con);


?>

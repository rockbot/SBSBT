<?php
/* ******************************************************
    timesheet.php
    Tracks number of hours worked on specific projects
    by specific employees
    
    Part of the Super Basic Small Business Tracker
    Created by Raquel Vélez
   ****************************************************** */
  include "globals.php";

  $con = OpenServerConnection();
  
  $empid = mysql_real_escape_string($_POST['eid']);
  $projid = mysql_real_escape_string($_POST['pid']);
  $month = mysql_real_escape_string($_POST['month']);
  $day = mysql_real_escape_string($_POST['day']);
  $year = mysql_real_escape_string($_POST['year']);
  $numHrs = mysql_real_escape_string($_POST['numHrs']);
  $taskDesc = mysql_real_escape_string($_POST['taskDesc']);
  
  mysql_select_db($db_name, $con);

  date_default_timezone_set('America/New_York');
  $timeAdded = date('Y-m-d H:i:s');

//  echo $taskDesc . " " . $timeAdded;

  $query = "INSERT INTO hours (employee_id, project_id, task_date, num_hours, task_description, time_added) 
  VALUES($empid, $projid, '$year-$month-$day', $numHrs, '$taskDesc', '$timeAdded')";
  
  $result = mysql_query($query) or die("error: " . mysql_error());
  
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';

  mysql_close($con);

?>

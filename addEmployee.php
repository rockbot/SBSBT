<?php
/* ******************************************************
    addEmployee.php
    Tracks employees
    
    Part of the Super Basic Small Business Tracker
    Created by Raquel Vélez
   ****************************************************** */
  include "globals.php";

  $con = OpenServerConnection();
  
  $fname = mysql_real_escape_string($_GET['fName']);
  $lname = mysql_real_escape_string($_GET['lName']);

  date_default_timezone_set('America/New_York');
  $timeAdded = date('Y-m-d H:i:s');

  mysql_select_db($db_name, $con);

  mysql_query("insert into employees (first_name, last_name, time_added) values('$fname', '$lname', '$timeAdded')");
  
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';
  
  mysql_close($con);

?>
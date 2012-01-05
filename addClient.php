<?php
/* ******************************************************
    addClient.php
    Tracks clients and their contact information
    
    Part of the Super Basic Small Business Tracker
    Created by Raquel Vélez
   ****************************************************** */
  include "globals.php";

  $con = OpenServerConnection();
  
  date_default_timezone_set('America/New_York');
  $timeAdded = date('Y-m-d H:i:s');
  
  $client = mysql_real_escape_string($_GET['client']);
  $contact = mysql_real_escape_string($_GET['contact']);
  $phone = mysql_real_escape_string($_GET['phone']);
  $street = mysql_real_escape_string($_GET['street']);
  $city = mysql_real_escape_string($_GET['city']);
  $state = mysql_real_escape_string($_GET['state']);
  $zip = mysql_real_escape_string($_GET['zip']);

  mysql_select_db($db_name, $con);

  mysql_query("INSERT INTO clients(client_name, contact_name, phone, street, city, state, zip, time_added)
               VALUES('$client', '$contact', '$phone', '$street', '$city', '$state', '$zip', '$timeAdded')");
  
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';
  
  mysql_close($con);


?>

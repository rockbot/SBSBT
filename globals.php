<?php
/* ******************************************************
    globals.php
    A convenient place to store global variables and 
    functions
    
    Part of the Super Basic Small Business Tracker
    Created by Raquel Vélez
   ****************************************************** */

  // ----- VARIABLES -----

  $db_name = 'rdv';
  
  $table_names = array("employees", "projects", "hours", "customers");
  $table_headings = array(
    "employees" => array(
      "first_name", 
      "last_name", 
      "time_added"
    ), 
    "projects" => array(
      "project_name", 
      "customer_id", 
      "current_status",
      "time_added"
    ), 
    "hours" => array(
      "employee_id", 
      "project_id", 
      "date", 
      "num_hours", 
      "task_description", 
      "time_added"
    ), 
    "customers" => array(
      "customer", 
      "contact", 
      "phone", 
      "street", 
      "city", 
      "state", 
      "zip"
    )
  );

  // ----- FUNCTIONS -----
  function OpenServerConnection()
  {
    $con = mysql_connect('localhost', root, root);
    if (!$con)
    {
      die('Could not connect: ' . mysql_error());
    }
    return $con;
  }

  function boom($word)
  {
    echo "boom! " . $word;
  }

?>

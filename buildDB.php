<?php
/* ******************************************************
    buildDB.php
    Creates the database and its tables, if needed
    
    Part of the Super Basic Small Business Tracker
    Created by Raquel Vélez
   ****************************************************** */

/* ******************************************************
    We are going to assume that, since this is just a 
    super basic small business tracking system, the 
    database is already set up and the tables only need 
    to be set up once.
   ****************************************************** */  
   
  function BuildDBandTables($db)
  {
    $con = OpenServerConnection();
  
    // create the database 
    if (!mysql_query("CREATE DATABASE IF NOT EXISTS $db",$con))
    {
      echo "Error creating database: " . mysql_error();
    }
    
    // create each table
    $result = mysql_select_db($db, $con);
    if (!$result)
    {
      die('Cannot connect to DB: ' . mysql_error());
    }

    $emp = "CREATE TABLE IF NOT EXISTS employees
    (
      id int(11) NOT NULL AUTO_INCREMENT,
      first_name varchar(100),
      last_name varchar(100),
      time_added date,
      time_deleted date,
      PRIMARY KEY(id)
    )";
    
    $proj = "CREATE TABLE IF NOT EXISTS projects
    (
      id int(11) NOT NULL AUTO_INCREMENT,
      project_name varchar(100),
      client_id int(11),
      current_status varchar(100),
      time_added date,
      time_deleted date,
      PRIMARY KEY(id)
    )";
    
    $hours = "CREATE TABLE IF NOT EXISTS hours
    (
      id int(11) NOT NULL AUTO_INCREMENT,
      employee_id int(11),
      project_id int(11),
      task_date date,
      num_hours float(11,2),
      task_description varchar(255),
      time_added date,
      time_deleted date,
      PRIMARY KEY(id)
    )";
    
    $cust = "CREATE TABLE IF NOT EXISTS clients
    (
      id int(11) NOT NULL AUTO_INCREMENT,
      client_name varchar(255),
      contact_name varchar(255),
      phone varchar(100),
      street varchar(255),
      city varchar(255),
      state varchar(2),
      zip char(10),
      time_added date,
      time_deleted date,
      PRIMARY KEY(id)
    )";  

  
    // execute each query
    mysql_query($emp, $con);
    mysql_query($proj, $con);
    mysql_query($hours, $con);
    mysql_query($cust, $con);
    
    // close the connection to the server
    mysql_close($con);
  }

?>
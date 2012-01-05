<!DOCTYPE html>

<html>
  <header>
    <title>Super Basic Small Business Tracker</title>
  </header>

  <body>
    
    <?php
    /* ******************************************************
        start.php
        Track employees, client contact information, project
        statuses, and timesheets
        
        Part of the Super Basic Small Business Tracker
        Created by Raquel Vélez
       ****************************************************** */
    
      // ----- INCLUDES ------
      include "globals.php";
      include "buildDB.php";
    
      // ----- BEGIN CODE -----
      
      // Check to see if the db exists - if so, SELECT it. 
      // If not, set up the DB AND all of its tables. 
      BuildDBANDTables($db_name); 
      
      $con = OpenServerConnection();
      
      if (!mysql_SELECT_db($db_name, $con))
      {
        die('Cannot connect to DB: ' . mysql_error());
      }
    
      ?>
      
      <h1>Super Basic Small Business Tracker</h1>
      <h2>For Imaginative Company RDV</h2>
      
      <?php
      
      // **** EMPLOYEES ****
      $result = mysql_query("SELECT * FROM employees WHERE time_deleted is NULL");
    
      echo "<hr/><h3>EMPLOYEES</h3>";
      echo "<table border='1'>
      <tr>
      <th>Employee ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      </tr>";
    
      while($row = mysql_fetch_array($result))
      {
        echo "<tr>";
        echo "<td> <a href='editEmployee.php?id=$row[id]'>" . $row[id] . "</a> </td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "<form action='start.php' method='get'>";
      echo "<br/><input type='submit' name='addEmployee' value='Add Employee'/>";
      echo "</form>";
      
      if (strcmp($_GET['addEmployee'], 'Add Employee') == 0)
      {
        echo "<form action='addEmployee.php' method='get'>";
        echo "First Name: <input type='text' name='fName'/>";
        echo " Last Name: <input type='text' name='lName'/>";
        echo "<input type='submit' name='employeeSubmit' value='Submit'/>";
        echo "</form>";
      }
      
      // **** CLIENTS ****
      $result = mysql_query("SELECT * FROM clients WHERE time_deleted is NULL");
      
      echo "<hr/><h3>CLIENTS</h3>";
      echo "<table border='1'>
      <tr>
      <th>Client ID</th>
      <th>Client Name</th>
      <th>Contact Name</th>
      <th>Contact Phone Number</th>
      <th>Street</th>
      <th>City</th>
      <th>State</th>
      <th>Zip</th>
      </tr>";
      
      while($row = mysql_fetch_array($result))
      {
        echo "<tr>";
        echo "<td> <a href='editClient.php?id=$row[id]'>" . $row[id] . "</a> </td>";
        echo "<td>" . $row[client_name] . "</td>";
        echo "<td>" . $row[contact_name] . "</td>";
        echo "<td>" . $row[phone] . "</td>";
        echo "<td>" . $row[street] . "</td>";
        echo "<td>" . $row[city] . "</td>";
        echo "<td>" . $row[state] . "</td>";
        echo "<td>" . $row[zip] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "<form action='start.php' method='get'>";
      echo "<br/><input type='submit' name='addClient' value='Add Client'/>";
      echo "</form>";
      
      if (strcmp($_GET['addClient'], 'Add Client') == 0)
      {
        echo "<form action='addClient.php' method='get'>";
        echo "Client Name: <input type='text' name='client'/> <br/>";
        echo "Contact Name: <input type='text' name='contact'/> <br/>";
        echo "Contact Phone: <input type='text' name='phone'/> <br/>";
        echo "Street: <input type='text' name='street' size='50'/> <br/>";
        echo "City: <input type='text' name='city'/>";
        echo "State: <input type='text' name='state' size='2' maxlength='2'/>";
        echo "Zip: <input type='text' name='zip' size='10'/>";
        echo "<input type='submit' name = 'clientSubmit' value = 'Submit'/>";
        echo "</form>";
      }
    
      // **** PROJECTS ****
      $result = mysql_query("SELECT projects.id, projects.project_name, projects.current_status, clients.client_name FROM projects, clients WHERE projects.time_deleted is NULL AND projects.client_id = clients.id");
      
      echo "<hr/><h3>PROJECTS</h3>";
      echo "<table border='1'>
      <tr>
      <th>Project ID</th>
      <th>Project</th>
      <th>Client</th>
      <th>Current Status</th>
      </tr>";
      
      while($row = mysql_fetch_array($result))
      {
        echo "<tr>";
        echo "<td> <a href='editProject.php?id=$row[id]'>" . $row[id] . "</a> </td>";
        echo "<td>" . $row[project_name] . "</td>";
        echo "<td>" . $row[client_name] . "</td>";
        echo "<td>" . $row[current_status] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "<form action='start.php' method='get'>";
      echo "<br/><input type='submit' name='addProject' value='Add Project'/>";
      echo "</form>";
      
      if (strcmp($_GET['addProject'], 'Add Project') == 0)
      {
        echo "<form action='addProject.php' method='get'>";
        echo "Project Name: <input type='text' name='projectName'/> <br/>";
        echo "Client: <select name='client'>";
        $result = mysql_query("SELECT id, client_name FROM clients WHERE time_deleted is NULL");
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
        {
          echo "<option value='$row[id]'>$row[client_name]</option>";
        }
        echo "</select> <br/>";
        echo "Current Status: <select name='status'>
                              <option value='Starting Up'>Starting Up</option>
                              <option value='In Progress'>In Progress</option>
                              <option value='On Hold'>On Hold</option>
                              <option value='Completed'>Completed</option>
                              <option value='Abandoned'>Abandoned</option>
                              </select> <br/>";
        echo "<input type='submit' name = 'projectSubmit' value = 'Submit'/>";
        echo "</form>";
      }
      
      // **** TIMESHEET ****
      
      // Grab information FROM the database for the timesheet tracker
      $time_data = mysql_query("SELECT employees.first_name, employees.last_name, projects.project_name, hours.task_date, hours.task_description, hours.num_hours FROM employees, projects, hours WHERE hours.project_id = projects.id AND hours.employee_id = employees.id");
      
      // Build the table headings
      echo "<hr/><h3>TIMESHEET</h3>";
      echo "<table border='1'>
        <tr>
          <th>Employee Name</th>
          <th>Project Name</th>
          <th>Task Date</th>
          <th>Task Description</th>
          <th>Number of Hours</th>
        </tr>";
      
      // Populate the timesheet
      while($row = mysql_fetch_array($time_data))
      {
        echo "<tr>";
        echo "<td>" . $row[first_name] . " " . $row[last_name] . "</td>";
        echo "<td>" . $row[project_name] . "</td>";
        echo "<td>" . $row[task_date] . "</td>";
        echo "<td>" . $row[task_description] . "</td>";
        echo "<td>" . $row[num_hours] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "<br/>";
    
    ?>
    
      <hr/>
      <h3>ADD TO TIMESHEET</h3>
      <form action="timesheet.php" method="post">
      Employee: <SELECT name="eid" /> 
      <?php
      $result = mysql_query("SELECT id, first_name, last_name FROM employees WHERE time_deleted IS NULL");
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      {
        echo "<option value='$row[id]'>$row[first_name] $row[last_name]</option>";
      }
      ?>
      </SELECT>
      
      Project: <SELECT name="pid">
      <?php
      $result = mysql_query("SELECT id, project_name FROM projects WHERE time_deleted IS NULL");
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        echo "<option value='$row[id]'>$row[project_name]</option>";
      }
      ?>
      </SELECT>
      <br/>
      
      Date: <SELECT name="month">
      <?php
      date_default_timezone_set('America/New_York');
      for($month = 1; $month <= 12; ++$month)
      {
        echo "<option value='$month'";
        if ($month == date('n')) echo " SELECTed";
        echo ">" . date("F", mktime(0, 0, 0, $month+1, 0, 0, 0)) . "</option>";
        
      }
      ?>
      </SELECT>
      <SELECT name="day">
      <?php
      date_default_timezone_set('America/New_York');
      for($day = 1; $day <= 31; ++$day)
      {
        echo "<option value='$day'";
        if ($day == date('j')) echo " SELECTed";
        echo ">$day</option>";
      }
      ?>
      </SELECT>
      <SELECT name="year"> 
      <?php
      for($year = 2011; $year <= date('Y'); ++$year)
      {
        echo "<option value='$year'>$year</option>";
      }
      ?>
      </SELECT>
      <br/>
      Task Description: <input type="text" name="taskDesc" /> <br/>
      Number of Hours: <input type="text" name="numHrs" /> <br/>
      <input type="submit" />
      </form>
      <br/>
    
    <?php
      
      mysql_close($con);
    
    ?>

  </body>
</html>
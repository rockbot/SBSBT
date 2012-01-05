<!DOCTYPE html>

<html>
  <header>
    <title>Edit Employee</title>
  </header>
  
  <body>

    <?php
    /* ******************************************************
        editEmployee.php
        Change or "delete" an employee record
        
        Part of the Super Basic Small Business Tracker
        Created by Raquel Vélez
       ****************************************************** */
      include "globals.php";
    
      $id = $_GET['id'];
    
      $con = OpenServerConnection();
      
      mysql_select_db($db_name, $con);
    
      $result = mysql_query("SELECT id, first_name, last_name FROM employees WHERE id = $id AND time_deleted IS NULL");
      $row = mysql_fetch_array($result);
    
      echo "<h3>Edit Employee</h3>";
      echo "<form action='editEmployee.php' method='get'>";
      echo "First Name: <input type=text name=fname value='$row[first_name]' />";
      echo " Last Name: <input type=text name=lname value='$row[last_name]' /> <br/><br/>";
      echo "<input type='hidden' name='id' value='$row[id]'/>";
      echo "<input type='submit' name='editConfirm' value='Confirm'/>";
      echo "<input type='submit' name='delete' value='Delete' onclick='return confirm(&quot;Are you sure?&quot;)'/>";
      echo "</form>";
      
      if (strcmp($_GET['editConfirm'], 'Confirm') == 0)
      {
        $fname = mysql_real_escape_string($_GET[fname]);
        $lname = mysql_real_escape_string($_GET[lname]);
        mysql_query("UPDATE employees SET first_name = '$fname', last_name = '$lname' WHERE id = $id");
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';
      }
      
      if (strcmp($_GET['delete'], 'Delete') == 0)
      {
        date_default_timezone_set('America/New_York');
        $timeDeleted = date('Y-m-d H:i:s');  
        mysql_query("UPDATE employees SET time_deleted = '$timeDeleted' WHERE id = $id");
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';
      }
      
      mysql_close($con);
    
    ?>

  </body>
</html>
<!DOCTYPE html>

<html>
  <header>
    <title>Edit Project</title>
  </header>
  
  <body>
  
    <?php
    /* ******************************************************
        editProject.php
        Changes AND "removes" project records
        
        Part of the Super Basic Small Business Tracker
        Created by Raquel Vélez
       ****************************************************** */
      include "globals.php";
    
      $con = OpenServerConnection();
    
      $id = $_GET['id'];
    
      mysql_select_db($db_name, $con);
    
      $result = mysql_query("SELECT id, project_name, client_id, current_status FROM projects WHERE id = $id AND time_deleted IS NULL");
      $row = mysql_fetch_array($result);
    
      echo "<h3>Edit Project</h3>";
      echo "<form action='editProject.php' method='get'>";
      echo "Project Name: <input type=text name='project' value='$row[project_name]' /> <br/>";
      echo "Client: <select name='client'>";
      $custResult = mysql_query("SELECT id, client_name FROM clients WHERE time_deleted IS NULL");
      while ($custRow = mysql_fetch_array($custResult, MYSQL_ASSOC)) 
      {
        echo "<option value='$custRow[id]'";
        if ($row[client_id] == $custRow[id]) echo " selected";
        echo ">$custRow[client_name]</option>";
      }
      echo "</select> <br/>";
      
      $statusArray = array(1 => 'Starting Up', 2 => 'In Progress', 3 => 'On Hold', 
                           4 => 'Completed', 5 => 'Abandoned');
      echo "Current Status: <select name='status'>";
      foreach ($statusArray as $status)
      {
        echo "<option value='$status'"; 
        if(strcmp($row[current_status], $status) == 0) echo " selected";
        echo ">$status</option>";
      }
      echo "</select> <br/>";
      echo "<input type='hidden' name='id' value='$row[id]'/>";
      echo "<input type='submit' name='editConfirm' value='Confirm'/>";
      echo "<input type='submit' name='delete' value='Delete' onclick='return confirm(&quot;Are you sure?&quot;)'/>";
      echo "</form>";
      
      if (strcmp($_GET['editConfirm'], 'Confirm') == 0)
      {
        $project = mysql_real_escape_string($_GET['project']);
        $custID = mysql_real_escape_string($_GET['client']);
        $status = mysql_real_escape_string($_GET['status']);
        
        mysql_query("UPDATE projects SET project_name = '$project', client_id = $custID, current_status = '$status'
                    WHERE id = $id");
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';
      }
    
      if (strcmp($_GET['delete'], 'Delete') == 0)
      {
        date_default_timezone_SET('America/New_York');
        $time_deleted = date('Y-m-d H:i:s');  
        mysql_query("UPDATE projects SET time_deleted = '$time_deleted' WHERE id = $id");
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';
      }
    
      
      mysql_close($con);
    
    ?>
  
  </body>
</html>
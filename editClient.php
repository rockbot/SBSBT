<!DOCTYPE html>

<html>
  <header>
    <title>Edit Client</title>
  </header>
  
  <body>

    <?php
    /* ******************************************************
        editClient.php
        Change or "delete" client data
        
        Part of the Super Basic Small Business Tracker
        Created by Raquel Vélez
       ****************************************************** */
      include "globals.php";
    
      $con = OpenServerConnection();
    
      $id = $_GET['id'];
    
      mysql_SELECT_db($db_name, $con);
    
      $result = mysql_query("SELECT id, client_name, contact_name, phone, street, city, state, zip
                            FROM clients WHERE id = $id AND time_deleted IS NULL");
      $row = mysql_fetch_array($result);
    
      echo "<h3>Edit Client</h3>";
      echo "<form action='editClient.php' method='get'>";
      echo "Client Name: <input type=text name='client' value='$row[client_name]' /> <br/>";
      echo "Contact Name: <input type=text name='contact' value='$row[contact_name]' /> <br/>";
      echo "Contact Phone: <input type='text' name='phone' value='$row[phone]'/> <br/>";
      echo "Street: <input type='text' name='street' value='$row[street]'/>";
      echo "City: <input type='text' name='city' value='$row[city]'/>";
      echo "State: <input type='text' name='state' value='$row[state]' size='2' maxlength='2'/>";
      echo "Zip: <input type='text' name='zip' value='$row[zip]'/> <br/>";
      echo "<input type='hidden' name='id' value='$row[id]'/>";
      echo "<input type='submit' name='editConfirm' value='Confirm'/>";
      echo "<input type='submit' name='delete' value='Delete' onclick='return confirm(&quot;Are you sure?&quot;)'/>";
      echo "</form>";
      
      if (strcmp($_GET['editConfirm'], 'Confirm') == 0)
      {
        $client = mysql_real_escape_string($_GET['client']);
        $contact = mysql_real_escape_string($_GET['contact']);
        $phone = mysql_real_escape_string($_GET['phone']);
        $street = mysql_real_escape_string($_GET['street']);
        $city = mysql_real_escape_string($_GET['city']);
        $state = mysql_real_escape_string($_GET['state']);
        $zip = mysql_real_escape_string($_GET['zip']);
        mysql_query("UPDATE clients SET client_name = '$client', contact_name = '$contact',
                    phone = '$phone', street = '$street', city = '$city', state = '$state', 
                    zip = '$zip' WHERE id = $id");
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';
      }
    
      if (strcmp($_GET['delete'], 'Delete') == 0)
      {
        date_default_timezone_SET('America/New_York');
        $time_deleted = date('Y-m-d H:i:s');  
        mysql_query("UPDATE clients SET time_deleted = '$time_deleted' WHERE id = $id");
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=start.php">';
      }
    
      
      mysql_close($con);
    
    ?>

  </body>
</html>
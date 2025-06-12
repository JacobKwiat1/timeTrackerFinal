<?php
$pageTitle = "Stats";
include( "includes/header.php");
require_once("connect.php");
echo "
<tr>
<table border='0' width='75%' cellspacing='3' cellpadding='3' align='center'>
<tr>
<td align='left' width='10%'>ID</td>
<td align='left' width='25%'><b>User</b></td>
<td align='center' width='30%'><b>Email</b></td>
<td align='center' width='25%'><b>totalTime</b></td>
<td align='right' width='25%'><b>Admin</b></td>
</tr>";

$req = "SELECT ID, username, email, totalTime, admin FROM user";
$result = $connection->query($req);
    foreach( $result as $row ){
        echo "
            <tr>
            <td align='left'>$row[ID]</td>
            <td align='left'>$row[username] </td>
            <td align='center'>$row[email]</td>
            <td align='center'>$row[totalTime]</td>
            <td align='right'>$row[admin]</td>
            <td align='right'><form method='POST' action='admin.php'><input type='hidden' id='ID' name='ID' value='$row[ID]'/><input type='submit' value='DELETE'></form></td> 
        </tr>
        ";
    }
    echo "</table>";

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $ID = $_POST['ID'];
       $q = "DELETE FROM user WHERE ID = $ID";
       $spot = $connection->query($q);
       header('Location:admin.php?status=1');
    }
include('includes/footer.php');
?>

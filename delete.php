<?php
if(isset($_GET['id'])) {

    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "grill";

    $connection = new mysqli($servername, $username, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "DELETE FROM clients WHERE id = $id";
    $result = $connection->query($sql);
    if ($result) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $connection->error;
    }

} else {
    echo "No ID provided for deletion.";
}
header("location: admin.php");
exit;
?>
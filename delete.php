<?php
require_once 'classes/AbstractDB.php';

$clientDB = new AbstractDB('clients');

?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $clientDB->deleteID($id);
    header("location: admin.php");
    exit;
} else {
    echo "No ID provided for deletion.";
}
?>
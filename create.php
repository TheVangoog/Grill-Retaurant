<?php
require_once 'classes/UniversalDB.php';

$clientDB = new UniversalDB('clients');

?>

<?php

$name = "";
$email = "";
$password = "";
$description = "";
$errorMessage = "";
$sucessMeseege = "";

// no valiation + securing password yet

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $description = $_POST['description'];
    $clientDB->create($name, $email, $password, $description);
    $sucessMeseege = "Client added successfully!";
    header("location: admin.php");
    exit;
}
// Remove the else block that was here
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Add New Client</h2>
        <?php
        if (!empty($errorMessage)) {
            echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
        }
        ?>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Client Name</label>
                <input type="text" class="form-control" id="name" name="name" value=<?php echo $name ?>>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value=<?php echo $email ?>>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value=<?php echo $password ?>>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" value=<?php echo $description ?>></textarea>
            </div>
            <?php
            if (!empty($sucessMeseege) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                echo '<div class="alert alert-success">' . $sucessMeseege . '</div>';
            }
            ?>
            <button type="submit" class="btn btn-primary">Add Client</button>
        </form>
    </div>
</body>

</html>
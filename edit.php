<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grill";

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


$name = "";
$email = "";
$password = "";
$description = "";
$errorMessage = "";
$sucessMeseege = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $description = $_POST['description'];

    do {
        if (empty($name) || empty($email) || empty($password) || empty($description)) {
            $errorMessage = "Please fill in all fields.";
            break;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email format.";
            break;
        }

         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
         if (!empty($sucessMeseege) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            echo '<div class="alert alert-success">' . $sucessMeseege . '</div>';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "UPDATE clients SET name = '$name', email = '$email', password = '$hashedPassword', description = '$description' WHERE id = $id";
            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Update failed: " . $connection->error;
            } else {
                $sucessMeseege = "Client updated successfully!";
                header("location: admin.php");
                exit;
            }
        }
        $name = "";
        $email = "";
        $password = "";
        $description = "";

        $sucessMeseege = "Client added successfully!";
        header("location: admin.php");
        exit;

    } while (false);
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



        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM clients WHERE id = $id";
            
            try {
                $result = $connection->query($sql);
            } catch (Exception $e) {
                $errorMessage = "Database error: " . $e->getMessage();
            }


            if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $email = $row['email'];
            $description = $row['description'];
            } else {
            header("location: admin.php");
            exit;
            }
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
            <button type="submit" class="btn btn-primary">Add Client</button>
        </form>
    </div>
</body>

</html>
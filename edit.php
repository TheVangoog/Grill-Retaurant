<?php
require_once 'classes/UniversalDB.php';
$clientDB = new UniversalDB('clients');

$name = "";
$email = "";
$password = "";
$description = "";
$errorMessage = "";
$successMessage = "";

// Handle GET request - Load data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $client = $clientDB->readID($id);
    if ($client && !empty($client)) {
        $row = $client[0];
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $description = $row['description'];
    } else {
        $errorMessage = "Client not found.";
    }
}

// Handle POST request - Update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $description = $_POST['description'];

    if (empty($name) || empty($email) || empty($password)) {
        $errorMessage = "All fields are required";
    } else {
        // Call update method from your AbstractDB class
        $clientDB->update($id, $name, $email, $password, $description);
        header("Location: admin.php");
        exit;
    }
}
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
            echo "<div class=\"alert alert-danger\">{$errorMessage}</div>";
        }

        if (!empty($sucessMeseege)) {
            echo "<div class=\"alert alert-success\">{$sucessMeseege}</div>";
        }
        ?>
        <div class="container mt-5">
            <h2 class="mb-4">Edit Client</h2>
            <form method="POST">
                <!-- Add hidden input for ID -->
                <input type="hidden" name="id"
                    value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Client Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?php echo htmlspecialchars($name); ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        value="<?php echo htmlspecialchars($password); ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"
                        rows="3"><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Client</button>
                <a href="admin.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
</body>

</html>
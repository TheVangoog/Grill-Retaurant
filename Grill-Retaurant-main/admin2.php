<?php
require_once 'classes/UniversalDB.php';

$productDB = new UniversalDB('products');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Table Management</h1>
        <div class="text-end mb-3">
            <a class="btn btn-primary" href="create.php">Add New Entry</a>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>BlobIMG</th>
                    <th>Available</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = $productDB->readAll(); 
                // Dynamic rows
                foreach($data as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['blobIMG']) . "' alt='Image' class='blobimg' style='max-width: 64px; max-height: 64px; object-fit: contain;'></td>";
                    echo "<td>" . $row['available'] . "</td>";
                    echo "</tr>";
                }

                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
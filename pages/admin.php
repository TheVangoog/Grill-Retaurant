<?php
require_once '../classes/Products.php';

$products = new Products();
$allProducts = $products->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Products Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Products Management</h2>
        <a href="admin-create.php" class="btn btn-success">Create New Product</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($allProducts as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['ID']); ?></td>
                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($product['blobIMG']); ?>"
                         alt="Product Image"
                         style="width: 100px;"></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                <td>
                    <a href="admin-edit.php?id=<?php echo htmlspecialchars($product['ID']); ?>"
                       class="btn btn-primary btn-sm">Edit</a>
                    <a href="../_functions/product-delete.php?id=<?php echo htmlspecialchars($product['ID']); ?>"
                       class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

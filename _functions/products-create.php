<?php
require_once '../classes/Products.php';

$products = new Products();
$name = isset($_POST['name']) ? $_POST['name'] : null;
$description = isset($_POST['description']) ? $_POST['description'] : null;
$price = isset($_POST['price']) ? $_POST['price'] : null;
$file_name = $_FILES['image']['name'];
$file_tmp = $_FILES['image']['tmp_name'];
$image = null;

try {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("No valid file uploaded");
    }
    if (!is_readable($file_tmp)) {
        throw new Exception("Cannot read temporary file");
    }
    $image = file_get_contents($file_tmp);
    if ($image === false) {
        throw new Exception("Failed to read file contents");
    }
} catch (Exception $e) {
    $image = file_get_contents('../images/noImagePlaceholder.png');
}

if (!$name || !$description || !$price) {
    header("location: ../pages/admin.php?error=" . urlencode("Name, description and price are required fields"));
    exit();
}

try {
    $products->createProduct($name, $description, $price, $image);
    header("location: ../pages/admin.php?success=" . urlencode("Product created successfully"));
} catch (Exception $e) {
    header("location: ../pages/admin.php?error=" . urlencode($e->getMessage()));
}
exit();
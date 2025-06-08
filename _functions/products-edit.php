<?php
require_once '../classes/Products.php';

$id = isset($_POST['id']) ? $_POST['id'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;
$description = isset($_POST['description']) ? $_POST['description'] : null;
$price = isset($_POST['price']) ? $_POST['price'] : null;
$file_name = $_FILES['image']['name'];
$file_tmp = $_FILES['image']['tmp_name'];

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
    $image = null;
}





if (!$id || !$name || !$description || !$price) {
    header("location: ../pages/admin.php?error=Missing required fields: " . (!$id ? 'Id, ' : '') . (!$name ? 'Name, ' : '') . (!$description ? 'Description, ' : '') . (!$price ? 'Price' : ''));
    exit();
}

try {
    $productDB = new Products();
    $productDB->updateProduct($id, $name, $price, $description, $image);
    header("location: ../pages/admin.php?success=Product updated successfully");
} catch (Exception $e) {
    echo $e->getMessage();
}
exit();
?>
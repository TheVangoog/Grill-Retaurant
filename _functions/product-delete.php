<?php
require_once '../classes/Products.php';

$products = new Products();
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header("location: ../pages/admin.php?error=Invalid product ID");
    exit();
}

try {
    $products->deleteProduct($id);
    header("location: ../pages/admin.php?success=Product deleted successfully");
} catch (Exception $e) {
    header("location: ../pages/admin.php?error=" . urlencode($e->getMessage()));
}
exit();

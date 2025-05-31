<?php
require_once '../classes/User.php';

$user = new User();
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header("location: ../pages/wishlist.php?error=Invalid item ID");
    exit();
}

try {
    $user->wishlistRemove($id);
    header("location: ../pages/wishlist.php?success=Item removed from wishlist");
} catch (Exception $e) {
    header("location: ../pages/wishlist.php?error=" . urlencode($e->getMessage()));
}
exit();
?>
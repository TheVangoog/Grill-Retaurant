<?php
require_once '../classes/User.php';
$user = new User();
$user->wishlistAdd($_GET['id']);
header("location: ../pages/wishlist.php");
?>
<?php
require_once '../classes/User.php';;
$user = new User();
$user->wishlistClear();
header("location: ../pages/wishlist.php");
?>
<?php
require_once '../classes/User.php';
require_once '../classes/Products.php';
$user = new User();
$products = new Products();

$wishlistIds = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], true) : [];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">My Wishlist</h1>
        <div class="btn-group">
            <button class="btn btn-primary">
                <a href="../index.php" class="text-white text-decoration-none">Back</a>
            </button>
            <button class="btn btn-danger">
                <a href="../_functions/clear-wishlist.php" class="text-white text-decoration-none">Clear Wishlist</a>
            </button>
        </div>

    </div>

    <div class="row g-4">
        <?php
        $data = json_decode($_COOKIE["wishlist"], true);
        $rendered_ids = array();
        $item_counts = array();

        foreach ($data as $email => $array) {
            if ($email == $_SESSION['email']) {
                echo "<div class='col-12'><h4>Your Wishlist Items:</h4></div>";

                // Count occurrences of each item ID
                foreach ($array as $item) {
                    if (!isset($item_counts[$item])) {
                        $item_counts[$item] = 0;
                    }
                    $item_counts[$item]++;
                }

                foreach ($array as $item) {
                    if (!in_array($item, $rendered_ids)) {
                        $product = $products->readID($item)[0];
                        echo "<div class='col-md-4'>";
                        echo "<div class='card h-100'>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($product['blobIMG']) . "' class='card-img-top' style='max-height: 200px; object-fit: contain;' alt='" . $product['name'] . "'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $product['name'] . "</h5>";
                        echo "<p class='card-text'>" . $product['description'] . "</p>";
                        echo "<p class='card-text'>$" . $product['price'] . "</p>";
                        echo "<div class='d-flex justify-content-end align-items-center'>";
                        echo "<button class='btn btn-sm btn-outline-secondary me-2' onclick='window.location.href=\"../_functions/remove-wishlist.php?id=" . $item . "\"'>-</button>";
                        echo "<p class='card-text'>" . $item_counts[$item] . "</p>";
                        echo "<button class='btn btn-sm btn-outline-secondary me-2' onclick='window.location.href=\"../_functions/add-wishlist.php?id=" . $item . "\"'>+</button>";
                        echo "</div>";
                        echo "</div></div></div>";
                        $rendered_ids[] = $item;
                    }
                }
            }
        }
        ?>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
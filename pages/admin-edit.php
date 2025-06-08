<?php
require_once '../_functions/debug_to_console.php';
require_once '../classes/Products.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$products = new Products();
$name = $products->readID($id)[0]['name'];
$price = $products->readID($id)[0]['price'];
$description = $products->readID($id)[0]['description'];
$image = $products->readID($id)[0]['blobIMG'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Edit Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Edit Product</h3>
        </div>
        <div class="card-body">
            <form action="../_functions/products-edit.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" step="1"
                           value="<?php echo htmlspecialchars($price); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                              required><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png,.gif">
                    <?php if ($image): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="Current image"
                             class="mt-2" style="max-width: 200px;">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
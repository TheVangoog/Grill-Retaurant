# Grill-Retaurant

 <?php
        $processedIds = array();
        $loggedInEmail = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
        $wishlistCookie = isset($_COOKIE['wishlist_' . $loggedInEmail]) ? json_decode($_COOKIE['wishlist_' . $loggedInEmail], true) : [];

        foreach ($wishlistIds as $id):
            if (in_array($id, $processedIds)) continue;
            $processedIds[] = $id;

            $productInfo = $products->readID($id);
            if (!empty($productInfo)):
                $product = $productInfo[0];
                $quantity = isset($productCounts[$id]) ? $productCounts[$id] : 0;
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['blobIMG']); ?>"
                                 class="card-img-top p-3"
                                 alt="<?php echo $product['name']; ?>"
                                 style="height: 200px; object-fit: contain;">
                            <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0"><?php echo $product['name']; ?></h5>
                            </div>
                            <p class="card-text text-muted small mb-2"><?php echo $product['description']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-primary mb-0">$<?php echo number_format($product['price'], 2); ?></h4>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-cart-plus"></i> Buy
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm">
                                        -
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm">
                                        <?php echo $quantity; ?>
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm">
                                        +
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endif;
        endforeach;
        ?>
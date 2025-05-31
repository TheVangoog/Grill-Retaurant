<?php
require_once "classes/Products.php";

$productsDB = new Products();
?>


<?php
include "partials/header.php" ?>



            <div id="heading">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="heading-content">
                                <h2>Our Products</h2>
                                <span>Home / <a href="about-us.php">Products</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <div id="products-post">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="product-heading">
                                <h2>Hungry ?</h2>
                                <img src="images/under-heading.png" alt="" >
                            </div>
                        </div>
                    </div>

                    <?php
                    $itemsPerPage = 10;
                    $pageNumber = 1;
                    $totalItems = $productsDB->getCount();
                    $totalPages = ceil($totalItems / $itemsPerPage);
                    $data = $productsDB->getPage($pageNumber);
                    ?>

                    <div class="row" id="Container">
                        <?php foreach ($data as $row): ?>
                            <div class="col-md-3 col-sm-6 mix portfolio-item">
                                <div class="portfolio-wrapper">
                                    <div class="portfolio-thumb">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['blobIMG']); ?>"
                                             alt="<?php echo $row['name']; ?>"/>
                                        <div class="hover">
                                            <div class="hover-iner">
                                                <a class="fancybox"
                                                   onclick="window.location.href='_functions/add-wishlist.php?id=' + this.getAttribute('data-product-id')"
                                                   data-product-id="<?php echo $row['ID']; ?>"
                                                   href="data:image/jpeg;base64,<?php echo base64_encode($row['blobIMG']); ?>">
                                                    <img src="images/open-icon.png" alt=""/>
                                                </a>
                                                <span><?php echo $row['name']; ?></span>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="label-text">
                                        <h3><a href="single-post.php?id=<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></a></h3>
                                        <span class="text-category">$<?php echo number_format($row['price'], 2); ?></span>
                                    </div>
                                </div>          
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="pagination">
                        <div class="row">   
                            <div class="col-md-12">
                                <ul>
                                    <li><a href="products.php?page=<?php echo max(1, $pageNumber - 1); ?>"
                                           class="page-link">Previous</a></li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li><a href="products.php?page=<?php echo $i; ?>" class="page-link 
                                            <?php echo ($i == $pageNumber) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li><a href="products.php?page=<?php echo min($totalPages, $pageNumber + 1); ?>"
                                           class="page-link">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>



<?php
include "partials/footer.php" ?>


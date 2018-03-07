<?php

// This file initializes some goodies that will make your
// development experience nicer! If your PHP throws an
// error, we will show you exactly what went wrong!
require_once('../includes/init.php');
require_once('../includes/db.php');

// Here you might connect to the database and show off some of your newest guitars.
$productID = $_GET['productID'];
$product = getOne("SELECT * FROM products WHERE productID = :product_id", [
    'product_id' => $productID
]);

$descriptionItems = explode("Features:", $product['description']);
$description = $descriptionItems[0];

// Make sure the page has product features and if it does make sure to split the string
$hasFeatures = false;
if(count($descriptionItems) > 1) {
    $features = explode("*", $descriptionItems[1]);
    $hasFeatures = true;
}

$discount = $product['discountPercent'];
$isDiscounted = ($discount > 0 ? true : false);
$discountedPrice = $product['listPrice'] - (($discount / 100) * $product['listPrice']);

$price_format = number_format($product['listPrice'], 2, '.', ',');
$discounted_price_format = number_format($discountedPrice, 2, '.', ',');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="vendors/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/grid.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="/stylesheets/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400" rel="stylesheet">
</head>
<body>
    <nav class="secondary-nav navbar navbar-expand-sm navbar-light mb-3 pt-0 pb-0">
      <div class="container">
        <a class="navbar-brand">Nick's Guitars - Product</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../pages/all_products.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../pages/all_orders.php">Orders</a>
            </li>
        </ul>
        </div>
    </nav>
    <section class="product-details-section row">
        <div class="product-details span-2-of-3">
            <div>
                <h3 class="description-title">
                    <?= $product['productName'] ?>'s Description
                </h3>
                <div class="description">
                    <p><?= $description ?></p>
                </div>
                <?php if($hasFeatures): ?>
                    <div class="features">
                        <h4 class="feature-heading">
                            FEATURES
                        </h4>
                        <ul>
                            <?php foreach($features as $index => $feature): ?>
                                <?php if($index != 0): ?>
                                    <li class="feature"><?= $feature ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="buy-product span-1-of-3">
            <div>
                <p class="price-text">Price:</p>
                <!-- Find out if the product is discounted currently and if so show the updated price -->
                <?php if($isDiscounted): ?>
                    <p class="price-outdated">$<?= $price_format ?></p>
                    <p class="price">$<?= $discounted_price_format ?></p>
                <?php else: ?>
                    <p class="price">$<?= $price_format ?></p>
                <?php endif; ?>
            </div>
            <a href="#" class="add-to-cart-btn">Add To Cart</a>
        </div>
    </section>
</body>
</html>

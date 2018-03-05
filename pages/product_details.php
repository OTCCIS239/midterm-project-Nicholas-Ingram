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
                <a href="all_products.php" class="nav-link">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Orders</a>
            </li>
        </ul>
        </div>
    </nav>
    <section class="product-details-section row">
        <div class="product-details span-2-of-3">
            product details...
        </div>
        <div class="buy-product span-1-of-3">
            product image/buy button...
        </div>
    </section>
</body>
</html>

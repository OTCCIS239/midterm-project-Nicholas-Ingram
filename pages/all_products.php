<?php

// This file initializes some goodies that will make your
// development experience nicer! If your PHP throws an
// error, we will show you exactly what went wrong!
require_once('../includes/init.php');
require_once('../includes/db.php');

// Here you might connect to the database and show off some of your newest guitars.
$categories = getMany('SELECT * FROM categories');
$products = getMany('SELECT * FROM products');

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
    <link rel="stylesheet" type="text/css" href="/stylesheets/product_styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400" rel="stylesheet">
</head>
<body>
    <nav class="secondary-nav navbar navbar-expand-sm navbar-light mb-3 pt-0 pb-0">
      <div class="container">
        <a class="navbar-brand">Nick's Guitars - Products</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../pages/all_orders.php">Orders</a>
            </li>
        </ul>
        </div>
    </nav>
    <form action="product_details.php" method="get">
        <section class="row">
            <div class="side-bar">
                <div class="list-group col span-1-of-3" id="list-tab" role="tablist">
                    <!-- First create a tab pane for all the products -->
                    <a href="#list-all" class="side-item active show" id="list-all-list" data-toggle="list">All Products</a>
                    <!-- Now go through each category and create a list group item for it -->
                    <?php foreach($categories as $index => $category): ?>
                        <a class="side-item"
                            id="list-cat<?= $category['categoryID'] ?>-list"
                            href="#list-cat<?= $category['categoryID'] ?>"
                            data-toggle="list"><?= $category['categoryName'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="product-list col span-2-of-3">
                <?= listProducts($products, 0, "anchor-top product-category tab-pane fade show active"); ?>
                <?= listProducts($products, 1) ?>
                <?= listProducts($products, 2) ?>
                <?= listProducts($products, 3) ?>
            </div>
        </section>
    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

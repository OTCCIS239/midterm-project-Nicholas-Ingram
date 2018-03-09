<?php

// This file initializes some goodies that will make your
// development experience nicer! If your PHP throws an
// error, we will show you exactly what went wrong!
require_once('../includes/init.php');
require_once('../includes/db.php');

// Here you might connect to the database and show off some of your newest guitars.
$orders = getMany("SELECT * FROM orders");

// Get all the customers in the database
$customersSQL = getMany("SELECT * FROM customers");
// Now add al the customers to an array that is based on their customerID
$customersInfo = [];
foreach($customersSQL as $customer) {
    $customerInfo = [];
    $customerInfo[0] = $customer['firstName']." ".$customer['lastName'];
    $customerInfo[1] = $customer['emailAddress'];
    $customersInfo += [$customer['customerID'] => $customerInfo];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="vendors/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/grid.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="/stylesheets/styles.css">
    <link rel="stylesheet" type="text/css" href="/stylesheets/order_styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400" rel="stylesheet">
</head>
<body>
    <nav class="secondary-nav navbar navbar-expand-sm navbar-light mb-3 pt-0 pb-0">
      <div class="container">
        <a class="navbar-brand">Nick's Guitars - Orders</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../pages/all_products.php">Products</a>
            </li>
        </ul>
        </div>
    </nav>
    <form action="order_details.php" method="get">
        <section class="row order-section">
            <div class="side-bar">
                <div class="list-group col span-1-of-3" id="list-tab" role="tablist">
                    <a href="#list-all" class="side-item active show" id="list-all-list" data-toggle="list">All Orders</a>
                    <a href="#list-unship" class="side-item" id="list-unship-list" data-toggle="list">Unshipped Orders</a>
                </div>
            </div>
            <div class="order-list col span-2-of-3">
                <div class="order-list-head">
                    <p class="order-id">Order #</p>
                    <p class="customer-name">Customer Name</p>
                    <p class="customer-email">Customer Email</p>
                    <p class="order-date">Order Date</p>
                    <p class="shipped-date">Shipped Date</p>
                </div>
                <?= listOrders($orders, $customersInfo, "all", "anchor-top order-category tab-pane fade show active") ?>
                <?= listOrders($orders, $customersInfo, "unship") ?>
            </div>
        </section>
    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

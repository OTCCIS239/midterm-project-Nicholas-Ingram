<?php

// This file initializes some goodies that will make your
// development experience nicer! If your PHP throws an
// error, we will show you exactly what went wrong!
require_once('../includes/init.php');
require_once('../includes/db.php');

// Here you might connect to the database and show off some of your newest guitars.
$orderID = $_GET['orderID'];

$order = getOne("SELECT * FROM orders WHERE orderID = :order_id", [
    'order_id' => $orderID
]);
$orderItems = getMany("SELECT * FROM orderItems WHERE orderID = :order_id", [
    'order_id' => $orderID
]);
$customer = getOne("SELECT * FROM customers WHERE customerID = :customer_id", [
    'customer_id' => $order['customerID']
]);
$customerAddress = getOne("SELECT * FROM addresses WHERE addressID = :address_id", [
    'address_id' => $order['shipAddressID']
]);
$products = getMany("SELECT * FROM products");

// Let's get all the needed price information for the pages as well as the products from the product database that goes with it
$discountTotal = 0;
$total = $order['shipAmount'] + $order['taxAmount'];
$orderedItems = [];
foreach($orderItems as $item) {
    $discountTotal += $item['discountAmount'];
    $total += ($item['itemPrice'] * $item['quantity']) - $item['discountAmount'];
    foreach($products as $product) {
        if ($product['productID'] == $item['productID']) {
            $product += ['qty' => $item['quantity']];
            $product['listPrice'] = $item['itemPrice'];
            $orderedItems[] = $product;
            break;
        }
    }
}

// Format the order and ship date
$orderDate = explode(' ', $order['orderDate'])[0];
$orderDateExp = explode('-', $orderDate);
$orderDate_form = $orderDateExp[0]."/".$orderDateExp[1]."/".$orderDateExp[2];

if($order['shipDate'] != null) {
    $shipDate = explode(' ', $order['shipDate'])[0];
    $shipDateExp = explode('-', $shipDate);
    $shipDate_form = $shipDateExp[0]."/".$shipDateExp[1]."/".$shipDateExp[2];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Details</title>
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
    <section class="order-details row">
        <div class="customer-info span-2-of-3">
            <h3>Ordered Items</h3>
            <div class="ordered-items table-responsive table-bordered">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th style="width: 20%">Price</th>
                            <th style="width: 10%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orderedItems as $item): ?>
                            <tr>
                                <td><?= $item['productName'] ?></td>
                                <td style="width: 20%">$<?= $item['listPrice'] ?></td>
                                <td style="width: 10%"><?= $item['qty'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div>
                <h3>Customer Information</h3>
                <br>
                <p class="lbl">First Name:</p>
                <p class="lbl-text"><?= $customer['firstName'] ?></p>
                <p class="lbl">Last Name:</p>
                <p class="lbl-text"><?= $customer['lastName'] ?></p>
                <p class="lbl">Billing Address:</p>
                <p class="lbl-text"><?= $customerAddress['line1']." ".$customerAddress['city'].", ".$customerAddress['state']." ".$customerAddress['zipCode'] ?></p>
                <p class="lbl">Phone Number:</p>
                <p class="lbl-text"><?= $customerAddress['phone'] ?></p>
                <p class="lbl">Card Used:</p>
                <p class="lbl-text"><?= $order['cardNumber'] ?></p>
            </div>
        </div>
        <div class="order-info span-1-of-3">
            <h3>Order Info</h3>
            <p class="lbl">Discount Amount:</p>
            <p class="lbl-text">$<?= $discountTotal ?></p>
            <p class="lbl">Shipping Price:</p>
            <p class="lbl-text">$<?= $order['shipAmount'] ?></p>
            <p class="lbl">Tax:</p>
            <p class="lbl-text">$<?= $order['taxAmount'] ?></p>
            <p class="lbl">Total Price:</p>
            <p class="lbl-text">$<?= $total ?></p>
            <p class="lbl">Order Date:</p>
            <p class="lbl-text"><?= $orderDate_form ?></p>
            <p class="lbl">Ship Date:</p>
            <?php if($order['shipDate'] != null): ?>
                <p class="lbl-text"><?= $shipDate_form ?></p>
            <?php else: ?>
                <p class="lbl-text">Not Shipped</p>
            <?php endif; ?>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

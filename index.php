<?php

// This file initializes some goodies that will make your
// development experience nicer! If your PHP throws an
// error, we will show you exactly what went wrong!
// This line should be on every page you create.
require_once('./includes/init.php');
require_once('./includes/db.php');

// Here you might connect to the database and show off some of your newest guitars.
$statement = $conn->prepare("SELECT * FROM categories");
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>This is my super awesome Guitar Shop!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="card mt-4">
                    <div class="card-header bg-success text-white">
                        Nick's Guitar Shop
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-4">
                                <div class="list-group mb-5" id="list-tab" role="tablist">
                                    <?php foreach($categories as $category): ?>
                                        <?php if($category['categoryID'] == 1) : ?>
                                            <a href="#list-<?= $category['categoryID'] ?>" class="list-group-item list-group-item-action active" id="list-<?= $category['categoryID'] ?>-list" data-toggle="list"><?= $category['categoryName'] ?></a>
                                        <?php else : ?>
                                            <a href="#list-<?= $category['categoryID'] ?>" class="list-group-item list-group-item-action" id="list-<?= $category['categoryID'] ?>-list" data-toggle="list"><?= $category['categoryName'] ?></a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="tab-content" id="nav-tabContent">
                                    <!-- Add all the list content here -->
                                    <?php foreach($categories as $category): ?>
                                        <?php if($category['categoryID'] == 1) : ?>
                                            <div class="tab-pane fade show active" id="list-<?= $category['categoryID'] ?>" role="tabpane">
                                                All <?= $category['categoryName'] ?> Content Go Here...
                                            </div>
                                        <?php else : ?>
                                            <div class="tab-pane fade" id="list-<?= $category['categoryID'] ?>" role="tabpane">
                                                All <?= $category['categoryName'] ?> Content Go Here...
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

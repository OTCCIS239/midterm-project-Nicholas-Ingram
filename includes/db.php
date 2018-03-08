<?php

// You might connect to your database here. However, don't
// hard-code your database credentials here! Instead,
// copy the file `/.env.example` to `/.env`, and
// place your credentials there. Notice, this
// file shouldn't be in your repository.

// You can access the credentials you have defined in
// `/.env` by calling the `getenv($name)` function.
// For example, use `getenv('DB_HOST')` to get the
// host of your database. Yours should be "localhost"

// Make sure to include support for DB_PORT. See the
// PHP Documentation for the MySQL PDO DSN:
// http://php.net/manual/en/ref.pdo-mysql.connection.php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$database = getenv('DB_DATABASE');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

$dsn = "mysql:host=$host;port=$port;dbname=$database";
$conn = new PDO ($dsn, $username, $password);

function getOne($query, array $binds = [])
{
    //Define global variables that will be needed
    global $conn;

    $statement = $conn->prepare($query);
    foreach($binds as $key => $value) {
        $statement->bindValue($key, $value);
    }
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    return $result;
}

function getMany($query, array $binds = [])
{
    //Define global variables that will be needed
    global $conn;

    $statement = $conn->prepare($query);
    foreach($binds as $key => $value) {
        $statement->bindValue($key, $value);
    }
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();

    return $results;
}

function listProducts ($products, $categoryID, $divClass="anchor-top product-category tab-pane fade")
{ ?>
    <?php if($categoryID == 0): ?>
        <div class="<?= $divClass ?>" id="list-all" role="tabpane">
    <?php else: ?>
        <div class="<?= $divClass ?>" id="list-cat<?= $categoryID ?>" role="tabpane">
    <?php endif; ?>
        <?php foreach($products as $product): ?>
                <?php if($product['categoryID'] == $categoryID || $categoryID == 0): ?>
                    <?php
                        $discount = $product['discountPercent'];
                        $isDiscounted = ($discount > 0 ? true : false);
                        $discountedPrice = $product['listPrice'] - (($discount / 100) * $product['listPrice']);

                        $price_format = number_format($product['listPrice'], 2, '.', ',');
                        $discounted_price_format = number_format($discountedPrice, 2, '.', ',');
                    ?>
                    <div class="product">
                        <button class="product-button" type="submit" name="productID" value="<?= $product['productID'] ?>">
                            <p class="product-name"><?= $product['productName'] ?></p>
                            <?php if($isDiscounted): ?>
                                <p class="product-outdated-price">$<?= $price_format ?></p>
                                <p class="product-price">$<?= $discounted_price_format ?></p>
                            <?php else: ?>
                                <p class="product-price">$<?= $price_format ?></p>
                            <?php endif; ?>
                        </button>
                    </div>
                <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php }

function listOrders ($orders, $customers, $categoryID, $divClass="anchor-top order-category tab-pane fade")
{ ?>
    <div class="<?= $divClass ?>" id="list-<?= $categoryID ?>" role="tabpane">
        <?php foreach($orders as $order): ?>
                <?php if($order['shipDate'] == null || $categoryID == "all"): ?>
                    <?php
                        $orderDate = explode(' ', $order['orderDate'])[0];
                        $orderDateExp = explode('-', $orderDate);
                        $orderDate_form = $orderDateExp[0]."/".$orderDateExp[1]."/".$orderDateExp[2];

                        if($order['shipDate'] != null) {
                            $shipDate = explode(' ', $order['shipDate'])[0];
                            $shipDateExp = explode('-', $shipDate);
                            $shipDate_form = $shipDateExp[0]."/".$shipDateExp[1]."/".$shipDateExp[2];
                        }
                     ?>
                    <div class="order">
                        <button class="order-button" type="submit" name="orderID" value="<?= $order['orderID'] ?>">
                            <p class="order-id"><?= $order['orderID'] ?></p>
                            <p class="customer-name"><?= $customers[$order['customerID']] ?></p>
                            <p class="order-date"><?= $orderDate_form ?></p>
                            <?php if($order['shipDate'] == null): ?>
                                <p class="shipped-date">Unshipped</p>
                            <?php else: ?>
                                <p class="shipped-date"><?= $shipDate_form ?></p>
                            <?php endif; ?>
                        </button>
                    </div>
                <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php }

<?php
include 'auth.php';

include_once 'conn.php';
$products = [];
$user = $_SESSION['user'];
$result = $mysqli->query("SELECT * FROM user WHERE email = '$user'");
$userData = $result->fetch_assoc();
$user_id = $userData['user_id'];
$result = $mysqli->query("SELECT * FROM products WHERE user_id = '$user_id'");
while ($productData = $result->fetch_assoc()) {
    $market_id = $productData['market_id'];
    $market_result = $mysqli->query("SELECT * FROM markets WHERE market_id = '$market_id'");
    $marketData = $market_result->fetch_assoc();
    $market = $marketData['name'];
    $products[] = [
        'name' => $productData['product_name'],
        'market' => $market,
        'weight' => $productData['weight'],
        'price' => $productData['price'],
        'stock' => $productData['stock'],
        'image' => $productData['product_image_path']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History - SUPPLYGO</title>
    <link rel="stylesheet" href="history.css">
</head>
<body>

<header>
  <div class="logo">
    <img src="logo web.png" alt="Logo" class="logo-img">
    <h2>SUPPLYGO</h2>
</div>
<a href="dashboard.php" class="logo">
    <img src="logo web.png" alt="Logo" class="logo-img">
    <h2>SUPPLYGO</h2>
</a>
      <nav>
        <a href="dashboard.php">Home</a>
        <a href="market.php">Market</a>
        <a href="transport.php">Transport</a>
        <a href="tracking.php">Tracking</a>
        <a href="history.php" class="active">History</a>
        <a href="logout.php" class="logout"><button>Log out</button></a>
      </nav>
    </div>
</header>

<h1 class="history-title">HISTORY</h1>

<main>
    <?php foreach ($products as $product): ?>
    <div class="order-card">
        <div class="order-header">Toko <?= $product['market'] ?></div>
        <div class="order-body">
            <div class="order-info">
                <p><b>Product</b> : <?= $product['name'] ?></p>
                <p><b>Price</b> : <?= $product['price'] ?></p>
                <p><b>Weight</b> : <?= $product['weight'] ?> kg</p>
                <p><b>Stock</b> : <?= $product['stock'] ?></p>
            </div>
            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
        </div>
        <div class="order-btns">
            <button class="reorder" >REORDER</button>
        </div>
    </div>
    <?php endforeach; ?>
</main>

<script src="script.js"></script>
</body>
</html>


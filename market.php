<?php
include 'auth.php';

  include_once 'conn.php';
  $result = $mysqli->query("SELECT * FROM markets");
  while ($marketData = $result->fetch_assoc()) {
    $market_id = $marketData['market_id'];
    $markets[$market_id] = [
        'name' => $marketData['name'],
        'category' => $marketData['category'],
        'image' => $marketData['market_image_path']
    ];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Market - SUPPLYGO</title>
  <link rel="stylesheet" href="market.css">
</head>
<body>
  <header>
    <div class="header-container">
       <div class="logo">
        <img src="logo web.png" alt="Logo" class="logo-img">
        <h2>SUPPLYGO</h2>
      </div>
      <nav>
        <a href="dashboard.php">Home</a>
        <a href="market.php" class="active">Market</a>
        <a href="transport.php">Transport</a>
        <a href="tracking.php">Tracking</a>
        <a href="history.php">History</a>
        <a href="logout.php" class="logout"><button>Log out</button></a>
      </nav>
    </div>
  </header>

  <main>
    <div class="markets">
      <h2>Markets Near You</h2>
      <div class="market-grid">
        <?php foreach ($markets as $market_id => $market): ?>
        <div class="market-card">
          <img src="<?= $market['image'] ?>" alt="Toko">
          <div class="info">
            <h3>Toko <?= $market['name'] ?></h3>
            <p><?= $market['category'] ?></p>
            <a href="addProduct.php?market_id=<?= $market_id ?>" class="btn-market">Choose</a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>
</body>
</html>
<?php
  require_once 'auth.php';
  require_once 'conn.php';
  $user = $_SESSION['user'];

  $result = $mysqli->query("SELECT * FROM markets");
  while ($marketData = $result->fetch_assoc()) {
    $market_id = $marketData['market_id'];
    $markets[$market_id] = [
        'name' => $marketData['name'],
        'category' => $marketData['category'],
        'image' => $marketData['market_image_path'],
        'address' => $marketData['address']
    ];
  }
  $editMode = isset($_GET['mode']) && $_GET['mode'] === 'edit';
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

          <a href="dashboard.php" class="logo">
              <img src="logo web.png" alt="Logo" class="logo-img">
              <h2>SUPPLYGO</h2>
          </a>
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
        <div class="market-header">
          <h1>Markets</h1>
          <?php if ($user['role'] === 'admin'): ?>
              <a href="?mode=edit"><button>Edit</button></a>
          <?php endif; ?>
        </div>
        <div class="market-grid">
          <?php foreach ($markets as $market_id => $market): ?>
                  <div class="market-card">
                    <img src="<?= $market['image'] ?>" alt="Toko">
                    <div class="info">
                      <?php if ($editMode): ?>
                              <form method="POST" action="marketsManagement.php" enctype="multipart/form-data">
                                <label>Market Name</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($market['name']) ?>">
                                <label>Market Category</label>
                                <input type="text" name="category" value="<?= htmlspecialchars($market['category']) ?>">
                                <label>Market Address</label>
                                <input type="text" name="address" value="<?= htmlspecialchars($market['address']) ?>">
                                <input type="hidden" name="market_id" value="<?= $market_id ?>">
                                <input type="file" name="market_image">
                                <button type="submit" class="btn-market">Save</button>
                              </form>
                      <?php else: ?>
                              <h3>Toko <?= htmlspecialchars($market['name']) ?></h3>
                              <p class="category"><?= htmlspecialchars($market['category']) ?></p>
                              <p class="address"><?= htmlspecialchars($market['address']) ?></p>
                              <?php if ($user['role'] === 'customer'): ?>
                                  <a href="addProduct.php?market_id=<?= $market_id ?>" class="btn-market">Choose</a>
                              <?php endif; ?>
                      <?php endif; ?>
                    </div>
                  </div>
          <?php endforeach; ?>
        </div>
      </div>
    </main>
  </body>
</html>

<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include_once 'conn.php';
  if ($user['role'] === 'customer') {
    $stmt = $mysqli->prepare("SELECT SUM(price * sold) AS total_penjualan FROM products WHERE user_id = ?");
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowTotal = $result->fetch_object();
    $total_penjualan = $rowTotal && $rowTotal->total_penjualan ? (int)$rowTotal->total_penjualan : 0;
    
    // BARANG TERJUAL = SUM(sold)
    $stmt = $mysqli->prepare("SELECT SUM(sold) AS barang_terjual FROM products WHERE user_id = ?");
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowSold = $result->fetch_object();
    $barang_terjual = $rowSold && $rowSold->barang_terjual ? (int)$rowSold->barang_terjual : 0;
    
    // PRODUK AKTIF = COUNT(*)
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS produk_aktif FROM products WHERE user_id = ?");
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowActive = $result->fetch_object();
    $produk_aktif = $rowActive && $rowActive->produk_aktif ? (int)$rowActive->produk_aktif : 0;
  } else {
    $totalUsers = $mysqli->query("SELECT COUNT(*) AS total FROM user")->fetch_object()->total;
    $totalMarkets = $mysqli->query("SELECT COUNT(*) AS total FROM markets")->fetch_object()->total;
    $totalVehicles = $mysqli->query("SELECT COUNT(*) AS total FROM kendaraan")->fetch_object()->total;
  }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - SUPPLYGO</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="logo">
    <img src="logo web.png" alt="Logo" class="logo-img">
    <h2>SUPPLYGO</h2>
<a href="dashboard.php" class="logo">
    <img src="logo web.png" alt="Logo" class="logo-img">
    <h2>SUPPLYGO</h2>
</a>
    <div class="nav">
      <a href="dashboard.php" class="active">Dashboard</a>
      <a href="market.php">Market</a>
      <a href="transport.php">Transport</a>
      <a href="tracking.php">Tracking</a>
      <a href="history.php">History</a>
      <a href="profil.php">Account</a>
      <a href="logout.php">Log out</a>
    </div>
  </div>

  <div class="main">
    <div class="header">
      <h1>Selamat datang, <?php echo $name; ?> 👋</h1>
    </div>

    <?php if ($user['role'] === 'customer'): ?>
            <div class="stats">
              <div class="stat-card">
                <h3>TOTAL PENJUALAN</h3>
                <p class="mono">
                  Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?>
                </p>
              </div>
              <div class="stat-card">
                <h3>BARANG TERJUAL</h3>
                <p class="mono">
                  <?php echo $barang_terjual; ?> pcs
                </p>
              </div>
              <div class="stat-card">
                <h3>PRODUK AKTIF</h3>
                <p class="mono">
                  <?php echo $produk_aktif; ?>
                </p>
              </div>
            </div>
    <?php else: ?>
            <div class="stats">
              <div class="stat-card">
                <h3>TOTAL USERS</h3>
                <p class="mono">
                  <?php echo $totalUsers; ?>
                </p>
              </div>
              <div class="stat-card">
                <h3>TOTAL MARKETS</h3>
                <p class="mono">
                  <?php echo $totalMarkets; ?>
                </p>
              </div>
              <div class="stat-card">
                <h3>TOTAL VEHICLES</h3>
                <p class="mono">
                  <?php echo $totalVehicles; ?>
                </p>
              </div>
            </div>
    <?php endif; ?>
    <div class="products">
      <h2>Iklan Produk</h2>
      <div class="product-grid">
        <div class="ad-card">
          <img src="telur ayam.jpg" alt="Telur Ayam Segar">
          <div class="info">
            <h3>Telur Ayam Segar</h3>
            <p>Protein alami untuk keluarga, kualitas terjamin, selalu fresh setiap hari.</p>
            <a href="#" class="btn-ad">Lihat Selengkapnya</a>
          </div>
        </div>

        <div class="ad-card">
          <img src="kentang.jpg" alt="Kentang Premium">
          <div class="info">
            <h3>Kentang Premium</h3>
            <p>Kentang Premium yang langsung di ambil dari kebun terpilih.</p>
            <a href="#" class="btn-ad">Lihat Selengkapnya</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>



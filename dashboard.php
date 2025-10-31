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
$user = $_SESSION['user'];
$result = $mysqli->query("SELECT * FROM user WHERE email = '$user'");
$userData = $result->fetch_assoc();
$name = $userData['name'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - SUPPLYGO</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <div class="sidebar">
    <img src="logo web.png" alt="Logo" class="logo">
    <h2>SUPPLYGO</h2>
    <div class="nav">
      <a href="dashboard.php">Dashboard</a>
      <a href="#">Order</a>
      <a href="profil.php">Account</a>
      <a href="logout.php">Log out</a>
    </div>
  </div>

  <div class="main">
    <div class="header">
      <h1>Selamat datang, <?php echo $name; ?> 👋</h1>
    </div>

    <div class="stats">
      <div class="stat-card">
        <h3>Total Produk</h3>
        <p>0</p>
      </div>
      <div class="stat-card">
        <h3>Pesanan Baru</h3>
        <p>0</p>
      </div>
      <div class="stat-card">
        <h3>Pendapatan</h3>
        <p>0</p>
      </div>
    </div>

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

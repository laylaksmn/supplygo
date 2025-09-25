<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $validUser = "admin@gmail.com";
    $validPass = "12345";

    $email = $_POST['email'];
    $pass  = $_POST['password'];

    if ($email === $validUser && $pass === $validPass) {
        $_SESSION['user'] = $email;
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - SUPPLYGO</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background: #f5f6fa;
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 240px;
      background: linear-gradient(180deg, #000000, #ff6600);
      padding: 25px 18px;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .sidebar img.logo {
      width: 95px;
      height: 95px;
      object-fit: contain;
      margin-bottom: 10px;
      border-radius: 50%;
      background: rgba(255,255,255,0.08);
      padding: 8px;
    }
    .sidebar h2 {
      margin: 0 0 30px;
      font-size: 22px;
      background: linear-gradient(90deg, #ff7b00ff, #ffffffff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: 900;
      letter-spacing: 1px;
    }
    .nav {
      width: 100%;
    }
    .nav a {
      display: block;
      padding: 12px 14px;
      margin: 8px 0;
      border-radius: 8px;
      text-decoration: none;
      color: #fff;
      font-weight: 600;
      transition: 0.3s;
    }
    .nav a:hover {
      background: rgba(255,255,255,0.15);
      transform: translateX(5px);
    }

    .main {
      flex: 1;
      padding: 30px;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: linear-gradient(90deg, #000000, #ff6600);
      padding: 20px 25px;
      border-radius: 12px;
      color: #fff;
      margin-bottom: 30px;
    }
    .header h1 {
      margin: 0;
      font-size: 22px;
    }
    .header .btn {
      background: linear-gradient(90deg, #ff6600, #cc5200);
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      color: white;
      cursor: pointer;
      font-weight: 700;
      text-decoration: none;
      transition: 0.3s;
    }
    .header .btn:hover {
      background: linear-gradient(90deg, #cc5200, #000000);
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }
    .stat-card {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 6px 15px rgba(0,0,0,0.08);
      transition: 0.3s;
    }
    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(255,102,0,0.4);
    }
    .stat-card h3 { margin: 0; font-size: 15px; color: #555; }
    .stat-card p { margin: 8px 0 0; font-size: 22px; font-weight: bold; color: #ff6600; }

    /* Bagian Iklan Produk */
    .products h2 { margin-bottom: 20px; color: #111; }
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }
    .ad-card {
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
      transition: 0.3s;
    }
    .ad-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(255,102,0,0.3);
    }
    .ad-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .ad-card .info {
      padding: 18px;
    }
    .ad-card h3 {
      margin: 0;
      font-size: 20px;
      color: #ff6600;
    }
    .ad-card p {
      margin: 8px 0 15px;
      color: #555;
      font-size: 14px;
      line-height: 1.5;
    }
    .btn-ad {
      float:right;
      margin-bottom: 20px;
      display: inline-block;
      background-color: #ff6600;
      border: none;
      border-radius: 20px;
      padding: 10px 30px;
      color: white;
      padding: 10px 18px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.1s;
    }
    .btn-ad:hover {
      background-color: #5f2206;
      transform: scale(0.95);
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
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

  <!-- Main -->
  <div class="main">
    <div class="header">
      <h1>Selamat datang, <?php echo htmlspecialchars($username); ?> 👋</h1>
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

    <!-- Bagian Iklan Produk -->
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

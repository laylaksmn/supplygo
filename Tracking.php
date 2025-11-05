<?php
// // tracking.php (UI dummy, tanpa database)
// session_start();
// // Untuk demo tampilan: pakai nama fallback jika belum login
// $name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Tracking - SUPPLYGO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="Tracking.css" />
</head>
<body>
  <div class="sidebar">
    <img src="logo web.png" alt="Logo" class="logo">
    <h2>SUPPLYGO</h2>
    <div class="nav">
      <a href="dashboard.php">Dashboard</a>
      <a href="#" class="active">Tracking</a>
      <a href="#">Order</a>
      <a href="profil.php">Account</a>
      <a href="logout.php">Log out</a>
    </div>
  </div>

  <div class="main">
    <div class="header" style="justify-content:space-between; align-items:center;">
      <h1>Inventory & Sales Tracker</h1>
      <div class="period chips--dark">
        <button class="chip" aria-pressed="true">Hari ini</button>
        <button class="chip">Minggu ini</button>
        <button class="chip">Bulan ini</button>
        <button class="chip">90 Hari</button>
      </div>
    </div>

    <div class="stats">
      <div class="stat-card">
        <h3>TOTAL PENJUALAN</h3>
        <p class="mono">Rp 12.540.000</p>
        <div style="color:#059669; font-weight:800; font-size:12px; margin-top:6px;">▲ +15% vs kemarin</div>
      </div>
      <div class="stat-card">
        <h3>BARANG TERJUAL</h3>
        <p class="mono">318 pcs</p>
        <div style="color:#059669; font-weight:800; font-size:12px; margin-top:6px;">▲ +9% vs periode lalu</div>
      </div>
      <div class="stat-card">
        <h3>PRODUK AKTIF</h3>
        <p class="mono">178</p>
        <div style="color:#6b7280; font-weight:800; font-size:12px; margin-top:6px;">Dalam Katalog</div>
      </div>
    </div>

    <div class="wrap" style="margin-bottom:26px;">
      <div class="toolbar">
        <div class="search">
          <input type="search" placeholder="Cari Produk / SKU">
        </div>
          <button class="chip" aria-pressed="true">Semua</button>
          <button class="chip">Stok Rendah</button>
          <button class="chip">Terlaris</button>
      </div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>PRODUK</th>
              <th>SKU</th>
              <th>KATEGORI</th>
              <th>HARGA</th>
              <th>STOK</th>
              <th>TERJUAL</th>
              <th>STATUS</th>
              <th>LEVEL</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Indomie Goreng</td>
              <td>SKU-IND-01</td>
              <td>Makanan</td>
              <td class="mono">3.500</td>
              <td class="mono">85</td>
              <td class="mono">120</td>
              <td><span class="badge ok">Aman</span></td>
              <td><div class="stockbar"><i style="--w:85%"></i></div></td>
            </tr>
            <tr>
              <td>Susu Ultra 1L</td>
              <td>SKU-SUS-02</td>
              <td>Minuman</td>
              <td class="mono">18.000</td>
              <td class="mono">12</td>
              <td class="mono">24</td>
              <td><span class="badge warn">Menipis</span></td>
              <td><div class="stockbar"><i style="--w:20%"></i></div></td>
            </tr>
            <tr>
              <td>Saos Sambal 140ml</td>
              <td>SKU-SAS-03</td>
              <td>Bumbu</td>
              <td class="mono">9.500</td>
              <td class="mono">0</td>
              <td class="mono">36</td>
              <td><span class="badge danger">Habis</span></td>
              <td><div class="stockbar"><i style="--w:0%"></i></div></td>
            </tr>
            <tr>
              <td>Beras Premium 5kg</td>
              <td>SKU-BER-04</td>
              <td>Sembako</td>
              <td class="mono">78.000</td>
              <td class="mono">44</td>
              <td class="mono">52</td>
              <td><span class="badge ok">Aman</span></td>
              <td><div class="stockbar"><i style="--w:55%"></i></div></td>
            </tr>
            <tr>
              <td>Minyak Goreng 1L</td>
              <td>SKU-MIN-05</td>
              <td>Sembako</td>
              <td class="mono">16.500</td>
              <td class="mono">18</td>
              <td class="mono">40</td>
              <td><span class="badge warn">Menipis</span></td>
              <td><div class="stockbar"><i style="--w:25%"></i></div></td>
            </tr>
            <tr>
              <td>Kopi Bubuk 200g</td>
              <td>SKU-KOP-06</td>
              <td>Minuman</td>
              <td class="mono">28.000</td>
              <td class="mono">61</td>
              <td class="mono">78</td>
              <td><span class="badge ok">Aman</span></td>
              <td><div class="stockbar"><i style="--w:70%"></i></div></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Grafik & Ringkasan (placeholder box sesuai screenshot) -->
    <div class="wrap">
      <h2 style="margin:0 0 14px; font-size:28px; line-height:1;">Grafik &amp; Ringkasan</h2>
      <div class="charts">
        <div class="chart-box">
          <div style="font-weight:800; margin-bottom:8px;">Top 5 Penjualan (periode)</div>
          <!-- Placeholder: nanti bisa diganti Canvas/Chart.js -->
        </div>
        <div class="chart-box">
          <div style="font-weight:800; margin-bottom:8px;">Komposisi Penjualan per Kategori</div>
          <!-- Placeholder: Pie/Doughnut -->
        </div>
      </div>
    </div>

  </div>
</body>
</html>

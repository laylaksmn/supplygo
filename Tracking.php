<?php
session_start();
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Pengguna';

require_once 'db.php';

// TOTAL PENJUALAN = SUM(price * sold)
$sqlTotal = "SELECT SUM(price * sold) AS total_penjualan FROM products";
$resTotal = $mysqli->query($sqlTotal);
$rowTotal = $resTotal ? $resTotal->fetch_object() : null;
$total_penjualan = $rowTotal && $rowTotal->total_penjualan ? (int)$rowTotal->total_penjualan : 0;

// BARANG TERJUAL = SUM(sold)
$sqlSold = "SELECT SUM(sold) AS barang_terjual FROM products";
$resSold = $mysqli->query($sqlSold);
$rowSold = $resSold ? $resSold->fetch_object() : null;
$barang_terjual = $rowSold && $rowSold->barang_terjual ? (int)$rowSold->barang_terjual : 0;

// PRODUK AKTIF = COUNT(*)
$sqlActive = "SELECT COUNT(*) AS produk_aktif FROM products";
$resActive = $mysqli->query($sqlActive);
$rowActive = $resActive ? $resActive->fetch_object() : null;
$produk_aktif = $rowActive && $rowActive->produk_aktif ? (int)$rowActive->produk_aktif : 0;

// AMBIL DATA PRODUK
$sqlProducts = "SELECT * FROM products ORDER BY id DESC";
$resultProducts = $mysqli->query($sqlProducts);

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
  <header class="navbar">
    <div class="brand">
      <img src="logo web.png" alt="Logo" class="logo">
      <span class="brand-name">SUPPLYGO</span>
    </div>
    <div class="menu">
      <a href="dashboard.php">Home</a>
      <a href="market.php">Market</a>
      <a href="transport.php">Transport</a>
      <a href="tracking.php" class="active">Tracking</a>
      <a href="history.php">History</a>
    </div>
</header>

  <div class="main">
    <div class="header" style="justify-content:space-between; align-items:center;">
      <div>
        <h1>Inventory &amp; Sales Tracker</h1>
      </div>
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
        <p class="mono">
          Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?>
        </p>
        <!-- Persentase masih dummy -->
        <div style="color:#059669; font-weight:800; font-size:12px; margin-top:6px;">
          ▲ +15% vs kemarin
        </div>
      </div>
      <div class="stat-card">
        <h3>BARANG TERJUAL</h3>
        <p class="mono">
          <?php echo $barang_terjual; ?> pcs
        </p>
        <div style="color:#059669; font-weight:800; font-size:12px; margin-top:6px;">
          ▲ +9% vs periode lalu
        </div>
      </div>
      <div class="stat-card">
        <h3>PRODUK AKTIF</h3>
        <p class="mono">
          <?php echo $produk_aktif; ?>
        </p>
        <div style="color:#6b7280; font-weight:800; font-size:12px; margin-top:6px;">
          Dalam Katalog
        </div>
      </div>
    </div>

    <!-- TABEL PRODUK -->
    <div class="wrap" style="margin-bottom:26px;">
      <div class="toolbar chips--light">
        <div class="search">
          <input type="search" placeholder="Cari Produk / SKU">
        </div>
        <a href="produk/product_create.php" class="chip">+ Tambah Produk</a>
        <button class="chip" aria-pressed="true">Semua</button>
        <button class="chip">Stok Rendah</button>
        <button class="chip">Terlaris</button>
      </div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>PRODUK</th>
              <th>KATEGORI</th>
              <th>HARGA</th>
              <th>STOK</th>
              <th>TERJUAL</th>
              <th>STATUS</th>
              <th>LEVEL</th>
              <th>AKSI</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!$resultProducts || $resultProducts->num_rows == 0):
            ?>
              <tr>
                <td colspan="9">Belum ada produk di database.</td>
              </tr>
            <?php
            else:
              while ($p = $resultProducts->fetch_object()):
                // class badge dari status
                $badgeClass = 'ok';
                if ($p->status === 'Menipis') {
                  $badgeClass = 'warn';
                } elseif ($p->status === 'Habis') {
                  $badgeClass = 'danger';
                }

                // level stok (0–100) untuk progress bar
                $level = (int)$p->stock;
                if ($level < 0) $level = 0;
                if ($level > 100) $level = 100;
            ?>
              <tr>
                <td><?php echo $p->name; ?></td>
                <td><?php echo $p->category; ?></td>
                <td class="mono">
                  <?php echo number_format($p->price, 0, ',', '.'); ?>
                </td>
                <td class="mono"><?php echo $p->stock; ?></td>
                <td class="mono"><?php echo $p->sold; ?></td>
                <td>
                  <span class="badge <?php echo $badgeClass; ?>">
                    <?php echo $p->status; ?>
                  </span>
                </td>
                <td>
                  <div class="stockbar">
                    <i style="--w:<?php echo $level; ?>%"></i>
                  </div>
                </td>
                <td class="action-cell">
                  <a href="produk/product_edit.php?id=<?php echo $p->id; ?>" class="action-edit">
                    Edit
                  </a>
                  <form action="produk/product_delete.php" method="post" style="display:inline;"
                        onsubmit="return confirm('Yakin hapus produk ini?');">
                    <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                    <button type="submit" class="action-delete">
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>
            <?php
              endwhile;
            endif;
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- GRAFIK & RINGKASAN (masih placeholder) -->
    <div class="wrap">
      <h2 style="margin:0 0 14px; font-size:28px; line-height:1;">Grafik &amp; Ringkasan</h2>
      <div class="charts">
        <div class="chart-box">
          <div style="font-weight:800; margin-bottom:8px;">Top 5 Penjualan (periode)</div>
        </div>
        <div class="chart-box">
          <div style="font-weight:800; margin-bottom:8px;">Komposisi Penjualan per Kategori</div>
        </div>
      </div>
    </div>

  </div>
</body>
</html>


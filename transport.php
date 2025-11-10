<?php
session_start();
include 'auth.php';
include_once 'conn.php';

// Pastikan user login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

// Statistik kendaraan
$totalKendaraan = $mysqli->query("SELECT COUNT(*) as total FROM kendaraan")->fetch_assoc()['total'];
$tersedia = $mysqli->query("SELECT COUNT(*) as total FROM kendaraan WHERE status = 'Tersedia'")->fetch_assoc()['total'];
$dalamPerjalanan = $mysqli->query("SELECT COUNT(*) as total FROM kendaraan WHERE status = 'Dalam Perjalanan'")->fetch_assoc()['total'];

// Ambil semua kendaraan
$kendaraanQuery = "SELECT * FROM kendaraan ORDER BY kendaraan_id DESC";
$kendaraanResult = $mysqli->query($kendaraanQuery);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transport Management - SUPPLYGO</title>
  <link rel="stylesheet" href="transport.css">
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
        <a href="market.php">Market</a>
        <a href="transport.php" class="active">Transport</a>
        <a href="tracking.php">Tracking</a>
        <a href="history.php">History</a>
        <a href="logout.php" class="logout"><button>Log out</button></a>
      </nav>
    </div>
  </header>

  <main>
    <div class="content-wrapper">
      <div class="page-header">
        <h1>Transport Management</h1>
        <p>Manage and track all vehicles in your fleet</p>
      </div>

      <!-- Statistik -->
      <div class="stats-container">
        <div class="stat-card">
          <h3>Total Kendaraan</h3>
          <p class="stat-number orange"><?php echo $totalKendaraan; ?></p>
        </div>
        <div class="stat-card">
          <h3>Tersedia</h3>
          <p class="stat-number green"><?php echo $tersedia; ?></p>
        </div>
        <div class="stat-card">
          <h3>Dalam Perjalanan</h3>
          <p class="stat-number blue"><?php echo $dalamPerjalanan; ?></p>
        </div>
      </div>

      <!-- Filter -->
      <div class="filter-section">
        <div class="filters">
          <select id="filterStatus" class="filter-select">
            <option value="">Semua Status</option>
            <option value="Tersedia">Tersedia</option>
            <option value="Dalam Perjalanan">Dalam Perjalanan</option>
          </select>

          <select id="filterTipe" class="filter-select">
            <option value="">Semua Tipe</option>
            <option value="Truck">Truck</option>
            <option value="Van">Van</option>
            <option value="Pickup">Pickup</option>
          </select>
        </div>
        <button class="btn-add" onclick="window.location.href='tambah_kendaraan.php'">+ Tambah Kendaraan</button>
      </div>

      <!-- Grid kendaraan -->
      <div class="vehicle-grid">
        <?php while($kendaraan = $kendaraanResult->fetch_assoc()): ?>
        <div class="vehicle-card" data-status="<?php echo $kendaraan['status']; ?>" data-tipe="<?php echo $kendaraan['type']; ?>">
          <div class="vehicle-image">
            <img src="<?php echo $kendaraan['kendaraan_image_path'] ?: 'truck-placeholder.png'; ?>" alt="<?php echo $kendaraan['name']; ?>">
          </div>
          <div class="vehicle-info">
            <div class="vehicle-header">
              <h3><?php echo $kendaraan['name']; ?></h3>
              <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $kendaraan['status'])); ?>">
                <?php echo $kendaraan['status']; ?>
              </span>
            </div>
            <p class="vehicle-type"><?php echo $kendaraan['type']; ?></p>
            <div class="vehicle-details">
              <div class="detail-row"><span class="label">Kapasitas:</span> <span class="value"><?php echo $kendaraan['capacity']; ?></span></div>
              <div class="detail-row"><span class="label">Pengemudi:</span> <span class="value"><?php echo $kendaraan['driver'] ?: 'Belum ditentukan'; ?></span></div>
              <div class="detail-row"><span class="label">Estimasi Tiba:</span> <span class="value"><?php echo $kendaraan['estimation'] ?: '-'; ?></span></div>
            </div>
            <div class="vehicle-actions">
              <button class="btn-detail" onclick="window.location.href='detail_kendaraan.php?id=<?php echo $kendaraan['kendaraan_id']; ?>'">Lihat Detail</button>
              <button class="btn-locate">Lacak</button>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </main>

  <script>
    const filterStatus = document.getElementById('filterStatus');
    const filterTipe = document.getElementById('filterTipe');
    const vehicleCards = document.querySelectorAll('.vehicle-card');

    function applyFilters() {
      const statusValue = filterStatus.value;
      const tipeValue = filterTipe.value;

      vehicleCards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        const cardTipe = card.getAttribute('data-tipe');

        const matchStatus = !statusValue || cardStatus === statusValue;
        const matchTipe = !tipeValue || cardTipe === tipeValue;

        card.style.display = (matchStatus && matchTipe) ? 'block' : 'none';
      });
    }

    filterStatus.addEventListener('change', applyFilters);
    filterTipe.addEventListener('change', applyFilters);
  </script>
</body>
</html>

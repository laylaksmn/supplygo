<?php
include 'auth.php';
include_once 'conn.php';

$user = $_SESSION['user'];
$result = $mysqli->query("SELECT * FROM user WHERE email = '$user'");
$userData = $result->fetch_assoc();
$name = $userData['name'];

// Query untuk mendapatkan statistik kendaraan
$totalKendaraan = $mysqli->query("SELECT COUNT(*) as total FROM kendaraan")->fetch_assoc()['total'];
$tersedia = $mysqli->query("SELECT COUNT(*) as total FROM kendaraan WHERE status = 'Tersedia'")->fetch_assoc()['total'];
$dalamPerjalanan = $mysqli->query("SELECT COUNT(*) as total FROM kendaraan WHERE status = 'Dalam Perjalanan'")->fetch_assoc()['total'];

// Query untuk mendapatkan semua kendaraan
$kendaraanQuery = "SELECT * FROM kendaraan ORDER BY id DESC";
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
        <a href="transport.php" class="active">Transport</a>
        <a href="tracking.php">Tracking</a>
        <a href="history.php">History</a>
      </nav>
    </div>
  </header>

  <main>
    <div class="content-wrapper">
      <div class="page-header">
        <h1>Transport Management</h1>
        <p>Manage and track all vehicles in your fleet</p>
      </div>

      <!-- Statistics Cards -->
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

      <!-- Filter Section -->
      <div class="filter-section">
        <div class="filters">
          <select id="filterStatus" class="filter-select">
            <option value="">Semua Status</option>
            <option value="Tersedia">Tersedia</option>
            <option value="Dalam Perjalanan">Dalam Perjalanan</option>
          </select>

          <select id="filterKendaraan" class="filter-select">
            <option value="">Cari kendaraan</option>
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

      <!-- Vehicle Grid -->
      <div class="vehicle-grid">
        <?php while($kendaraan = $kendaraanResult->fetch_assoc()): ?>
        <div class="vehicle-card" data-status="<?php echo $kendaraan['status']; ?>" data-tipe="<?php echo $kendaraan['tipe']; ?>">
          <div class="vehicle-image">
            <img src="<?php echo $kendaraan['image_path'] ? $kendaraan['image_path'] : 'truck-placeholder.png'; ?>" alt="<?php echo $kendaraan['nama']; ?>">
          </div>
          <div class="vehicle-info">
            <div class="vehicle-header">
              <h3><?php echo $kendaraan['nama']; ?></h3>
              <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $kendaraan['status'])); ?>">
                <?php echo $kendaraan['status']; ?>
              </span>
            </div>
            <p class="vehicle-type"><?php echo $kendaraan['tipe']; ?></p>
            <div class="vehicle-details">
              <div class="detail-row">
                <span class="label">Kapasitas:</span>
                <span class="value"><?php echo $kendaraan['kapasitas']; ?></span>
              </div>
              <div class="detail-row">
                <span class="label">Pengemudi:</span>
                <span class="value"><?php echo $kendaraan['pengemudi'] ? $kendaraan['pengemudi'] : 'Belum ditentukan'; ?></span>
              </div>
              <div class="detail-row">
                <span class="label">Estimasi Tiba:</span>
                <span class="value"><?php echo $kendaraan['estimasi_tiba'] ? $kendaraan['estimasi_tiba'] : '-'; ?></span>
              </div>
            </div>
            <div class="vehicle-actions">
              <button class="btn-detail" onclick="window.location.href='detail_kendaraan.php?id=<?php echo $kendaraan['id']; ?>'">Lihat Detail</button>
              <button class="btn-locate">Lacak</button>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </main>

  <script>
    // Filter functionality
    const filterStatus = document.getElementById('filterStatus');
    const filterTipe = document.getElementById('filterTipe');
    const vehicleCards = document.querySelectorAll('.vehicle-card');

    function applyFilters() {
      const statusValue = filterStatus.value;
      const tipeValue = filterTipe.value;

      vehicleCards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        const cardTipe = card.getAttribute('data-tipe');
        
        const statusMatch = !statusValue || cardStatus === statusValue;
        const tipeMatch = !tipeValue || cardTipe === tipeValue;

        if (statusMatch && tipeMatch) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    }

    filterStatus.addEventListener('change', applyFilters);
    filterTipe.addEventListener('change', applyFilters);
  </script>
</body>
</html>
<?php
include 'auth.php';
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];
    $driver = $_POST['driver'];
    $status = $_POST['status'];
    $estimation = $_POST['estimation'];

    // upload gambar
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
    $targetFile = $targetDir . basename($_FILES["kendaraan_image"]["name"]);
    move_uploaded_file($_FILES["kendaraan_image"]["tmp_name"], $targetFile);

    $query = "INSERT INTO kendaraan (name, type, capacity, driver, status, estimation, kendaraan_image_path)
              VALUES ('$name', '$type', '$capacity', '$driver', '$status', '$estimation', '$targetFile')";
    if ($mysqli->query($query)) {
        header("Location: transport.php");
        exit();
    } else {
        echo "Gagal menyimpan data: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kendaraan - SUPPLYGO</title>
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
        <h1>Tambah Kendaraan Baru</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="form-add">
            <label>Nama Kendaraan:</label>
            <input type="text" name="name" required>

            <label>Tipe Kendaraan:</label>
            <select name="type" required>
                <option value="Truck">Truck</option>
                <option value="Van">Van</option>
                <option value="Pickup">Pickup</option>
            </select>

            <label>Kapasitas:</label>
            <input type="text" name="capacity" required>

            <label>Pengemudi:</label>
            <input type="text" name="driver">

            <label>Status:</label>
            <select name="status" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Dalam Perjalanan">Dalam Perjalanan</option>
            </select>

            <label>Estimasi Tiba:</label>
            <input type="text" name="estimation">

            <label>Foto Kendaraan:</label>
            <input type="file" name="kendaraan_image" accept="image/*">

            <button type="submit" class="btn-save">Simpan</button>
            <button type="button" class="btn-cancel" onclick="window.location.href='transport.php'">Batal</button>
        </form>
    </div>
</main>
</body>
</html>

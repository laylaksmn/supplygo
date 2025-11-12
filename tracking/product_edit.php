<?php
include '../auth.php';
include_once '../conn.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
  header('Location: ../tracking.php');
  exit;
}

$res = $mysqli->query("SELECT * FROM products WHERE id=$id");
if (!$res || !$res->num_rows) {
  header('Location: ../tracking.php');
  exit;
}
$p = $res->fetch_object();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>
  <link rel="stylesheet" href="../tracking.css">
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <img src="../logo web.png" alt="Logo" class="logo-img">
        <h2>SUPPLYGO</h2>
      </div>
      <nav>
        <a href="../dashboard.php">Home</a>
        <a href="../market.php">Market</a>
        <a href="../transport.php">Transport</a>
        <a href="../tracking.php" class="active">Tracking</a>
        <a href="../history.php">History</a>
        <a href="../logout.php" class="logout"><button>Log out</button></a>
      </nav>
    </div>
  </header>

  <main class="form-page">
    <section class="section form-section">
      <h2>Edit Produk</h2>

      <?php if (isset($_GET['invalid'])): ?>
        <div class="alert alert-error">Harap lengkapi formulir.</div>
      <?php endif; ?>

      <form action="product_edit_process.php" method="post" class="form-card">
        <input type="hidden" name="id" value="<?= $p->id ?>">

        <div class="form-row">
          <label for="name">Nama</label>
          <input type="text" id="name" name="name" value="<?= $p->name ?>" autofocus>
        </div>

        <div class="form-row">
          <label for="category">Kategori</label>
          <input type="text" id="category" name="category" value="<?= $p->category ?>">
        </div>

        <div class="form-row">
          <label for="price">Harga (Rp)</label>
          <input type="number" id="price" name="price" min="0" value="<?= (int)$p->price ?>" required>
        </div>

        <div class="form-row">
          <label for="stock">Stok</label>
          <input type="number" id="stock" name="stock" min="0" value="<?= (int)$p->stock ?>" required>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn">Simpan Perubahan</button>
          <a href="../tracking.php" class="btn btn-ghost">Batal</a>
        </div>
      </form>
    </section>
  </main>

</body>
</html>

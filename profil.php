<?php
include 'auth.php';

if (!isset($_SESSION['fullname'])) {
  $_SESSION['fullname'] = "Nama";
}
if (!isset($_SESSION['bio'])) {
  $_SESSION['bio'] = "Tambahkan bio";
}
if (!isset($_SESSION['address'])) {
  $_SESSION['address'] = "Tambahkan alamat";
}

$uploadDir = 'uploadsPP/';
if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0755, true);
}

if (!isset($_SESSION['profilepicture']) || empty($_SESSION['profilepicture'])) {
  $_SESSION['profilepicture'] = $uploadDir . 'defaultprofile.jpg';
}

$profilepicture = $_SESSION['profilepicture'];

// kalau file dihapus manual, fallback ke default
if (!file_exists($profilepicture)) {
  $profilepicture = $uploadDir . 'defaultprofile.jpg';
}

// --------------------------
// LOGIKA FORM POST
// --------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  // kalau tombol delete ditekan
  if (isset($_POST['delete_profile'])) {
    if ($_SESSION['profilepicture'] !== $uploadDir . 'defaultprofile.jpg') {
      @unlink($_SESSION['profilepicture']); // hapus file
    }
    $_SESSION['profilepicture'] = $uploadDir . 'defaultprofile.jpg';
    header("Location: profil.php");
    exit();
  }

  // update nama, bio, alamat
  if (isset($_POST['fullname'])) {
      $_SESSION['fullname'] = $_POST['fullname'];
  }
  if (isset($_POST['bio'])) {
      $_SESSION['bio'] = $_POST['bio'];
  }
  if (isset($_POST['address'])) {
      $_SESSION['address'] = $_POST['address'];
  }

  // upload foto baru
  if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['error'] === UPLOAD_ERR_OK) {
      $fileTmpPath = $_FILES['profilepicture']['tmp_name'];
      $fileName = time() . '_' . $_FILES['profilepicture']['name']; // biar unik
      $save = $uploadDir . $fileName;
      move_uploaded_file($fileTmpPath, $save);

      // hapus foto lama kalau bukan default
      if ($_SESSION['profilepicture'] !== $uploadDir . 'defaultprofile.jpg') {
        @unlink($_SESSION['profilepicture']);
      }

      $_SESSION['profilepicture'] = $save;
  }

  header("Location: profil.php");
  exit();
}

$fullname = $_SESSION['fullname'];
$bio = $_SESSION['bio'];
$address = $_SESSION['address'];
$profilepicture = $_SESSION['profilepicture'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="stylesheet" href="profil.css">
</head>
<body>
  <header>
    <h2>Profile - <?php echo $_SESSION['user']; ?></h2>
    <nav>
      <a href="dashboard.php">Home</a>
      <a href="#">Order</a>
      <a href="profil.php">Account</a>
      <a href="logout.php" class="logout"><button>Logout</button></a>
    </nav>
  </header>

  <main>
    <div class="profile-container">
      <form action="profil.php" method="post" enctype="multipart/form-data">
  <img src="<?= $profilepicture ?>" id="profilepicturepreview" alt="TAMBAH PROFIL" />
  <input type="file" name="profilepicture" id="profilepicture" style="display:none;" accept="image/*" /><br>

  <label for="fullname">Name</label><br>
  <input type="text" id="fullname" name="fullname" value="<?= $fullname ?>"><br>

  <label for="bio">Bio</label><br>
  <textarea id="bio" name="bio"><?= $bio ?></textarea><br>

  <label for="address">Address</label><br>
  <textarea id="address" name="address"><?= $address ?></textarea><br>

  <button type="submit" id="edit">Save Profile</button>

  <div class="photo-actions">
    <button type="submit" name="delete_profile" id="deletephoto" class="delete-btn">Hapus Foto Profil</button>
    <button type="button" id="addphoto" class="add-btn">Tambah / Ganti Foto Profil</button>
  </div>
</form>

    </div>
  </main>

  <script>
    const file = document.getElementById('profilepicture');
    const preview = document.getElementById('profilepicturepreview');
    const addphoto = document.getElementById('addphoto');

    addphoto.addEventListener('click', () => {
      file.click();
    });

    file.addEventListener('change', (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>
</html>

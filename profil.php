<?php
include 'auth.php';

if (!isset($_SESSION['nama'])) {
  $_SESSION['nama'] = isset($_SESSION['name']) ? $_SESSION['name'] : "Nama";
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

if (!isset($_SESSION['profilepicture'])) {
  $_SESSION['profilepicture'] = $uploadDir . 'defaultprofile.jpg';
}

$profilepicture = $_SESSION['profilepicture'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['delete_profile'])) {
    if ($_SESSION['profilepicture'] !== $uploadDir . 'defaultprofile.jpg') {
      @unlink($_SESSION['profilepicture']);
    }
    $_SESSION['profilepicture'] = $uploadDir . 'defaultprofile.jpg';
    header("Location: profil.php");
    exit();
  }

  if (isset($_POST['nama'])) {
      $_SESSION['nama'] = $_POST['nama'];
  }
  if (isset($_POST['bio'])) {
      $_SESSION['bio'] = $_POST['bio'];
  }
  if (isset($_POST['address'])) {
      $_SESSION['address'] = $_POST['address'];
  }

  if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['error'] === UPLOAD_ERR_OK) {
      $fileTmpPath = $_FILES['profilepicture']['tmp_name'];
      $fileName = time() . '_' . $_FILES['profilepicture']['name'];
      $save = $uploadDir . $fileName;
      move_uploaded_file($fileTmpPath, $save);

      if ($_SESSION['profilepicture'] !== $uploadDir . 'defaultprofile.jpg') {
        @unlink($_SESSION['profilepicture']);
      }

      $_SESSION['profilepicture'] = $save;
  }

  header("Location: profil.php");
  exit();
}

$nama = $_SESSION['nama'];
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
    <h2>Profile - <?php echo $_SESSION['nama']; ?></h2>
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

  <label for="nama">Name</label><br>
  <input type="text" id="nama" name="nama" value="<?= $nama ?>"><br>

  <label for="bio">Bio</label><br>
  <textarea id="bio" name="bio"><?= $bio ?></textarea><br>

  <label for="address">Address</label><br>
  <textarea id="address" name="address"><?= $address ?></textarea><br>

  <div class="photo-actions">
    <button type="submit" name="delete_profile" id="deletephoto" class="delete-btn">Delete Photo Profile</button>
    <button type="button" id="addphoto" class="add-btn">Change Photo Profile</button>
  </div>
  <button type="submit" id="edit">Save Profile</button>
</form>

    </div>
  </main>

  <script>
    const file = document.getElementById('profilepicture');
    const preview = document.getElementById('profilepicturepreview');
    const addphoto = document.getElementById('addphoto');

    // addphoto.addEventListener('click', () => {
    //   file.click();
    // });

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
<?php include 'auth.php'; 
  if (!isset($_SESSION['fullname'])) {
    $_SESSION['fullname'] = "Nama";
  }
  if (!isset($_SESSION['bio'])) {
    $_SESSION['bio'] = "Tambahkan bio";
  }
  if (!isset($_SESSION['address'])) {
    $_SESSION['address'] = "Tambahkan alamat";
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fullname'])) {
        $_SESSION['fullname'] = $_POST['fullname'];
    }
    if (isset($_POST['bio'])) {
        $_SESSION['bio'] = $_POST['bio'];
    }
    if (isset($_POST['address'])) {
        $_SESSION['address'] = $_POST['address'];
    }
     if (isset($_FILES['profilepicture'])) {
        $fileTmpPath = $_FILES['profilepicture']['tmp_name'];
        $fileName = $_FILES['profilepicture']['name'];
        $upload = 'uploadsPP/';
        if (!is_dir($upload)) {
            mkdir($upload, 0755, true);
        }
        $save = $upload . $fileName;
        move_uploaded_file($fileTmpPath, $save);
        $_SESSION['profilepicture'] = $save;
    }
    header("Location: profil.php");
    exit();
  }
  $fullname = $_SESSION['fullname'];
  $bio = $_SESSION['bio'];
  $address = $_SESSION['address'];
  $profilepicture = isset($_SESSION['profilepicture']) ? $_SESSION['profilepicture'] : 'defaultprofile.jpg';
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
    <div class="profile-container" >
      <form action="profil.php" method="post" enctype="multipart/form-data" >
        <img src="<?= $profilepicture ?>" id="profilepicturepreview" />
        <input type="file" name="profilepicture" id="profilepicture" style="display:none;" accept="image/*" /></br>
        <label for="fullname">Name</label></br>
        <input type="text" id="fullname" name="fullname" value="<?= $fullname ?>" ></br>
        <label for="bio">Bio</label></br>
        <textarea id="bio" name="bio" ><?= $bio ?></textarea></br>
        <label for="address">Address</label></br>
        <textarea id="address" name="address" ><?= $address ?></textarea></br>

        <button type="submit" id="edit" >Save Profile</button>
      </form>
    </div>
  </main>
</body>
<script>
    const file = document.getElementById('profilepicture');
    const preview = document.getElementById('profilepicturepreview');
    preview.addEventListener('click', () => {
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
</html>

<?php
include 'auth.php';

  $uploadDir = './uploadsPP/';
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
  }

  include_once 'conn.php';
  $user = $_SESSION['user'];
  $result = $mysqli->query("SELECT * FROM user WHERE email = '$user'");
  $userData = $result->fetch_assoc();
  $name = $userData['name'];
  $profilepicture = $userData['imagepath'];
  $bio = !empty($userData['bio']) ? $userData['bio'] : 'Add bio';
  $address = !empty($userData['address']) ? $userData['address'] : 'Add your address';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = addslashes(trim($_POST['name']));
  $bio = addslashes(trim($_POST['bio']));
  $address = addslashes(trim($_POST['address']));
  $save = $profilepicture;

  if (isset($_POST['deletephoto'])) {
    $save = $uploadDir . 'defaultprofile.jpg';
  } else if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['error'] === UPLOAD_ERR_OK) {
      $fileTmpPath = $_FILES['profilepicture']['tmp_name'];
      $fileName = time() . '_' . $_FILES['profilepicture']['name'];
      $save = $uploadDir . $fileName;
      move_uploaded_file($fileTmpPath, $save);
  }

  $stmt = $mysqli->prepare("UPDATE user SET name=?, bio=?, address=?, imagepath=? WHERE email=?");
  $stmt->bind_param("sssss", $name, $bio, $address, $save, $user);
  $stmt->execute();
  $stmt->close();

  header("Location: profil.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SUPPLGO - <?= $name ?></title>
  <link rel="stylesheet" href="profil.css">
</head>
<body>
  <header>
    <h2>SUPPLYGO</h2>
    <nav>
      <a href="dashboard.php">Home</a>
      <a href="#">Order</a>
      <a href="profil.php">Profile</a>
      <a href="logout.php" class="logout"><button>Log out</button></a>
    </nav>
  </header>

  <main>
    <div class="profile-container">
      <form action="profil.php" method="post" enctype="multipart/form-data">
      <img src="<?= $profilepicture ?>" id="profilepicturepreview" />
      <input type="file" name="profilepicture" id="profilepicture" style="display:none;" accept="image/*" /><br>

      <label for="name">Name</label><br>
      <input type="text" id="name" name="name" value="<?= $name ?>"><br>

      <label for="bio">Bio</label><br>
      <textarea id="bio" name="bio"><?= $bio ?></textarea><br>

      <label for="address">Address</label><br>
      <textarea id="address" name="address"><?= $address ?></textarea><br>

      <div class="photo-actions" style="display:none;">
        <button type="button" id="addphoto" class="add-btn">Change Photo Profile</button>
        <button type="submit" name="deletephoto" id="deletephoto" class="delete-btn">Delete Photo Profile</button>
      </div>
      <button type="submit" id="edit" class="edit">Save Changes</button>
      </form>

    </div>
  </main>

  <script>
    const file = document.getElementById('profilepicture');
    const preview = document.getElementById('profilepicturepreview');
    const actions = document.querySelector('.photo-actions');
    const addphoto = document.getElementById('addphoto');

    preview.addEventListener('click', () => {
    actions.style.display = 'block';
    });
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

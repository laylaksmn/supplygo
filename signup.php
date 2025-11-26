<?php 
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'conn.php';
    // Menggunakan Prepared Statement (lebih aman)
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password_raw  = $_POST['password']; // Password mentah
    $confirmPassword = $_POST['confirmPassword'];

    $uploadDir = './uploadsPP/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }
    $name = $username;
    $profilepicture = $uploadDir . 'defaultprofile.jpg';

   if ($password_raw !== $confirmPassword) {
    header('Location: signup.php?password=1');
    die;
  }
  
  // 1. Password Hashing (Wajib untuk keamanan!)
  $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);
  
  try {
    // Memasukkan password yang sudah di-hash
    $stmt = $mysqli->prepare("INSERT INTO user (username, email, password, name, imagepath) VALUES (?, ?, ?, ?, ?)");
    // 's' untuk string, ssssb berarti username, email, password_hashed, name, profilepicture adalah string
    $stmt->bind_param("sssss", $username, $email, $password_hashed, $name, $profilepicture);
    $stmt->execute();
    $stmt->close();
  }catch(mysqli_sql_exception $exc){
    if ($mysqli->errno === 1062){
      // 2. Ganti pesan error 'taken'
      header('Location: signup.php?username=1'); 
      die;
    }
  }
  
  // Menggunakan username untuk sesi
  $_SESSION['user'] = $username; 
  header("Location: dashboard.php");
  die;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up - SUPPLYGO</title>
  <link rel="stylesheet" href="signup.css">
</head>
<body>
  <div class="signup-container">
    <h2><span class="black">SIGN</span> <span class="orange">UP</span></h2>
    <form id="signupForm" method="POST" action="">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Create a username" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter password" required>

      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>

      <div class="checkbox">
        <input type="checkbox" id="agree" required>
        <label for="agree">I agree with Terms & Policy</label>
      </div>

      <button type="submit" class="btn-signup">SIGN UP</button>
      <?php if (isset($_GET['username'])): ?>
      <p class="error">Username sudah terdaftar</p>
      <?php endif; ?>
      <?php if (isset($_GET['password'])): ?>
      <p class="error">Password tidak cocok</p>
      <?php endif; ?>

      <p class="login-text"> 
        Already have an account? <a href="login.php">Login</a>
      </p>
    </form>
</body>
</html>

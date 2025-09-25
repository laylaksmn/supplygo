<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validUser = "admin@gmail.com";
    $validPass = "12345";

    $email = $_POST['email'];
    $pass  = $_POST['password'];

    if ($email === $validUser && $pass === $validPass) {
        $_SESSION['user'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Halaman Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="login-container">
    <h2><span class="orange">LOG</span> IN</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post" action="">
      <label>Email</label>
      <input type="email" name="email" required placeholder="Enter your email">

      <label>Password</label>
      <input type="password" name="password" required placeholder="Enter password">

      <div class="options">
        <label><input type="checkbox" name="remember"> Remember Me</label>
        <a href="#">Forgot Password?</a>
      </div>

      <button type="submit" class="btn-login">LOG IN</button>

      <p class="signup-text"> 
        Don't have an account? <a href="signup.php">Create an account</a>
      </p>
    </form>
  </div>
</body>
</html>

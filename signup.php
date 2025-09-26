<?php 
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['fullname'];
    $email = $_POST['email'];
    $pass  = $_POST['password'];
    $confirmPass = $_POST['confirmPassword'];

    if ($confirmPass === $pass) {
        $fileUser = fopen('file.txt', 'a+');
        fwrite($fileUser, "$nama, $email, $pass\n");
        fclose($fileUser);
        $_SESSION['user'] = $email;
        header("Location: dashboard.php");
        exit();
    } else $error = "Passwords didn't match!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="signup.css">
</head>
<body>
  <div class="signup-container">
    <h2><span class="black">SIGN</span> <span class="orange">UP</span></h2>
    <form id="signupForm" method="POST" action="">
      <label for="fullname">Nama Lengkap</label>
      <input type="text" id="fullname" name="fullname" placeholder="Enter your name" required>

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
      <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

      <p class="login-text"> 
        Already have an account? <a href="login.php">Login</a>
      </p>
    </form>
</body>
</html>
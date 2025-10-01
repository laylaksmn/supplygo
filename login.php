<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $fileUser = fopen('file.txt', 'r');
    $users = [];

    while (($line = fgets($fileUser)) !== false) {
        $data = explode(',', trim($line));
        if (count($data) === 3) {
            $users[] = [
                'nama' => trim($data[0]),
                'email' => trim($data[1]),
                'password' => trim($data[2])
            ];
        }
    }
    fclose($fileUser);

    $login = false;
    for ($i = 0; $i < count($users); $i++) {
        if ($users[$i]['email'] === $email && $users[$i]['password'] === $pass) {
            $login = true;
            $_SESSION['user'] = $users[$i]['email'];
            break;
        }
    }

    if ($login) {
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

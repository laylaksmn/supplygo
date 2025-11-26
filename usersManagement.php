<?php
  include_once 'conn.php';
  require_once 'auth.php';
  require_once 'isAdmin.php';
  $users = $mysqli->query("SELECT user_id, username, email, role FROM user");
  $editMode = isset($_GET['mode']) && $_GET['mode'] === 'edit';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateRole = $_POST['role'];
    $currentUser = $_POST['user_id'];
    $stmt = $mysqli->prepare("UPDATE user SET role=? WHERE user_id=?");
    $stmt->bind_param("si", $updateRole, $currentUser);
    $stmt->execute();
    header("Location: usersManagement.php");
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage users - SUPPLYGO</title>
  </head>
  <body>
    <h2>User list</h2>
    <table>
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
      </tr>
      <?php foreach ($users as $user): ?>
              <tr>
                <td><?= $user['user_id'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <?php if (!$editMode): ?>
                  <td><?= $user['role'] ?></td>
                  <td><a href="?mode=edit"><button>Edit</button></a></td>
                <?php else: ?>
                  <form method="POST" action="usersManagement.php">
                    <td>
                      <select name="role">
                        <option value="admin" <?= $user['role']==='admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="customer" <?= $user['role']==='customer' ? 'selected' : '' ?>>Customer</option>
                      </select>
                      <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                    </td>
                    <td><button type="submit">Save</button></td>
                  </form>
                <?php endif; ?>
              </tr>
      <?php endforeach; ?>
    </table>
  </body>
</html>
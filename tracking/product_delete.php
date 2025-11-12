<?php
include '../auth.php';
include_once '../conn.php';


$id = (int)($_POST['id'] ?? 0);
if (!$id) { header('Location: ../tracking.php'); exit; }


$mysqli->query("DELETE FROM products WHERE id=$id");
header('Location: ../tracking.php');
exit;
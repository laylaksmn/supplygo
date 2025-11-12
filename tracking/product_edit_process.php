<?php
include '../auth.php';
include_once '../conn.php';

$id  = (int)($_POST['id'] ?? 0);
$raw_name = trim($_POST['name'] ?? '');
$raw_category = trim($_POST['category'] ?? '');
$price = (int)($_POST['price'] ?? 0);
$stock = (int)($_POST['stock'] ?? 0);

if ($id <= 0 || $raw_name === '' || $raw_category === '') {
  header('Location: product_edit.php?id=' . $id . '&invalid=1');
  exit;
}

$name = mysqli_real_escape_string($mysqli, $raw_name);
$category = mysqli_real_escape_string($mysqli, $raw_category);

$sql = "UPDATE products 
        SET name='$name', category='$category', price=$price, stock=$stock 
        WHERE id=$id";

if ($mysqli->query($sql)) {
  header('Location: ../tracking.php');
  exit;
} else {
  header('Location: product_edit.php?id=' . $id . '&error=1');
  exit;
}

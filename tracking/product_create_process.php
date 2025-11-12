<?php
include '../auth.php';
include_once '../conn.php';

$raw_name = trim($_POST['name'] ?? '');
$raw_category = trim($_POST['category'] ?? '');
$price = (int)($_POST['price'] ?? 0);
$stock = (int)($_POST['stock'] ?? 0);

if ($raw_name === '' || $raw_category === '') {
  header('Location: product_create.php?invalid=1');
  exit;
}

$name     = mysqli_real_escape_string($mysqli, $raw_name);
$category = mysqli_real_escape_string($mysqli, $raw_category);

$sql = "INSERT INTO products (name, category, price, stock, sold) 
        VALUES ('$name', '$category', $price, $stock, 0)";

if ($mysqli->query($sql)) {
  header('Location: ../tracking.php');
  exit;
} else {
  header('Location: product_create.php?error=1');
  exit;
}

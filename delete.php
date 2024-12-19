<?php
include 'config.php';
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM barang WHERE id = ?");
$stmt->execute([$id]);
header("Location: index.php");
?>

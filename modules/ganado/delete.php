<?php
require '../../config/database.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM ganado WHERE id_ganado = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;

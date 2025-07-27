<?php
$host = 'localhost';
$db = 'loginapp';
$user = 'root';      // Ganti jika berbeda
$pass = '';          // Ganti jika berbeda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
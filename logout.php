<?php
session_start();
require 'config.php';
require 'remember_functions.php';

// Hapus remember token jika ada
if (isset($_SESSION['user_id'])) {
    removeRememberToken($pdo, $_SESSION['user_id']);
}

session_destroy();
header("Location: index.php");
exit;
?>
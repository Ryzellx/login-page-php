<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'config.php';
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Selamat datang, <?= htmlspecialchars($user['username']) ?>!</h2>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>

        <div class="dashboard-actions">
            <a href="change_password.php" class="btn-secondary">Ubah Password</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require 'config.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = 'Semua field harus diisi!';
        $message_type = 'error';
    } elseif ($new_password !== $confirm_password) {
        $message = 'Password baru dan konfirmasi password tidak cocok!';
        $message_type = 'error';
    } elseif (strlen($new_password) < 6) {
        $message = 'Password baru minimal 6 karakter!';
        $message_type = 'error';
    } else {
        // Verifikasi password lama
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (password_verify($current_password, $user['password'])) {
            // Update password baru
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");

            if ($stmt->execute([$hashed_password, $_SESSION['user_id']])) {
                $message = 'Password berhasil diubah!';
                $message_type = 'success';
            } else {
                $message = 'Gagal mengubah password!';
                $message_type = 'error';
            }
        } else {
            $message = 'Password lama tidak benar!';
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ubah Password</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Ubah Password</h2>

        <?php if ($message): ?>
            <div class="message <?= $message_type ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="password" name="current_password" placeholder="Password Lama" required>
            <input type="password" name="new_password" placeholder="Password Baru" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" required>
            <button type="submit">Ubah Password</button>
        </form>

        <div class="links">
            <a href="dashboard.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>

</html>
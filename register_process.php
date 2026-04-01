<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

require_once 'db.php';

$username         = trim($_POST['username']         ?? '');
$password         = $_POST['password']              ?? '';
$confirm_password = $_POST['confirm_password']      ?? '';

function redirect_error(string $msg): void {
    $_SESSION['reg_error'] = $msg;
    header('Location: register.php');
    exit;
}

if ($username === '' || $password === '' || $confirm_password === '') {
    redirect_error('Vui lòng điền đầy đủ tất cả các trường.');
}

if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) {
    redirect_error('Tên người dùng chỉ chứa chữ, số, dấu _ và từ 3–50 ký tự.');
}

if (strlen($password) < 8) {
    redirect_error('Mật khẩu phải có ít nhất 8 ký tự.');
}

if ($password !== $confirm_password) {
    redirect_error('Mật khẩu xác nhận không khớp.');
}

try {
    $pdo = getDB();

    $check = $pdo->prepare('SELECT id FROM users WHERE username = :username LIMIT 1');
    $check->execute([':username' => $username]);
    if ($check->fetch()) {
        redirect_error('Tên người dùng "' . htmlspecialchars($username) . '" đã được sử dụng.');
    }

    $hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    $insert = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    $insert->execute([
        ':username' => $username,
        ':password' => $hashed,
    ]);

    $_SESSION['reg_success'] = 'Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.';
    header('Location: register.php');
    exit;

} catch (PDOException $e) {
    redirect_error('Lỗi hệ thống. Vui lòng thử lại sau.');
}
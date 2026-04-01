<?php
// =============================================
// login_process.php – Xử lý đăng nhập
// =============================================
session_start();

// Nếu đã đăng nhập → chuyển hướng
if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}

// Chỉ nhận POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

require_once 'db.php';

// ── Lấy & làm sạch dữ liệu đầu vào ──
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// ── Validate cơ bản ──
if ($username === '' || $password === '') {
    $_SESSION['login_error'] = 'Vui lòng nhập đầy đủ tên người dùng và mật khẩu.';
    header('Location: index.php');
    exit;
}

try {
    $pdo = getDB();

    $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = :username LIMIT 1');
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
       
        session_regenerate_id(true); 
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['login_success'] = true;
        header('Location: welcome.php');
        exit;
    } else {
        $_SESSION['login_error'] = 'Tên người dùng hoặc mật khẩu không chính xác.';
        header('Location: index.php');
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['login_error'] = 'Lỗi hệ thống. Vui lòng thử lại sau.';
    header('Location: index.php');
    exit;
}
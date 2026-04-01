<?php

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="vi">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap"
      rel="stylesheet">
    <style>
    /* ── Reset & Base ── */
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --bg: #0b0c10;
      --panel: #13141a;
      --border: #2a2b35;
      --accent: #e8c97a;
      --accent2: #c8a855;
      --text: #e2e4ee;
      --muted: #6b6f83;
      --danger: #e05c6a;
      --success: #4caf8a;
      --input-bg: #1a1b24;
      --radius: 14px;
      --glow: 0 0 40px rgba(232, 201, 122, .12);
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--bg);
      font-family: 'DM Sans', sans-serif;
      color: var(--text);
      overflow: hidden;
    }

    /* ── Animated background ── */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background:
        radial-gradient(ellipse 60% 50% at 20% 30%, rgba(232, 201, 122, .07) 0%, transparent 70%),
        radial-gradient(ellipse 40% 60% at 80% 70%, rgba(232, 201, 122, .05) 0%, transparent 70%);
      pointer-events: none;
    }

    .grid-bg {
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(255, 255, 255, .025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, .025) 1px, transparent 1px);
      background-size: 48px 48px;
      pointer-events: none;
      mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
    }

    /* ── Card ── */
    .card {
      position: relative;
      width: 420px;
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 48px 40px 44px;
      box-shadow: var(--glow), 0 24px 80px rgba(0, 0, 0, .5);
      animation: rise .6s cubic-bezier(.22, 1, .36, 1) both;
    }

    @keyframes rise {
      from {
        opacity: 0;
        transform: translateY(28px) scale(.97);
      }

      to {
        opacity: 1;
        transform: none;
      }
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 120px;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--accent), transparent);
      border-radius: 2px;
    }

    /* ── Logo mark ── */
    .logo {
      text-align: center;
      margin-bottom: 32px;
    }

    .logo-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 56px;
      height: 56px;
      border-radius: 16px;
      background: linear-gradient(135deg, rgba(232, 201, 122, .18), rgba(232, 201, 122, .05));
      border: 1px solid rgba(232, 201, 122, .25);
      font-size: 24px;
      margin-bottom: 16px;
      box-shadow: 0 0 20px rgba(232, 201, 122, .15);
    }

    .logo h1 {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      font-weight: 700;
      color: var(--text);
      letter-spacing: -.3px;
    }

    .logo p {
      font-size: 13px;
      color: var(--muted);
      margin-top: 4px;
      font-weight: 300;
    }

    /* ── Alerts ── */
    .alert {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 13.5px;
      margin-bottom: 20px;
      animation: fadeIn .3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-6px);
      }

      to {
        opacity: 1;
      }
    }

    .alert-danger {
      background: rgba(224, 92, 106, .12);
      border: 1px solid rgba(224, 92, 106, .3);
      color: #f0818d;
    }

    .alert-success {
      background: rgba(76, 175, 138, .12);
      border: 1px solid rgba(76, 175, 138, .3);
      color: #5fd4a8;
    }

    /* ── Form ── */
    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-size: 12.5px;
      font-weight: 500;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .8px;
      margin-bottom: 8px;
    }

    .input-wrap {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 16px;
      pointer-events: none;
      opacity: .5;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 13px 14px 13px 42px;
      background: var(--input-bg);
      border: 1px solid var(--border);
      border-radius: 10px;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 14.5px;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    input:focus {
      border-color: var(--accent2);
      box-shadow: 0 0 0 3px rgba(232, 201, 122, .12);
    }

    input::placeholder {
      color: var(--muted);
      font-weight: 300;
    }

    .toggle-pass {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 15px;
      opacity: .45;
      color: var(--text);
      transition: opacity .2s;
    }

    .toggle-pass:hover {
      opacity: .9;
    }

    /* ── Submit button ── */
    .btn-primary {
      width: 100%;
      padding: 14px;
      margin-top: 8px;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      border: none;
      border-radius: 10px;
      color: #1a1200;
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      letter-spacing: .2px;
      transition: opacity .2s, transform .15s, box-shadow .2s;
      box-shadow: 0 4px 20px rgba(232, 201, 122, .25);
    }

    .btn-primary:hover {
      opacity: .9;
      transform: translateY(-1px);
      box-shadow: 0 6px 28px rgba(232, 201, 122, .35);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    /* ── Footer link ── */
    .card-footer {
      text-align: center;
      margin-top: 28px;
      font-size: 13.5px;
      color: var(--muted);
    }

    .card-footer a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
      transition: color .2s;
    }

    .card-footer a:hover {
      color: #fff;
    }

    /* ── Divider ── */
    .divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 24px 0;
      color: var(--muted);
      font-size: 12px;
      letter-spacing: .6px;
      text-transform: uppercase;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }
    </style>
  </head>

  <body>
    <div class="grid-bg"></div>

    <div class="card">
      <div class="logo">
        <div class="logo-icon">🔐</div>
        <h1>Đăng Nhập</h1>
        <p>Chào mừng trở lại — vui lòng xác thực</p>
      </div>

      <?php if ($error): ?>
      <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="login_process.php" novalidate>
        <div class="form-group">
          <label for="username">Tên người dùng</label>
          <div class="input-wrap">
            <span class="input-icon">👤</span>
            <input type="text" id="username" name="username" placeholder="Nhập tên người dùng" autocomplete="username"
              required>
          </div>
        </div>

        <div class="form-group">
          <label for="password">Mật khẩu</label>
          <div class="input-wrap">
            <span class="input-icon">🔑</span>
            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu"
              autocomplete="current-password" required>
            <button type="button" class="toggle-pass" onclick="togglePass(this)">👁️</button>
          </div>
        </div>

        <button type="submit" class="btn-primary">Đăng Nhập →</button>
      </form>

      <div class="divider">hoặc</div>

      <div class="card-footer">
        Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
      </div>
    </div>

    <script>
    function togglePass(btn) {
      const input = btn.previousElementSibling;
      if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
      } else {
        input.type = 'password';
        btn.textContent = '👁️';
      }
    }
    </script>
  </body>

</html>
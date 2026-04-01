<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}
$error   = $_SESSION['reg_error']   ?? '';
$success = $_SESSION['reg_success'] ?? '';
unset($_SESSION['reg_error'], $_SESSION['reg_success']);
?>
<!DOCTYPE html>
<html lang="vi">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap"
      rel="stylesheet">
    <style>
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
      --accent: #7ec8e3;
      --accent2: #5aafcc;
      --text: #e2e4ee;
      --muted: #6b6f83;
      --danger: #e05c6a;
      --success: #4caf8a;
      --input-bg: #1a1b24;
      --radius: 14px;
      --glow: 0 0 40px rgba(126, 200, 227, .10);
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--bg);
      font-family: 'DM Sans', sans-serif;
      color: var(--text);
      padding: 24px;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background:
        radial-gradient(ellipse 55% 50% at 25% 25%, rgba(126, 200, 227, .06) 0%, transparent 70%),
        radial-gradient(ellipse 45% 55% at 75% 75%, rgba(126, 200, 227, .05) 0%, transparent 70%);
      pointer-events: none;
    }

    .grid-bg {
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(255, 255, 255, .02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, .02) 1px, transparent 1px);
      background-size: 48px 48px;
      pointer-events: none;
      mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
    }

    .card {
      position: relative;
      width: 460px;
      max-width: 100%;
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
      background: linear-gradient(135deg, rgba(126, 200, 227, .18), rgba(126, 200, 227, .05));
      border: 1px solid rgba(126, 200, 227, .25);
      font-size: 24px;
      margin-bottom: 16px;
      box-shadow: 0 0 20px rgba(126, 200, 227, .15);
    }

    .logo h1 {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      font-weight: 700;
      color: var(--text);
    }

    .logo p {
      font-size: 13px;
      color: var(--muted);
      margin-top: 4px;
    }

    .alert {
      display: flex;
      align-items: flex-start;
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

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    label {
      display: block;
      font-size: 12px;
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
      font-size: 15px;
      pointer-events: none;
      opacity: .45;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px 12px 42px;
      background: var(--input-bg);
      border: 1px solid var(--border);
      border-radius: 10px;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    input:focus {
      border-color: var(--accent2);
      box-shadow: 0 0 0 3px rgba(126, 200, 227, .12);
    }

    input::placeholder {
      color: var(--muted);
      font-weight: 300;
    }

    .strength-bar {
      height: 4px;
      border-radius: 4px;
      background: var(--border);
      margin-top: 8px;
      overflow: hidden;
    }

    .strength-fill {
      height: 100%;
      border-radius: 4px;
      width: 0%;
      transition: width .3s, background .3s;
    }

    .strength-text {
      font-size: 11.5px;
      color: var(--muted);
      margin-top: 5px;
    }

    .toggle-pass {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 14px;
      opacity: .4;
      color: var(--text);
      transition: opacity .2s;
    }

    .toggle-pass:hover {
      opacity: .9;
    }

    .btn-primary {
      width: 100%;
      padding: 14px;
      margin-top: 6px;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      border: none;
      border-radius: 10px;
      color: #071820;
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: opacity .2s, transform .15s, box-shadow .2s;
      box-shadow: 0 4px 20px rgba(126, 200, 227, .2);
    }

    .btn-primary:hover {
      opacity: .9;
      transform: translateY(-1px);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

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

    .card-footer {
      text-align: center;
      font-size: 13.5px;
      color: var(--muted);
    }

    .card-footer a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
    }

    .card-footer a:hover {
      color: #fff;
    }

    .hint {
      font-size: 11.5px;
      color: var(--muted);
      margin-top: 5px;
    }
    </style>
  </head>

  <body>
    <div class="grid-bg"></div>

    <div class="card">
      <div class="logo">
        <div class="logo-icon">✨</div>
        <h1>Đăng Ký</h1>
        <p>Tạo tài khoản mới nhanh chóng</p>
      </div>

      <?php if ($error): ?>
      <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
      <div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <form method="POST" action="register_process.php" novalidate>
        <div class="form-group">
          <label for="username">Tên người dùng</label>
          <div class="input-wrap">
            <span class="input-icon">👤</span>
            <input type="text" id="username" name="username" placeholder="Tối thiểu 3 ký tự" autocomplete="username"
              maxlength="50" required>
          </div>
          <div class="hint">Chỉ dùng chữ, số và dấu gạch dưới (_)</div>
        </div>

        <div class="form-group">
          <label for="password">Mật khẩu</label>
          <div class="input-wrap">
            <span class="input-icon">🔑</span>
            <input type="password" id="password" name="password" placeholder="Tối thiểu 8 ký tự"
              autocomplete="new-password" oninput="checkStrength(this.value)" required>
            <button type="button" class="toggle-pass" onclick="togglePass('password',this)">👁️</button>
          </div>
          <div class="strength-bar">
            <div class="strength-fill" id="strength-fill"></div>
          </div>
          <div class="strength-text" id="strength-text"></div>
        </div>

        <div class="form-group">
          <label for="confirm_password">Xác nhận mật khẩu</label>
          <div class="input-wrap">
            <span class="input-icon">🔒</span>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu"
              autocomplete="new-password" required>
            <button type="button" class="toggle-pass" onclick="togglePass('confirm_password',this)">👁️</button>
          </div>
        </div>

        <button type="submit" class="btn-primary">Tạo Tài Khoản →</button>
      </form>

      <div class="divider">hoặc</div>

      <div class="card-footer">
        Đã có tài khoản? <a href="index.php">Đăng nhập</a>
      </div>
    </div>

    <script>
    function togglePass(id, btn) {
      const inp = document.getElementById(id);
      inp.type = inp.type === 'password' ? 'text' : 'password';
      btn.textContent = inp.type === 'password' ? '👁️' : '🙈';
    }

    function checkStrength(val) {
      const fill = document.getElementById('strength-fill');
      const text = document.getElementById('strength-text');
      let score = 0;
      if (val.length >= 8) score++;
      if (/[A-Z]/.test(val)) score++;
      if (/[0-9]/.test(val)) score++;
      if (/[^A-Za-z0-9]/.test(val)) score++;

      const levels = [{
          pct: '0%',
          color: '#333',
          label: ''
        },
        {
          pct: '25%',
          color: '#e05c6a',
          label: '😟 Yếu'
        },
        {
          pct: '50%',
          color: '#f0a04b',
          label: '😐 Trung bình'
        },
        {
          pct: '75%',
          color: '#7ec8e3',
          label: '😊 Khá'
        },
        {
          pct: '100%',
          color: '#4caf8a',
          label: '💪 Mạnh'
        },
      ];
      const lvl = levels[score];
      fill.style.width = val.length ? lvl.pct : '0%';
      fill.style.background = lvl.color;
      text.textContent = val.length ? lvl.label : '';
    }
    </script>
  </body>

</html>
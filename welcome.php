<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$username = htmlspecialchars($_SESSION['username']);
$showBanner = $_SESSION['login_success'] ?? false;
unset($_SESSION['login_success']);
?>
<!DOCTYPE html>
<html lang="vi">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng – <?= $username ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap"
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
      --gold: #e8c97a;
      --teal: #7ec8e3;
      --text: #e2e4ee;
      --muted: #6b6f83;
      --success: #4caf8a;
    }

    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
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
        radial-gradient(ellipse 50% 40% at 30% 20%, rgba(232, 201, 122, .07) 0%, transparent 70%),
        radial-gradient(ellipse 40% 50% at 70% 80%, rgba(126, 200, 227, .05) 0%, transparent 70%);
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

    /* ── Toast banner ── */
    .toast {
      position: fixed;
      top: 24px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(76, 175, 138, .15);
      border: 1px solid rgba(76, 175, 138, .35);
      color: #5fd4a8;
      padding: 12px 24px;
      border-radius: 40px;
      font-size: 14px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
      backdrop-filter: blur(12px);
      animation: toastIn .5s cubic-bezier(.22, 1, .36, 1) both, toastOut .4s ease 3.5s both;
      z-index: 100;
    }

    @keyframes toastIn {
      from {
        opacity: 0;
        transform: translateX(-50%) translateY(-12px);
      }

      to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
      }
    }

    @keyframes toastOut {
      to {
        opacity: 0;
        transform: translateX(-50%) translateY(-12px);
      }
    }

    /* ── Main card ── */
    .hero {
      text-align: center;
      max-width: 560px;
      animation: rise .7s cubic-bezier(.22, 1, .36, 1) both;
    }

    @keyframes rise {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: none;
      }
    }

    .avatar {
      width: 88px;
      height: 88px;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(232, 201, 122, .2), rgba(126, 200, 227, .15));
      border: 2px solid rgba(232, 201, 122, .3);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 36px;
      margin: 0 auto 28px;
      box-shadow: 0 0 40px rgba(232, 201, 122, .15);
    }

    .greeting {
      font-family: 'Playfair Display', serif;
      font-size: 38px;
      font-weight: 700;
      line-height: 1.15;
      margin-bottom: 14px;
    }

    .greeting span {
      background: linear-gradient(90deg, var(--gold), var(--teal));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .subtitle {
      font-size: 15.5px;
      color: var(--muted);
      font-weight: 300;
      line-height: 1.6;
      margin-bottom: 40px;
    }

    /* ── Info cards ── */
    .cards {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      margin-bottom: 40px;
    }

    .info-card {
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 20px 16px;
      text-align: center;
      transition: border-color .2s, transform .2s;
    }

    .info-card:hover {
      border-color: rgba(232, 201, 122, .3);
      transform: translateY(-3px);
    }

    .info-card .icon {
      font-size: 24px;
      margin-bottom: 8px;
    }

    .info-card .label {
      font-size: 11.5px;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .7px;
    }

    .info-card .value {
      font-size: 15px;
      font-weight: 500;
      margin-top: 4px;
      color: var(--text);
    }

    /* ── Logout button ── */
    .btn-logout {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 13px 32px;
      background: transparent;
      border: 1px solid var(--border);
      border-radius: 40px;
      color: var(--muted);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
      transition: border-color .2s, color .2s, background .2s;
    }

    .btn-logout:hover {
      border-color: rgba(224, 92, 106, .5);
      color: #f0818d;
      background: rgba(224, 92, 106, .07);
    }
    </style>
  </head>

  <body>
    <div class="grid-bg"></div>

    <?php if ($showBanner): ?>
    <div class="toast">✅ Đăng nhập thành công!</div>
    <?php endif; ?>

    <div class="hero">
      <div class="avatar">👋</div>

      <h1 class="greeting">
        Xin chào,<br><span><?= $username ?></span>
      </h1>

      <p class="subtitle">
        Bạn đã đăng nhập thành công vào hệ thống.<br>
        Đây là trang chức năng chính của bạn.
      </p>

      <div class="cards">
        <div class="info-card">
          <div class="icon">🆔</div>
          <div class="label">User ID</div>
          <div class="value">#<?= htmlspecialchars($_SESSION['user_id']) ?></div>
        </div>
        <div class="info-card">
          <div class="icon">👤</div>
          <div class="label">Tài khoản</div>
          <div class="value"><?= $username ?></div>
        </div>
        <div class="info-card">
          <div class="icon">🔐</div>
          <div class="label">Trạng thái</div>
          <div class="value" style="color:#5fd4a8">Hoạt động</div>
        </div>
      </div>

      <a href="logout.php" class="btn-logout">🚪 Đăng xuất</a>
    </div>
  </body>

</html>
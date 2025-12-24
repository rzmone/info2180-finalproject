<?php
session_start();
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dolphin CRM - Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body class="auth-body">

  <!-- Top Bar -->
  <div class="auth-topbar">
    <div class="auth-brand">
      <span class="auth-brand-icon">🐬</span>
      <span class="auth-brand-text">Dolphin CRM.</span>
    </div>
  </div>

  <!-- Centered Login -->
  <div class="auth-wrap">
    <div class="auth-card">
      <h1 class="auth-title">Login</h1>

      <?php if ($error): ?>
        <div class="auth-error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form method="POST" action="authenticate.php" class="auth-form">
        <input class="auth-input" type="email" name="email" placeholder="Email address" required>
        <input class="auth-input" type="password" name="password" placeholder="Password" required>

        <button class="auth-btn" type="submit">Login</button>
      </form>
    </div>

    <div class="auth-footer">
      Copyright &copy; 2022 Dolphin CRM
    </div>
  </div>

</body>
</html>

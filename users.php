<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
if (($_SESSION['role'] ?? '') !== 'Admin') { die("Access denied"); }

$users = $pdo->query("SELECT firstname, lastname, email, role, created_at FROM users ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dolphin CRM - Users</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="layout">
  <aside class="sidebar">
    <div class="brand"><span class="brand-icon">🐬</span><span class="brand-text">Dolphin CRM</span></div>
    <nav class="nav">
      <a class="nav-link" href="dashboard.php">Home</a>
      <a class="nav-link" href="new-contact.php">New Contact</a>
      <a class="nav-link active" href="users.php">Users</a>
      <a class="nav-link" href="logout.php">Logout</a>
    </nav>
  </aside>

  <main class="main">
    <header class="topbar">
      <div>
        <h1 class="page-title">Users</h1>
        <div class="welcome">Admin area</div>
      </div>
      <a class="btn-primary" href="new-user.php">+ Add User</a>
    </header>

    <section class="card">
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Created</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $u): ?>
              <tr>
                <td class="name-cell"><?php echo htmlspecialchars($u['firstname'].' '.$u['lastname']); ?></td>
                <td><?php echo htmlspecialchars($u['email']); ?></td>
                <td><?php echo htmlspecialchars($u['role']); ?></td>
                <td><?php echo htmlspecialchars($u['created_at']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>

</body>
</html>

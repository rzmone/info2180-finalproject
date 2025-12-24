<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$users = $pdo->query("SELECT id, firstname, lastname FROM users ORDER BY firstname, lastname")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dolphin CRM - New Contact</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="layout">
  <aside class="sidebar">
    <div class="brand"><span class="brand-icon">🐬</span><span class="brand-text">Dolphin CRM</span></div>
    <nav class="nav">
      <a class="nav-link" href="dashboard.php">Home</a>
      <a class="nav-link active" href="new-contact.php">New Contact</a>
      <?php if (($_SESSION['role'] ?? '') === 'Admin'): ?>
        <a class="nav-link" href="users.php">Users</a>
      <?php endif; ?>
      <a class="nav-link" href="logout.php">Logout</a>
    </nav>
  </aside>

  <main class="main">
    <header class="topbar">
      <div>
        <h1 class="page-title">New Contact</h1>
        <div class="welcome">
          Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> |
          Role: <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>
        </div>
      </div>
    </header>

    <section class="card form-card">
      <form method="POST" action="add-contact.php">
        <div class="form-group" style="max-width:140px;">
          <label>Title</label>
          <select name="title" required>
            <option value="Mr">Mr</option>
            <option value="Ms">Ms</option>
            <option value="Mrs">Mrs</option>
            <option value="Dr">Dr</option>
          </select>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label>First Name</label>
            <input name="firstname" required>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input name="lastname" required>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
          </div>
          <div class="form-group">
            <label>Telephone</label>
            <input name="telephone" required>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label>Company</label>
            <input name="company" required>
          </div>
          <div class="form-group">
            <label>Type</label>
            <select name="type" required>
              <option value="Sales Lead">Sales Lead</option>
              <option value="Support">Support</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Assigned To</label>
          <select name="assigned_to" required>
            <?php foreach ($users as $u): ?>
              <option value="<?php echo (int)$u['id']; ?>">
                <?php echo htmlspecialchars($u['firstname'].' '.$u['lastname']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-actions">
          <button class="btn-primary" type="submit">Save</button>
        </div>
      </form>
    </section>
  </main>
</div>

</body>
</html>

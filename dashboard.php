<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dolphin CRM - Dashboard</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="layout">
  <aside class="sidebar">
    <div class="brand"><span class="brand-icon">🐬</span><span class="brand-text">Dolphin CRM</span></div>
    <nav class="nav">
      <a class="nav-link active" href="dashboard.php">Home</a>
      <a class="nav-link" href="new-contact.php">New Contact</a>
      <?php if (($_SESSION['role'] ?? '') === 'Admin'): ?>
        <a class="nav-link" href="users.php">Users</a>
      <?php endif; ?>
      <a class="nav-link" href="logout.php">Logout</a>
    </nav>
  </aside>

  <main class="main">
    <header class="topbar">
      <div>
        <h1 class="page-title">Dashboard</h1>
        <div class="welcome">
          Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> |
          Role: <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>
        </div>
      </div>
      <a class="btn-primary" href="new-contact.php">+ Add Contact</a>
    </header>

    <section class="card">
      <div class="card-header">
        <div class="filter-label">Filter By:</div>
        <div class="filters">
          <button class="filterBtn active" data-filter="all">All</button>
          <button class="filterBtn" data-filter="sales">Sales Leads</button>
          <button class="filterBtn" data-filter="support">Support</button>
          <button class="filterBtn" data-filter="assigned">Assigned to me</button>
        </div>
      </div>

      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Company</th>
              <th>Type</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="contactsTbody">
            <tr><td colspan="5" class="muted">Loading...</td></tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>

<script src="app.js"></script>
</body>
</html>

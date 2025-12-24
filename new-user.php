<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
if (($_SESSION['role'] ?? '') !== 'Admin') { die("Access denied"); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dolphin CRM - New User</title>
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
        <h1 class="page-title">New User</h1>
        <div class="welcome">Create a user account</div>
      </div>
    </header>

    <section class="card form-card">
      <form method="POST" action="add-user.php">
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
            <label>Password</label>
            <input type="password" name="password" required>
          </div>
        </div>

        <div class="form-group" style="max-width:220px;">
          <label>Role</label>
          <select name="role" required>
            <option value="Admin">Admin</option>
            <option value="Member">Member</option>
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

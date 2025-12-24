<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { die("Invalid contact id"); }

$contact_id = (int)$_GET['id'];

$stmt = $pdo->prepare("
  SELECT c.*,
         a.firstname AS assigned_firstname, a.lastname AS assigned_lastname,
         cr.firstname AS created_firstname, cr.lastname AS created_lastname
  FROM contacts c
  JOIN users a ON c.assigned_to = a.id
  JOIN users cr ON c.created_by = cr.id
  WHERE c.id = :id
");
$stmt->execute(['id' => $contact_id]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$contact) die("Contact not found");

$switchText = ($contact['type'] === 'Sales Lead') ? 'Switch to Support' : 'Switch to Sales Lead';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dolphin CRM - Contact</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="layout">
  <aside class="sidebar">
    <div class="brand"><span class="brand-icon">🐬</span><span class="brand-text">Dolphin CRM</span></div>
    <nav class="nav">
      <a class="nav-link" href="dashboard.php">Home</a>
      <a class="nav-link" href="new-contact.php">New Contact</a>
      <?php if (($_SESSION['role'] ?? '') === 'Admin'): ?>
        <a class="nav-link" href="users.php">Users</a>
      <?php endif; ?>
      <a class="nav-link" href="logout.php">Logout</a>
    </nav>
  </aside>

  <main class="main">
    <header class="contact-header">
      <div>
        <h1 class="page-title"><?php echo htmlspecialchars($contact['title'].' '.$contact['firstname'].' '.$contact['lastname']); ?></h1>
        <div class="meta">
          Created on <?php echo htmlspecialchars($contact['created_at']); ?>
          by <?php echo htmlspecialchars($contact['created_firstname'].' '.$contact['created_lastname']); ?><br>
          Updated on <span id="updatedAt"><?php echo htmlspecialchars($contact['updated_at']); ?></span>
        </div>
      </div>

      <div class="actions">
        <button class="btn-green" id="assignBtn" data-id="<?php echo $contact_id; ?>">Assign to me</button>
        <button class="btn-yellow" id="switchBtn" data-id="<?php echo $contact_id; ?>">
          <span id="switchText"><?php echo htmlspecialchars($switchText); ?></span>
        </button>
      </div>
    </header>

    <section class="card details-card">
      <div class="grid-2">
        <div>
          <div class="label">Email</div>
          <div class="value"><?php echo htmlspecialchars($contact['email']); ?></div>
        </div>
        <div>
          <div class="label">Telephone</div>
          <div class="value"><?php echo htmlspecialchars($contact['telephone']); ?></div>
        </div>
        <div>
          <div class="label">Company</div>
          <div class="value"><?php echo htmlspecialchars($contact['company']); ?></div>
        </div>
        <div>
          <div class="label">Assigned To</div>
          <div class="value" id="assignedToText"><?php echo htmlspecialchars($contact['assigned_firstname'].' '.$contact['assigned_lastname']); ?></div>
        </div>
      </div>
    </section>

    <section class="card" style="margin-top:14px;">
      <h2 style="margin:0 0 10px 0;">Notes</h2>
      <div id="notesArea" class="notes-area">Loading notes...</div>

      <h3 style="margin:16px 0 8px 0; font-size:14px;">
        Add a note about <?php echo htmlspecialchars($contact['firstname']); ?>
      </h3>

      <textarea id="noteText" rows="5" placeholder="Enter details here"></textarea>

      <div class="form-actions">
        <button class="btn-primary" id="addNoteBtn" data-id="<?php echo $contact_id; ?>">Add Note</button>
      </div>
    </section>
  </main>
</div>

<script src="contact.js"></script>
</body>
</html>

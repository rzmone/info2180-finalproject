<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['success' => false]);
  exit;
}

$contact_id = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;
$action = $_POST['action'] ?? '';

if ($contact_id <= 0) { echo json_encode(['success' => false]); exit; }

if ($action === 'assign') {
  $pdo->prepare("UPDATE contacts SET assigned_to = :uid, updated_at = NOW() WHERE id = :cid")
      ->execute(['uid' => $_SESSION['user_id'], 'cid' => $contact_id]);

  $me = $pdo->prepare("SELECT firstname, lastname FROM users WHERE id = :uid");
  $me->execute(['uid' => $_SESSION['user_id']]);
  $meRow = $me->fetch(PDO::FETCH_ASSOC);

  $time = $pdo->prepare("SELECT updated_at FROM contacts WHERE id = :cid");
  $time->execute(['cid' => $contact_id]);

  echo json_encode([
    'success' => true,
    'assigned_name' => $meRow ? ($meRow['firstname'].' '.$meRow['lastname']) : '',
    'updated_at' => $time->fetchColumn()
  ]);
  exit;
}

if ($action === 'switch') {
  $cur = $pdo->prepare("SELECT type FROM contacts WHERE id = :cid");
  $cur->execute(['cid' => $contact_id]);
  $row = $cur->fetch(PDO::FETCH_ASSOC);
  if (!$row) { echo json_encode(['success' => false]); exit; }

  $newType = ($row['type'] === 'Sales Lead') ? 'Support' : 'Sales Lead';

  $pdo->prepare("UPDATE contacts SET type = :t, updated_at = NOW() WHERE id = :cid")
      ->execute(['t' => $newType, 'cid' => $contact_id]);

  $time = $pdo->prepare("SELECT updated_at FROM contacts WHERE id = :cid");
  $time->execute(['cid' => $contact_id]);

  $switchText = ($newType === 'Sales Lead') ? 'Switch to Support' : 'Switch to Sales Lead';

  echo json_encode([
    'success' => true,
    'type' => $newType,
    'switch_text' => $switchText,
    'updated_at' => $time->fetchColumn()
  ]);
  exit;
}

echo json_encode(['success' => false]);
exit;

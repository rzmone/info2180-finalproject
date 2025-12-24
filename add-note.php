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
$comment = trim($_POST['comment'] ?? '');

if ($contact_id <= 0 || $comment === '') {
  echo json_encode(['success' => false]);
  exit;
}

$stmt = $pdo->prepare("INSERT INTO notes (contact_id, comment, created_by) VALUES (:cid, :comment, :uid)");
$stmt->execute(['cid' => $contact_id, 'comment' => $comment, 'uid' => $_SESSION['user_id']]);

$pdo->prepare("UPDATE contacts SET updated_at = NOW() WHERE id = :cid")->execute(['cid' => $contact_id]);

$time = $pdo->prepare("SELECT updated_at FROM contacts WHERE id = :cid");
$time->execute(['cid' => $contact_id]);

echo json_encode(['success' => true, 'updated_at' => $time->fetchColumn()]);
exit;

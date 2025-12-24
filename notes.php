<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode([]);
  exit;
}

$contact_id = isset($_GET['contact_id']) ? (int)$_GET['contact_id'] : 0;
if ($contact_id <= 0) { echo json_encode([]); exit; }

$stmt = $pdo->prepare("
  SELECT n.comment, n.created_at, u.firstname, u.lastname
  FROM notes n
  JOIN users u ON n.created_by = u.id
  WHERE n.contact_id = :cid
  ORDER BY n.created_at DESC
");
$stmt->execute(['cid' => $contact_id]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
exit;

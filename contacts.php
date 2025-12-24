<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode([]);
  exit;
}

$filter = $_GET['filter'] ?? 'all';

$sql = "SELECT id, title, firstname, lastname, email, company, type, assigned_to
        FROM contacts";
$params = [];

if ($filter === 'sales') {
  $sql .= " WHERE type = 'Sales Lead'";
} elseif ($filter === 'support') {
  $sql .= " WHERE type = 'Support'";
} elseif ($filter === 'assigned') {
  $sql .= " WHERE assigned_to = :uid";
  $params['uid'] = $_SESSION['user_id'];
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
exit;

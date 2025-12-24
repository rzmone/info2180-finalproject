<?php
session_start();
require 'config.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT id, firstname, lastname, password, role FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['name'] = $user['firstname'];
  $_SESSION['role'] = $user['role'];
  header("Location: dashboard.php");
  exit;
}

header("Location: login.php?error=" . urlencode("Invalid email or password"));
exit;

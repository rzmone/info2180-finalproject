<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
if (($_SESSION['role'] ?? '') !== 'Admin') { die("Access denied"); }

$firstname = trim($_POST['firstname'] ?? '');
$lastname  = trim($_POST['lastname'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';
$role      = trim($_POST['role'] ?? '');

if ($firstname === '' || $lastname === '' || $email === '' || $password === '' || ($role !== 'Admin' && $role !== 'Member')) {
  die("Missing or invalid fields.");
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, password, email, role) VALUES (:f,:l,:p,:e,:r)");
$stmt->execute(['f'=>$firstname,'l'=>$lastname,'p'=>$hash,'e'=>$email,'r'=>$role]);

header("Location: users.php");
exit;

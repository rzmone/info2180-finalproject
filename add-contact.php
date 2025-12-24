<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$title = trim($_POST['title'] ?? '');
$firstname = trim($_POST['firstname'] ?? '');
$lastname = trim($_POST['lastname'] ?? '');
$email = trim($_POST['email'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$company = trim($_POST['company'] ?? '');
$type = trim($_POST['type'] ?? '');
$assigned_to = (int)($_POST['assigned_to'] ?? 0);

if ($title === '' || $firstname === '' || $lastname === '' || $email === '' || $telephone === '' || $company === '' || $type === '' || $assigned_to <= 0) {
  die("Missing required fields.");
}

$stmt = $pdo->prepare("
  INSERT INTO contacts
  (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by)
  VALUES
  (:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by)
");

$stmt->execute([
  'title' => $title,
  'firstname' => $firstname,
  'lastname' => $lastname,
  'email' => $email,
  'telephone' => $telephone,
  'company' => $company,
  'type' => $type,
  'assigned_to' => $assigned_to,
  'created_by' => $_SESSION['user_id']
]);

header("Location: dashboard.php");
exit;

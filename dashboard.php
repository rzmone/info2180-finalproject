<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
</head>
<body>

  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>

  <p>You are logged in as <strong><?php echo $_SESSION['role']; ?></strong></p>

  <a href="logout.php">Logout</a>

</body>
</html>

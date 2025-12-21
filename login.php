<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dolphin CRM Login</title>
</head>
<body>

  <h1>Dolphin CRM</h1>

  <form method="POST" action="authenticate.php">
    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
  </form>

</body>
</html>

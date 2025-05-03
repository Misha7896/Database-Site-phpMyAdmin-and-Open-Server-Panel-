<?php
session_start();
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
    header("Location: index.php");
    exit();
}

$userName = $_SESSION["user_name"];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Приветствие</title>
</head>
<body>
  <h1>Добро пожаловать, <?= $userName ?>!</h1>
  
  <!-- Здесь можете добавить любую дополнительную информацию -->
  
  <a href="logout.php">Выход</a>
</body>
</html>

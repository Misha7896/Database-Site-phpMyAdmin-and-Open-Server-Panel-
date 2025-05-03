<?php
session_start(); // Запускаем сессию для хранения данных между страницами

$mysql = new mysqli("localhost", "root", "", "lr#3"); // Подключение к БД
if ($mysql->connect_error) { 
    die('Ошибка подключения (' . $mysql->connect_errno . ') '. $mysql->connect_error); 
}

// Получение POST-данных
$username = $_POST['username'];
$password = $_POST['password'];

// Проверка на пустые значения
if(empty($username) || empty($password)) {
    header("Location: index.php");
    exit();
}

// Безопасная проверка данных
$stmt = $mysql->prepare("SELECT * FROM staff WHERE login=? AND pass=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

// Проверяем наличие совпадающих записей
if ($result && $row = $result->fetch_assoc()) {
    $_SESSION["logged_in"] = true;
    $_SESSION["user_id"] = $row["id"];
    $_SESSION["user_name"] = $row["name"];

    if ($row['name'] === 'Админ') {
        include_once('admin_panel.php');
        exit();
    }

    // Перенаправляем на страницу приветствия
    header("Location: welcome.php");
    exit();
} else {
    // Ошибка авторизации
    session_destroy();
    echo "<script>alert('Неверный логин или пароль'); window.location.href='index.php';</script>";
    exit();
}
?>

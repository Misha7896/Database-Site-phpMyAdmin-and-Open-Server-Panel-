<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Авторизация</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color:rgb(108, 108, 108);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    form {
      width: 300px;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color:rgb(197, 197, 197);
      text-align: center;
    }

    h1 {
      color:rgb(53, 72, 112);
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 10px;
      color: #555;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      outline: none;
    }

    button {
      width: 100%;
      padding: 10px;
      margin-top: 20px;
      border: none;
      border-radius: 5px;
      background-color: rgb(53, 72, 112);
      color: white;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
    }

    button:hover {
      background-color: #2d4373;
    }

    @media screen and (max-width: 480px) {
      form {
        width: 90%;
      }
    }
  </style>
</head>
<body>
  <form action="auth.php" method="post">
    <h1>Авторизация</h1>
    <label for="username">Логин:</label>
    <input type="text" id="username" name="username" required autofocus>
    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Войти</button>
  </form>
</body>
</html>

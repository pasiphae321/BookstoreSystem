<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户注册</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin-bottom: 10px;
            padding: 8px;
            font-size: 16px;
        }
        button {
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h4>用户注册</h4>
        <form method="POST" action="register.php">
            <label for="username">用户名:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">密码:</label>
            <input type="password" name="password" id="password" required>
            <label for="password">邮箱:</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">注册</button>
        </form>
        <a href="login.php">点击这里登录</a>

        <?php
        include "config.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $email = $_POST["email"];

            $SQL = "select ID from users where username = :username;";
            $statement = $PHPDataObject->prepare($SQL);
            $statement->bindParam(":username", $username);
            if ($statement->execute())
            {
                if ($statement->rowCount() > 0)
                {
                    echo "<h3>用户名已存在</h3>";
                }
                else
                {
                    $SQL = "insert into users (username, password, email) values (:username, :password, :email);";
                    $statement = $PHPDataObject->prepare($SQL);
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":password", $password);
                    $statement->bindParam(":email", $email);
                    if ($statement->execute())
                    {
                        echo "<h3>注册成功</h3>";
                    }
                }
            }
        }
        ?>

    </div>
</body>
</html>

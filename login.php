<?php
include "config.php";

if (isset($_SESSION["UserID"]))
{
    header("Location: index.php");    
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录</title>
    <style>
        body
        {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container
        {
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        form
        {
            display: flex;
            flex-direction: column;
        }
        input
        {
            margin-bottom: 10px;
            padding: 8px;
            font-size: 16px;
        }
        button
        {
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover
        {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h4>书店系统</h4>
        <form method="POST" action="login.php">
            <label for="userame">用户名:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">密码:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">登录</button>
        </form>
        <a href="register.php">点击这里注册</a>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $SQL = "select * from users where username = :username;";
            $statement = $PHPDataObject->prepare($SQL);
            $statement->bindParam(":username", $username);
            if ($statement->execute())
            {
                if ($statement->rowCount() > 0)
                {
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    if ($row["password"] == $password)
                    {
                        $_SESSION["UserID"] = $row["ID"];
                        $_SESSION["username"] = $row["username"];
                        header("Location: index.php");
                    }
                    else
                    {
                        echo "<h3>密码错误</h3>";
                    }
                }
                else
                {
                    echo "<h3>用户不存在</h3>";
                }
            }
        }
        ?>

    </div>
</body>
</html>

<?php
    include "config.php";
    if (!isset($_SESSION["UserID"]))
    {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>主页</title>
    <style>
        body, html
        {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .centered
        {
            text-align: center;
        }
        .centered a
        {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: white;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
        }
        .centered a:hover
        {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="centered">

        <?php
        echo "<h3>欢迎您," . htmlspecialchars($_SESSION["username"]) . "</h3>";
        ?>

        <a href="logout.php">登出</a>
        <a href="register.php">用户注册</a>
        <a href="search.php">书籍查询</a>
        <a href="ChangePassword.php">修改密码</a>
        <a href="UserSuggestions.php">用户建议</a>

    </div>
</body>
</html>

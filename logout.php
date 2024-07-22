<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登出</title>
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
		include "config.php";

		if (!isset($_SESSION["UserID"]))
		{
			echo "<h3>您未登录</h3>";
		}
		else
		{
			session_destroy();
			$_SESSION = array();
			setcookie(session_name(), "", time() - 3600, "/");
		}
		?>
        <a href="login.php">点击这里登录</a>
    </div>
</body>
</html>

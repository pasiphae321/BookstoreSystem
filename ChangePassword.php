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
    <title>修改密码</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .result-table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .result-table, .result-table th, .result-table td {
            border: 1px solid black;
        }
        .result-table th, .result-table td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php">返回主页</a>
        <div class="search-container">
            <form action="ChangePassword.php" method="GET">
                <label>请输入<b><?php echo htmlspecialchars($_SESSION["username"]) ?></b>的新密码:</label>
                <input type="password" name="password" required>
                <button type="submit">提交</button>
            </form>
        </div>

        <?php
        if (isset($_GET["password"]))
        {
            $password = $_GET["password"];
            $UserID = $_SESSION["UserID"];
            $statement = $PHPDataObject->prepare("update users set password = :password where ID = :UserID;");
            $statement->bindParam(":password", $password, PDO::PARAM_STR);
            $statement->bindParam(":UserID", $UserID, PDO::PARAM_INT);
            
            $qwe = $statement->execute();
            
            if ($qwe)
            {
                echo "<h3>密码修改成功</h3>";
            }
            else
            {
                echo "<h3>密码修改失败</h3>";
            }
        }
        ?>
    </div>
</body>
</html>

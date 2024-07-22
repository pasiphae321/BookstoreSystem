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
    <title>用户建议</title>
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
            <form action="UserSuggestions.php" method="post">
                <label>请添加您的建议:</label>
                <input type="text" name="suggestion" required>
                <button type="submit">添加</button>
            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $statement = $PHPDataObject->prepare("insert into UserSuggestions (UserID, suggestion) values (:UserID, :suggestion);");
            $statement->bindParam(":UserID", $_SESSION["UserID"]);
            $statement->bindParam(":suggestion", $_POST["suggestion"]);
            if ($statement->execute())
            {
                echo "添加成功!";
            }
        }
        echo "<table class=\"result-table\">";
        echo "<tr><th>ID</th><th>用户</th><th>建议</th></tr>";
        $statement = $PHPDataObject->prepare("select u.ID, s.username, u.suggestion from UserSuggestions u left join users s on u.UserID = s.ID;");
        if ($statement->execute())
        {
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($result))
            {
                foreach ($result as $i)
                {
                    
                    echo "<tr><td>" . $i["ID"] . "</td><td>" . htmlspecialchars($i["username"]) . "</td><td>" . htmlspecialchars($i["suggestion"]) . "</td></tr>";

                    // 存储型XSS
                    // echo "<tr><td>" . $i["ID"] . "</td><td>" . $i["username"] . "</td><td>" . $i["suggestion"] . "</td></tr>";
                }
            }
        }
        echo "</table>";
        ?>
    </div>
</body>
</html>

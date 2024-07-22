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
    <title>书籍查询</title>
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
            <form action="search.php" method="get">
                <label>请输入书名:</label>
                <input type="text" name="BookName" value="<?php
                if (isset($_GET["BookName"]))
                {
                    echo htmlspecialchars($_GET["BookName"]);
                }
                ?>" required>
                <button type="submit">查询</button>
            </form>
        </div>
        <table class="result-table">
        <tr><th>书名</th><th>价格</th></tr>
        
        <?php
        if (isset($_GET["BookName"]))
        {
            // $BookName = "%" . $_GET["BookName"] . "%";
            // $statement = $PHPDataObject->prepare("select BookName, price from books where BookName like :BookName;");
            // $statement->bindParam(":BookName", $BookName);
            
            // SQL注入
            $BookName = $_GET["BookName"];
            $statement = $PHPDataObject->prepare("select BookName, price from books where BookName like \"%$BookName%\"");

            if ($statement->execute())
            {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($result))
                {
                    foreach ($result as $i)
                    {
                        echo "<tr><td>" . htmlspecialchars($i["BookName"]) . "</td><td>" . htmlspecialchars($i["price"]) . "</td></tr>";
                    }
                }
                else
                {
                    echo "<h3>没有名为" . htmlspecialchars($_GET["BookName"]) . "的书</h3>";

                    // 反射型XSS
                    // echo "<h3>没有名为" . $_GET["BookName"] . "的书</h3>";
                }
            }
        }    
        ?>
        </table>
    </div>
</body>
</html>

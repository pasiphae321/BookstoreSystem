<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>书籍查询</title>
    <link rel="icon" type="image/x-icon" href="/image/planet.png">
    <link rel="stylesheet" type="text/css" href="/css/mars.css">
</head>
<body>
    <div class="container">
        <p style="font-size: 20px;">当前用户:<span>
        <?php
        include "../v1/config.php";
        if (!isset($_SESSION["username"])) {
            header("Location: /login.html");
            exit();
        }
        echo $_SESSION["username"];
        ?>
        </span></p>
        <a href="/index.html">返回主页</a>
        <div class="search-container">
            <form id="book_search_form" action="/old/book_search.php">
                <label for="book_name">请输入书名:</label>
                <input type="text" id="book_name" name="book_name" value="" required>
                <button type="submit">查询</button>
            </form>
        </div>
        <table class="result-table" id="book_table">
            <thead>
                <tr><th>书名</th><th>价格</th></tr>
            </thead>
            <tbody>
            <?php
            if (!isset($_GET["book_name"])) {
                exit();
            }

            $BookName = $_GET["book_name"];
            $BookNamePlus = "%" . $BookName . "%";
            $statement = $PHPDataObject->prepare("select `name`, `price` from `book` where `name` like :BookNamePlus;");
            $statement->bindParam(":BookNamePlus", $BookNamePlus);

            if ($statement->execute()) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($result)) {
                    foreach ($result as $one) {
                        // 反射型XSS漏洞
                        // 这里的$one["price"]存在反射型XSS漏洞，解决方案为使用htmlspecialchars()
                        echo "<tr><td>" . $one["name"] . "</td><td>" . $one["price"] . "</td></tr>";
                    }
                }
                else {
                    $flag = 1;
                }
            }
            ?>
            </tbody>
        </table>
        <?php
            if ($flag === 1) {
                echo "<p style=\"font-size: 20px;\">没有名为" . $BookName . "的书</p>";
            }
        ?>
    </div>
</body>
</html>

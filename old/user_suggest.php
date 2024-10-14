<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户建议</title>
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
            <form id="suggest_form" action="/old/user_suggest.php">
                <label>请添加您的建议:</label>
                <input type="text" id="content" name="content" required>
                <button type="submit">添加</button>
            </form>
        </div>
        <table class="result-table" id="suggestion_table">
            <thead>
                <tr><th>用户</th><th>建议</th></tr>
            </thead>
            <tbody>
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $statement = $PHPDataObject->prepare("select `user`.`username`, `suggestion`.`content` from `suggestion` inner join `user` on `suggestion`.`user_id` = `user`.`id`;");
                if ($statement->execute()) {
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($result)) {
                        foreach ($result as $one) {
                            // 存储型XSS漏洞
                            // 这里的$one["content"]存在存储型XSS漏洞，解决方案为使用htmlspecialchars()
                            echo "<tr><td>" . $one["username"] . "</td><td>" . $one["content"] . "</td></tr>";
                        }
                    }
                    else {
                        $flag = 1;
                    }
                }
            }

            else if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (!isset($_POST["content"])) {
                    exit();
                }
                $content = $_POST["content"];
                $UserID = $_SESSION["UserID"];
                $statement = $PHPDataObject->prepare("insert into `suggestion`(`user_id`, `content`) values (:UserID, :content);");
                $statement->bindParam(":UserID", $UserID, PDO::PARAM_INT);
                $statement->bindParam(":content", $content, PDO::PARAM_STR);

                if ($statement->execute()) {
                    echo "<script type=\"text/javascript\">alert(\"建议添加成功\");</script>";
                }

                $statement = $PHPDataObject->prepare("select `user`.`username`, `suggestion`.`content` from `suggestion` inner join `user` on `suggestion`.`user_id` = `user`.`id`;");
                if ($statement->execute()) {
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($result)) {
                        echo "<tr><td>" . $one["username"] . "</td><td>" . $one["content"] . "</td></tr>";
                    }
                    else {
                        $flag = 1;
                    }
                }
            }
            ?>
            </tbody>
        </table>
        <?php
        if ($flag === 1) {
            echo "<p style=\"font-size: 20px;\">当前没有建议</p>";
        }
        ?>
    </div>
</body>
</html>

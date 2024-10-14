<?php
include "./config.php";

if (!isset($_SESSION["username"])) {
    setcookie("username", "", time() - 3600, "/");
    $redis->sRem($key, $_COOKIE["username"]);
    echo json_encode(["status" => 8, "message" => "请先登录"]);
    exit();
}

header("Content-Type: application/json");
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_GET["book_name"])) {
        echo json_encode(["status" => 9, "message" => "错误请求"]);
        exit();
    }

    $BookName = $_GET["book_name"];

    // 通过PDO的bindParam对SQL注入漏洞进行防范
    // $BookName = "%" . $BookName . "%";
    // $statement = $PHPDataObject->prepare("select `name`, `price` from `book` where `book_name` like :BookName;");
    // $statement->bindParam(":BookName", $BookName);

    // SQL注入漏洞
    $statement = $PHPDataObject->prepare("select `name`, `price` from `book` where `name` like '%" . $BookName . "%';");

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result)) {
            $result = ["status" => 0, "result" => $result];
            echo json_encode($result);
        }
        else {
            echo json_encode(["status" => 1, "message" => $BookName]);
        }
    }
}

else {
    echo json_encode(["status" => 9, "message" => "错误请求"]);
}    
?>


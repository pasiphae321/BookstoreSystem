<?php
include "../config.php";
header("Content-Type: application/json");

if (!isset($_SESSION["username"])) {
    setcookie("username", "", time() - 3600, "/");
    $redis->sRem($key, $_COOKIE["username"]);
    echo json_encode(["status" => 8, "message" => "请先登录"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $body = json_decode(file_get_contents("php://input"), true);
    if (!isset($body["password"])) {
        echo json_encode(["status" => 9, "message" => "错误请求"]);
        exit();
    }

    // CSRF漏洞
    // 因为只通过PHPSESSID这个会话cookie检测身份，当将config.php中会话cookie的samesite属性设置为Lax或None时，存在CSRF漏洞
    $password = $body["password"];
    $UserID = $_SESSION["UserID"];
    $statement = $PHPDataObject->prepare("update `user` set `password` = :password where `id` = :UserID;");
    $statement->bindParam(":password", $password, PDO::PARAM_STR);
    $statement->bindParam(":UserID", $UserID, PDO::PARAM_INT);

    if ($statement->execute()) {
        echo json_encode(["status" => 0, "message" => "密码修改成功"]);
    }

    else {
        echo json_encode(["status" => 1, "message" => "密码修改失败"]);
    }
}

else {
    echo json_encode(["status" => 9, "message" => "错误请求"]);
}
?>


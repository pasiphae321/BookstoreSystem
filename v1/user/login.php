<?php
include "../config.php";
header("Content-Type: application/json");

if (isset($_SESSION["username"])) {
    echo json_encode(["status" => 2, "message" => "您已登录"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $username = $input["username"];
    $password = $input["password"];

    $SQL = "select * from `user` where `username` = :username and `password` = :password;";
    $statement = $PHPDataObject->prepare($SQL);
    $statement->bindParam(":username", $username, PDO::PARAM_STR);
    $statement->bindParam(":password", $password, PDO::PARAM_STR);
    
    if ($statement->execute()) {
        if ($statement->rowCount() > 0) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $_SESSION["UserID"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            echo json_encode(["status" => 0, "message" => "登录成功"]);
        }
        else {
            echo json_encode(["status" => 1, "message" => "用户名或密码错误"]);
        }
    }
}
?>


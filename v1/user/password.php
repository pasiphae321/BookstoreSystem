<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $password = $input["password"];
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
?>


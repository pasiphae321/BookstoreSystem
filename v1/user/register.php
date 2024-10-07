<?php
include "../config.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $username = $input["username"];
    $password = $input["password"];
    $email = $input["email"];

    $SQL = "select `id` from `users` where `username` = :username;";
    $statement = $PHPDataObject->prepare($SQL);
    $statement->bindParam(":username", $username, PDO::PARAM_STR);

    if ($statement->execute()) {
        if ($statement->rowCount() > 0)
            echo json_encode(["status" => 1, "message" => "用户名已存在"]);
        else {
            $SQL = "insert into `user`(`username`, `password`, `email`) values (:username, :password, :email);";
            $statement = $PHPDataObject->prepare($SQL);
            $statement->bindParam(":username", $username, PDO::PARAM_STR);
            $statement->bindParam(":password", $password, PDO::PARAM_STR);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);
            
            if ($statement->execute()) {
                echo json_encode(["status" => 0, "message" => "注册成功"]);
            }
        }   
    }
}
?>

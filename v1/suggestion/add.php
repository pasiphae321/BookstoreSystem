<?php
include "../config.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $content = $input["content"];
    $UserID = $_SESSION["UserID"];
    
    $statement = $PHPDataObject->prepare("insert into `suggestion`(`user_id`, `content`) values (:UserID, :content);");
    $statement->bindParam(":UserID", $UserID, PDO::PARAM_INT);
    $statement->bindParam(":content", $content, PDO::PARAM_STR);

    if ($statement->execute()) {
        echo json_encode(["status" => 0, "message" => "建议提交成功"]);
    }
    else {
        echo json_encode(["status" => 1, "message" => "建议提交失败"]);
    }
}
?>


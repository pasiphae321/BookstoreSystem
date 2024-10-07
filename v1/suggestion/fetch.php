<?php
include "../config.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $statement = $PHPDataObject->prepare("select `user`.`username`, `suggestion`.`content` from `suggestion` inner join `user` on `suggestion`.`user_id` = `user`.`id`;");

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result)) {
            $result = ["status" => 0, "result" => $result];
            echo json_encode($result);
        }
        else {
            echo json_encode(["status" => 1, "message" => "当前暂无建议"]);
        }
    }
}
?>


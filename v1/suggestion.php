<?php
include "./config.php";
header("Content-Type: application/json");

if (!isset($_SESSION["username"])) {
    setcookie("username", "", time() - 3600, "/");
    $redis->sRem($key, $_COOKIE["username"]);
    echo json_encode(["status" => 8, "message" => "请先登录"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $statement = $PHPDataObject->prepare("select `user`.`username`, `suggestion`.`content` from `suggestion` inner join `user` on `suggestion`.`user_id` = `user`.`id`;");

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result)) {
            $result = ["status" => 0, "result" => $result];
            echo json_encode($result);
        }
        else {
        	$message = "当前暂无建议";
            echo json_encode(["status" => 1, "message" => $message]);
        }
    }
}

else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $body = json_decode(file_get_contents("php://input"), true);
    if (!isset($body["content"])) {
    	echo json_encode(["status" => 9, "message" => "错误请求"]);
    	exit();
    }

    $content = $body["content"];
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

else {
	echo json_encode(["status" => 9, "message" => "错误请求"]);
}
?>
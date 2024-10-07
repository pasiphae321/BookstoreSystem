<?php
include "../config.php";
header("Content-Type: application/json");

if (!isset($_SESSION["username"])) {
	echo json_encode(["status" => 1, "message" => "您未登录"]);
}
else {
	session_destroy();
	$_SESSION = array();
	setcookie(session_name(), "", time() - 3600, "/");
    echo json_encode(["status" => 0, "message" => "登出成功"]);
}
?>


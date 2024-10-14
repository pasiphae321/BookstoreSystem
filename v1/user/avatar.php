<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
	if (isset($_GET["username"])) {
		header("Content-Type: image/jpeg");
		$DefaultAvatarPath = "/var/www/html/BookstoreSystem/image/default_avatar.jpg";
		$username = $_GET["username"];

		$statement = $PHPDataObject->prepare("select `id` from `user` where `username` = :username;");
    	$statement->bindParam(":username", $username, PDO::PARAM_STR);

    	if ($statement->execute()) {
    		$row = $statement->fetch(PDO::FETCH_ASSOC);
    		if (empty($row)) {
    			readfile($DefaultAvatarPath);
    			exit();
    		}
    		else {
    			$UserID = $row["id"];
    			$AvatarPathPattern = "/var/www/html/BookstoreSystem/upload/" . $UserID . "*";
    			$AvatarPathSearchResult = glob($AvatarPathPattern);
    			readfile($AvatarPathSearchResult[0]);
    			exit();
			}
    	}
	}
	else {
		header("Content-Type: application/json");
		echo json_encode(["status" => 9, "message" => "错误请求"]);
	}
}


else if ($_SERVER["REQUEST_METHOD"] === "POST") {
	header("Content-Type: application/json");
	if (!isset($_SESSION["username"])) {
	    setcookie("username", "", time() - 3600, "/");
	    $redis->sRem($key, $_COOKIE["username"]);
	    echo json_encode(["status" => 8, "message" => "请先登录"]);
	    exit();
	}

	if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
		$UploadedFileName = $_FILES["file"]["name"];
		$AllowedExtensions = ["jpg", "jpeg", "png"];
		$UploadedFileExtension = strtolower(pathinfo($UploadedFileName, PATHINFO_EXTENSION));

		// 文件上传漏洞
		// 如果仅在前端通过JS检测文件后缀而未在后端通过pathinfo(xxx, PATHINFO_EXTENSION)检测
		// 且nginx未将upload目录设置为禁止访问
		// 攻击者可通过BurpSuite抓包修改文件后缀绕过前端检测，上传webshell到upload目录下
		// 此时访问http://xxxx/upload/webshell.php能够成功，存在文件上传漏洞

		if (in_array($UploadedFileExtension, $AllowedExtensions)) {

			$AvatarPathPattern = "/var/www/html/BookstoreSystem/upload/" . $_SESSION["UserID"] . "*";
			$AvatarPathSearchResult = glob($AvatarPathPattern);
			if (!empty($AvatarPathSearchResult)) {
				foreach ($AvatarPathSearchResult as $one) {
					unlink($one);
				}
			}

			$FinalFilePath = "/var/www/html/BookstoreSystem/upload/" . $_SESSION["UserID"] . "." . $UploadedFileExtension;
			move_uploaded_file($_FILES["file"]["tmp_name"], $FinalFilePath);
			echo json_encode(["status" => 0, "message" => "头像修改成功"]);
		}
		else {
			echo json_encode(["status" => 1, "message" => "不允许上传此类型文件"]);
		}
	}
	else {
		echo json_encode(["status" => 2, "message" => "头像修改失败，请重试"]);
	}
}


else {
	header("Content-Type: application/json");
	echo json_encode(["status" => 9, "message" => "错误请求"]);
}
?>
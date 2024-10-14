<?php
include "./config.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$body = json_decode(file_get_contents("php://input"), true);
	if (!isset($body["action"])) {
		echo json_encode(["status" => 9, "message" => "错误请求"]);
		exit();
	}

	$action = $body["action"];

	if ($action === "logout") {
		if (isset($_SESSION["username"])) {
			$redis->sRem($key, $_SESSION["username"]);

			session_destroy();
			$_SESSION = array();
			setcookie(session_name(), "", time() - 3600, "/");
			setcookie("username", "", time() - 3600, "/");
	    	echo json_encode(["status" => 0, "message" => "登出成功"]);
	    	exit();
		}
		else {
			$redis->sRem($key, $_COOKIE["username"]);
			setcookie("username", "", time() - 3600, "/");
    		echo json_encode(["status" => 8, "message" => "请先登录"]);
    		exit();
		}
	}

	else if ($action === "login") {
		if (!isset($_SESSION["username"])) {
			if (!(isset($body["username"]) && isset($body["password"]))) {
				echo json_encode(["status" => 9, "message" => "错误请求"]);
				exit();
			}

			$username = $body["username"];
	    	$password = $body["password"];

			if ($redis->sIsMember($key, $username)) {
				echo json_encode(["status" => 3, "message" => "用户已在其它设备登录"]);
				exit();
			}
			
	    	$SQL = "select * from `user` where `username` = :username and `password` = :password;";
	    	$statement = $PHPDataObject->prepare($SQL);
	    	$statement->bindParam(":username", $username, PDO::PARAM_STR);
	    	$statement->bindParam(":password", $password, PDO::PARAM_STR);
	    
	    	if ($statement->execute()) {
	        	if ($statement->rowCount() > 0) {
	            	$row = $statement->fetch(PDO::FETCH_ASSOC);
	            	$_SESSION["UserID"] = $row["id"];
	            	$_SESSION["username"] = $row["username"];
	            	while ($redis->sadd($key, $username) === 0) {
	            	}
	            	setcookie("username", $username, 0, "/");
	            	echo json_encode(["status" => 0, "message" => "登录成功"]);
	        	}

	        	else {
	            	echo json_encode(["status" => 1, "message" => "用户名或密码错误"]);
	        	}
	    	}
		}

		else {
			echo json_encode(["status" => 2, "message" => "您已在该设备登录"]);
		}
	}

	else if ($action === "register") {
		if (isset($_SESSION["username"])) {
			echo json_encode(["status" => 2, "message" => "请先退出当前帐号"]);
		}

		else {
			if (!(isset($body["username"]) && isset($body["password"]) &&  isset($body["email"]))) {
				echo json_encode(["status" => 9, "message" => "错误请求"]);
				exit();
			}
			
	    	$username = $body["username"];
	    	$password = $body["password"];
	    	$email = $body["email"];

	    	$SQL = "select `id` from `user` where `username` = :username;";
	    	$statement = $PHPDataObject->prepare($SQL);
	    	$statement->bindParam(":username", $username, PDO::PARAM_STR);

	    	if ($statement->execute()) {
	        	if ($statement->rowCount() > 0) {
	            	echo json_encode(["status" => 1, "message" => "用户名已存在"]);
	        	}

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
	}

	else {
		echo json_encode(["status" => 9, "message" => "错误请求"]);
	}
}

else {
	echo json_encode(["status" => 9, "message" => "错误请求"]);	
}
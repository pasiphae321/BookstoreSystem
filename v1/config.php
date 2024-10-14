<?php
$DSN = "mysql:host=127.0.0.1;dbname=bookstore_system";
$username = "test2";
$password = "ceshi";
try
{
    $PHPDataObject = new PDO($DSN, $username, $password);
    $PHPDataObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e)
{
    die("连接失败: " . $e->getMessage());
}

$redis = new Redis();
$redis->connect("127.0.0.1", 6379);
$key = "set_one";

// CSRF漏洞
// 将samesite属性设置为Lax或None(同时为https)时，存在CSRF漏洞
session_set_cookie_params([
    "lifetime" => 0,
    "path" => "/",
    "domain" => "",
    "secure" => false,
    "httponly" => false,
    "samesite" => ""
]);
session_start();
?>

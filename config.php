<?php
$DSN = "mysql:host=localhost;dbname=BookstoreSystem";
$username = "rabbit";
$password = "1433223";

try
{
    $PHPDataObject = new PDO($DSN, $username, $password);
    $PHPDataObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e)
{
    die("连接失败: " . $e->getMessage());
}

session_start();
?>

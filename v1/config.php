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

session_start();
?>

<?php
include "../config.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $BookName = $input["book_name"];

    // $BookName = "%" . $_GET["BookName"] . "%";
    // $statement = $PHPDataObject->prepare("select BookName, price from books where BookName like :BookName;");
    // $statement->bindParam(":BookName", $BookName);

    // SQL注入
    $statement = $PHPDataObject->prepare("select `name`, `price` from `book` where `name` like '%" . $BookName . "%';");

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result)) {
            $result = ["status" => 0, "result" => $result];
            echo json_encode($result);
        }
        else {
            $message = $BookName;
            echo json_encode(["status" => 1, "message" => $message]);

            // 反射型XSS
            // echo "<h3>没有名为" . $BookName . "的书</h3>";
        }
    }
}    
?>


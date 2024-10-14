<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centered Form</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        p {
            font-size: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <p>SSRF漏洞</p>
        <form action="/old/ssrf.php" method="GET">
            <input type="text" name="filename_readfile" placeholder="readfile" required>
            <button type="submit">提交</button>
        </form>
        <br>
        <form action="/old/ssrf.php" method="GET">
            <input type="text" name="filename_file_get_contents" placeholder="file_get_contents" required>
            <button type="submit">提交</button>
        </form>
        <br>
        <form action="/old/ssrf.php" method="GET">
            <input type="text" name="filename_curl" placeholder="curl" required>
            <button type="submit">提交</button>
        </form>
        <?php
        if (isset($_GET["filename_readfile"])) {
            readfile($_GET["filename_readfile"]);
        }
        else if (isset($_GET["filename_file_get_contents"])) {
            echo file_get_contents($_GET["filename_file_get_contents"]);
        }
        else if (isset($_GET["filename_curl"])) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $_GET["filename_curl"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            echo $output;
        }
        ?>
    </div>
</body>
</html>

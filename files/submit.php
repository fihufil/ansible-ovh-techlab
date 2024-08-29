<?php

require_once(__DIR__.'/config.php');

$conn = mysqli_init();
$conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
$conn->ssl_set(NULL, NULL, '/etc/ssl/certs/ca-certificates.crt', NULL, NULL);
$conn->real_connect($server, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $conn->real_escape_string(htmlspecialchars($_POST["data"]));
    if (!empty($data)) {
        $stmt = $conn->prepare("INSERT INTO data (text) VALUES (?)");
        $stmt->bind_param("s", $data);
        $stmt->execute();
    }
}

$conn->close();

$host = $_SERVER['HTTP_HOST'];
$protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';

# redirect back to mysqltest.php
header("Location: $protocol://$host/mysqltest.php");
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>302 Found</title>
</head><body>
<h1>Found</h1>
<p>The document has moved <a href="<?php echo "$protocol://$host/mysqltest.php" ?>">here</a>.</p>
</body></html>

<?php

require_once(__DIR__.'/config.php');

$conn = mysqli_init();
$conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
$conn->ssl_set(NULL, NULL, '/etc/ssl/certs/ca-certificates.crt', NULL, NULL);
$conn->real_connect($server, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

# create database table if it does not exists

$sql = 'CREATE TABLE IF NOT EXISTS data (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, text TEXT);';

$conn->query($sql);

$sql = 'SELECT text FROM data';
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
</style>
</head>
<body>
<h1>MySQL</h1>

<h2>
<?php
echo gethostname(); // may output e.g,: sandie
?>
</h2>
<p>Records from MySQL database</p>
<code>
<?php
while($row = $result->fetch_assoc()) {
    echo $row["text"] . '<br>';
}
?>
</code>
<form action="submit.php" method="post">
<p>Add more info to MySQL database</p>
Data: <input type="text" name="data"><br>
<input type="submit">
</form>

</body>
</html>
<?php
$conn->close();
?>

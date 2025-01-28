<?php
$db_host = getenv('CLOUD_SQL_CONNECTION_NAME') ? '/cloudsql/' . getenv('CLOUD_SQL_CONNECTION_NAME') : '127.0.0.1';
$db_user = getenv('DB_USERNAME') ?: 'ashwani';
$db_pass = getenv('DB_PASSWORD') ?: 'ashwani';
$db_name = getenv('DB_NAME') ?: 'lamp_db';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

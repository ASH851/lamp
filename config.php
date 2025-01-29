<?php
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '/cloudsql/YOUR_CLOUD_SQL_CONNECTION_NAME';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'lamp_db';

// Establish connection to Cloud SQL via Unix socket
$conn = new mysqli($host, $username, $password, $dbname, null, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

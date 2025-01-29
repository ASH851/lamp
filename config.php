<?php
// Get Cloud SQL connection details from environment variables
$db_socket = getenv('CLOUD_SQL_CONNECTION_NAME');  // Cloud SQL Unix socket
$db_host = $db_socket ? 'localhost' : '127.0.0.1';
$db_port = $db_socket ? "/cloudsql/$db_socket" : '3306';

// Use the root user credentials (from secrets)
$db_user = getenv('DB_USERNAME') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'lamp_db';

// Establish the database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, null, $db_port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

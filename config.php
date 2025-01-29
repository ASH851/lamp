<?php
// Get Cloud SQL connection name from environment variables
$db_socket = getenv('CLOUD_SQL_CONNECTION_NAME');

// Cloud Run uses Unix domain sockets for MySQL connection
$db_host = 'localhost';  
$db_port = "/cloudsql/$db_socket";  

// Get credentials from environment variables
$db_user = getenv('DB_USERNAME') ?: 'ashwani';
$db_pass = getenv('DB_PASSWORD') ?: 'ashwani';
$db_name = getenv('DB_NAME') ?: 'lamp_db';

// Debugging: Print connection info (check logs in Cloud Run)
error_log("DB_HOST: $db_host");
error_log("DB_PORT: $db_port");
error_log("DB_USER: $db_user");
error_log("DB_NAME: $db_name");

// Establish connection using Unix socket
$conn = new mysqli(null, $db_user, $db_pass, $db_name, null, $db_port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

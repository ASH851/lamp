<?php
// Set the database host for Cloud SQL Proxy or localhost
$db_socket = getenv('CLOUD_SQL_CONNECTION_NAME');
$db_host = $db_socket ? "localhost:/cloudsql/$db_socket" : '127.0.0.1';

// Retrieve credentials from environment variables
$db_user = getenv('DB_USERNAME') ?: 'ashwani';
$db_pass = getenv('DB_PASSWORD') ?: 'ashwani';
$db_name = getenv('DB_NAME') ?: 'lamp_db';

// Establish the database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

<?php
// Get the Cloud SQL connection name from environment variables
$db_socket = getenv('CLOUD_SQL_CONNECTION_NAME');

// Construct the host string for Cloud SQL Proxy (Unix socket) or fallback to 127.0.0.1 for local testing
$db_host = $db_socket ? "localhost:/cloudsql/$db_socket" : '127.0.0.1';

// Retrieve credentials from environment variables or set default values
$db_user = getenv('DB_USERNAME') ?: 'ashwani';
$db_pass = getenv('DB_PASSWORD') ?: 'ashwani';
$db_name = getenv('DB_NAME') ?: 'lamp_db';

// Establish the database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    // Output error message for debugging purposes
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>

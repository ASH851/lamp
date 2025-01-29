<?php
// Get Cloud SQL connection name from environment variables
$db_socket = getenv('CLOUD_SQL_CONNECTION_NAME');
$db_ip = getenv('CLOUD_SQL_IP');  // This is the external or private IP of your Cloud SQL instance (if using TCP/IP)

// Get credentials from environment variables
$db_user = getenv('DB_USERNAME') ?: 'ashwani';
$db_pass = getenv('DB_PASSWORD') ?: 'ashwani';
$db_name = getenv('DB_NAME') ?: 'lamp_db';

// Debugging: Print connection info (check logs in Cloud Run)
error_log("DB_USER: $db_user");
error_log("DB_NAME: $db_name");

// Check if Cloud SQL connection is configured for TCP/IP or Unix socket
if ($db_ip) {
    // Use TCP/IP connection
    $db_host = $db_ip;  // Use the Cloud SQL instance IP
    $db_port = 3306;     // MySQL default port for TCP/IP
    error_log("Connecting via TCP/IP using IP: $db_host:$db_port");
} else {
    // Use Unix socket connection (Cloud Run)
    $db_host = 'localhost';
    $db_port = "/cloudsql/$db_socket";  // This connects to Cloud SQL via the Unix socket
    error_log("Connecting via Unix socket using /cloudsql/$db_socket");
}

// Establish connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

<?php
// Get Cloud SQL public IP and credentials from environment variables
$db_host = getenv('CLOUD_SQL_IP');  // Public IP of the MySQL instance
$db_user = getenv('DB_USERNAME') ?: 'ashwani';  // MySQL user
$db_pass = getenv('DB_PASSWORD') ?: 'ashwanik';  // MySQL password
$db_name = getenv('DB_NAME') ?: 'lamp_db';  // MySQL database name

// Debugging: Print connection info (check logs in Cloud Run)
error_log("DB_HOST: $db_host");
error_log("DB_USER: $db_user");
error_log("DB_NAME: $db_name");

// Set MySQL port for TCP/IP
$db_port = 3306;  // MySQL default port

// Establish connection using public IP
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

<?php
// Get the Cloud SQL connection name from environment variables
$db_socket = getenv('CLOUD_SQL_CONNECTION_NAME');

// Database configuration
$db_user = getenv('DB_USERNAME') ?: 'ashwani';
$db_pass = getenv('DB_PASSWORD') ?: 'ashwani';
$db_name = getenv('DB_NAME') ?: 'lamp_db';

// Initialize connection parameters
$mysqli_config = [
    'user' => $db_user,
    'password' => $db_pass,
    'dbname' => $db_name,
    'flags' => MYSQLI_CLIENT_SSL,
];

if ($db_socket) {
    // For Cloud SQL using Unix socket
    $mysqli_config['unix_socket'] = "/cloudsql/$db_socket";
} else {
    // For local development
    $mysqli_config['host'] = '0.0.0.0';
    $mysqli_config['port'] = 3306;
}

try {
    // Create connection using the configuration array
    $conn = new mysqli(
        isset($mysqli_config['host']) ? $mysqli_config['host'] : null,
        $mysqli_config['user'],
        $mysqli_config['password'],
        $mysqli_config['dbname'],
        isset($mysqli_config['port']) ? $mysqli_config['port'] : null,
        isset($mysqli_config['unix_socket']) ? $mysqli_config['unix_socket'] : null
    );

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "Connected successfully";
    
} catch (Exception $e) {
    // Log the error and display a user-friendly message
    error_log($e->getMessage());
    die("Database connection error. Please try again later.");
}
?>

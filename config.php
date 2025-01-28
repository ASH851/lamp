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
    // For local development, try different socket paths
    $socket_paths = [
        '/var/run/mysqld/mysqld.sock',
        '/tmp/mysql.sock',
        '/var/lib/mysql/mysql.sock'
    ];
    
    $socket_found = false;
    foreach ($socket_paths as $socket) {
        if (file_exists($socket)) {
            $mysqli_config['unix_socket'] = $socket;
            $socket_found = true;
            break;
        }
    }
    
    // If no socket found, fallback to TCP/IP
    if (!$socket_found) {
        $mysqli_config['host'] = '127.0.0.1';
        $mysqli_config['port'] = 3306;
    }
}

try {
    // Create connection using the configuration array
    if (isset($mysqli_config['unix_socket'])) {
        $conn = new mysqli(
            null,
            $mysqli_config['user'],
            $mysqli_config['password'],
            $mysqli_config['dbname'],
            null,
            $mysqli_config['unix_socket']
        );
    } else {
        $conn = new mysqli(
            $mysqli_config['host'],
            $mysqli_config['user'],
            $mysqli_config['password'],
            $mysqli_config['dbname'],
            $mysqli_config['port']
        );
    }

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "Connected successfully";
    
} catch (Exception $e) {
    // Log the error with more details
    error_log("Database connection error: " . $e->getMessage());
    error_log("Current configuration: " . print_r($mysqli_config, true));
    die("Database connection error. Please try again later.");
}
?>

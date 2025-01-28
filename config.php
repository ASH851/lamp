<?php
$servername = getenv('DB_HOST'); // MySQL host
$username = getenv('DB_USER'); // MySQL username
$password = getenv('DB_PASS'); // MySQL password
$dbname = getenv('DB_NAME'); // MySQL database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to MySQL database!";
?>

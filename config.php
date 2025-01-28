<?php
// MySQL database connection details
$servername = "/cloudsql/gcp-learning-2008:us-central1:ashwani";  // Replace with your Cloud SQL connection name
$username = "ashwani";  // MySQL username
$password = "ashwani";  // MySQL password
$dbname = "registered";  // MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to MySQL database!";
?>

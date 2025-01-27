<?php
$host = 'lamp-db'; 
$username = 'ashwani';
$password = 'ashwani';
$database = 'registered';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

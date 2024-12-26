<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'hotelsystem';

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

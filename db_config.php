<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "eccomerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// echo '<pre>';
// var_dump($conn);
// echo '</pre>';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

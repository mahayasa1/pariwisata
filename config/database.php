<?php 

$username = 'root';
$password = '';
$host = 'localhost';
$database = 'db_pariwisata';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

?>


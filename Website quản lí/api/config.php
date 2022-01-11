<?php 

$servername = 'localhost';
$username = 'id18056589_root';
$password = '9^>~*>JpW9N1#{rt';
$dbname = 'id18056589_quanlitour';
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) echo "Connection Error: " . $conn->connect_error;

?>
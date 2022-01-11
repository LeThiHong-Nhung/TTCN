<?php
session_start();
define('SITEURL','https://quanlitourejm.000webhostapp.com/');

$hostname = "localhost";
$username = "id18056589_root";
$password = "9^>~*>JpW9N1#{rt";
$dbname = "id18056589_quanlitour";


$conn = new mysqli($hostname, $username, $password, $dbname);
mysqli_set_charset($conn,'UTF8');
if ($conn->connect_error) {
    echo "Lỗi kết nối cơ sở dữ liệu " . $conn->connect_error;
}
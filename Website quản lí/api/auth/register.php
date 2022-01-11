<?php
require('../config.php');

$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];

$existCus = "SELECT * FROM nguoidung WHERE madangnhap = '$email'";
$result = $conn->query($existCus);

if($result->num_rows > 0) {
    $msg = array("message" => "Error Email");    
}else {
    $password = md5($password);
    $createCus = "INSERT INTO nguoidung(madangnhap, tennguoidung, matkhau, nguoiquanli, nhanvien) VALUES ('$email','$name','$password', 'no', 'no')";
    if($conn->query($createCus)) $msg = array("message" => "success");
    
}


echo json_encode($msg);

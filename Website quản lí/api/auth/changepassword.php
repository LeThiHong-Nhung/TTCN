<?php

require('../config.php');


$email = $_POST['email'];
$oldPass = $_POST['oldPass'];
$newPass = $_POST['newPass'];

$findUser = $conn->query("SELECT * FROM nguoidung WHERE madangnhap = '$email'");

if($findUser->num_rows > 0){
    $row = $findUser->fetch_assoc();
    if(md5($oldPass) == $row['matkhau']){
        $newPass = md5($newPass);
        $updatePass = $conn->query("UPDATE nguoidung SET matkhau = '$newPass' WHERE madangnhap = '$email'");
        if($updatePass){
            $msg = array('message' => 'successful');
        } else {
            $msg = array('message' => 'update fail');
        }
    }else{
        $msg = array('message' => 'incorrect');
    }
} 

echo json_encode($msg);
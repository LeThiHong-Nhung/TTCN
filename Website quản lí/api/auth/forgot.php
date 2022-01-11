<?php

require('../config.php');
require('../configmail.php');

$email = $_POST['email'];

$existUser = $conn->query("SELECT * FROM nguoidung WHERE madangnhap = '$email'");

if ($existUser->num_rows > 0) {
    $permitted_chars = '0123456789';
    $codeConfirm = substr(str_shuffle($permitted_chars), 0, 6);

    if(sendEmail($email,'Mã xác nhận.','Mã xác nhận của bạn là: '.$codeConfirm)){
        $msg = array('message' => $codeConfirm);
    } else {
        $msg = array('message' => 'err email');
    }
} else {
    $msg = array('message' => 'err email');
}

echo json_encode($msg);

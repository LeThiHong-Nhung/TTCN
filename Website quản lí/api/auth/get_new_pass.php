<?php

require('../config.php');
require('../configmail.php');

$email = $_POST['email'];

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzQWERTYUIOPASDFGHJKLZXCVBNM';
$permitted_A = 'QWERTYUIOPASDFGHJKLZXCVBNM';
$permitted_a = 'abcdefghijklmnopqrstuvwxyz';
$permitted_0 = '0123456789';
$newPassword = '@' .substr(str_shuffle($permitted_A), 0, 1).substr(str_shuffle($permitted_a), 0, 1).substr(str_shuffle($permitted_0), 0, 1). substr(str_shuffle($permitted_chars), 0, 6);
// $newPassword = '@12345678q';

if (sendEmail($email, 'Mật khẩu mới.', 'Mật khẩu mới của bạn là: ' . $newPassword)) {
    $newPassword = md5($newPassword);
    $updatePassword = $conn->query("UPDATE nguoidung SET matkhau = '$newPassword' WHERE madangnhap = '$email'");
    if(!$updatePassword) {
        echo json_encode('fail');
    }
}

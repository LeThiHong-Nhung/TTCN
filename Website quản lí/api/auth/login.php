<?php

require('../config.php');

$email = $_POST['email'];
$password = $_POST['password'];

$customer = $conn->query("SELECT * FROM nguoidung WHERE madangnhap = '$email'");

if($customer->num_rows > 0 ){
    $result = $customer->fetch_assoc();
    
    if(md5($password) == $result['matkhau']){               
        $msg = array('message' => 'success', 'result'=> $result);
    }else{
        $msg = array('message' => 'password error');
    }

    echo json_encode($msg);
    
} else {
    $msg = array('message' => 'password error');
    echo json_encode($msg);
}

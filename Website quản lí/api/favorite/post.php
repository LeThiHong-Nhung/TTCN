<?php
require('../config.php');

$username = $_POST['username'];
$matour = $_POST['matour'];


$result = $conn->query("SELECT * FROM `yeuthich` WHERE madangnhap = '$username' AND matour = '$matour'");
$arr = array();

if ($result->num_rows > 0) {
    if ($delete = $conn->query("DELETE FROM yeuthich WHERE madangnhap = '$username' AND matour = '$matour'")) {
        $arr['result'] = "delete";
    } else {
        $arr['result'] = "err delete";
    }
    
} else {
    if ($insert = $conn->query("INSERT INTO yeuthich VALUES ('$username','$matour')")) {
        $arr['result'] = "insert";
    } else {
        $arr['result'] = "err insert";
    }
}

echo json_encode($arr);

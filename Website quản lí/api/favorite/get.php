<?php
require('../config.php');

$username = $_GET['username'];
$matour = $_GET['matour'];

$result = $conn->query("SELECT * FROM yeuthich WHERE madangnhap = '$username' AND matour = '$matour'");
$arr = array();
if($result->num_rows > 0) {
    $arr['result'] = true;
}else {
    $arr['result'] = false;
}

echo json_encode($arr);
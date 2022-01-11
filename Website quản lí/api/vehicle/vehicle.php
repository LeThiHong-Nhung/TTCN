<?php
require('../config.php');

$vehicle = $_GET['id'];

$result = $conn->query("SELECT b.tenphuongtien FROM tour_phuongtien a, phuongtien b WHERE a.matour = '$vehicle' AND a.maphuongtien = b.maphuongtien");

$arr = array();

while($row = $result->fetch_assoc()){
    array_push($arr, $row);
}

echo json_encode($arr);

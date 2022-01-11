<?php
require('../config.php');

$email = $_GET['email'];

$arr = array();
$listFavorite = $conn->query("SELECT b.* FROM yeuthich a, danhsachtour b WHERE a.madangnhap = '$email' AND a.matour = b.matour");

while ($row = $listFavorite->fetch_assoc()) {
    $matuor = $row['matour'];
    // echo $matuor;
    $tour = $conn->query("SELECT b.hinhanh FROM tour_diemden a, diemden b WHERE a.madiemden = b.madiemden AND a.matour = '$matuor' LIMIT 1");
    if($tour->num_rows > 0){
        while($e = $tour->fetch_assoc()){
            $row['hinhanh'] = implode("", array_values($e));
        }  
    }  else {
        $row['hinhanh'] = '';
    }
    

    $rated = $conn->query("SELECT * FROM danhgiatour a, vetour b WHERE a.sove = b.sove AND b.matour = '$matuor'");
    if ($rated->num_rows > 0) {
        $rate = 0;
        while ($r = $rated->fetch_assoc()) {
            $rate += $r['sosao'];
        }
        $row['danhgia'] = strval($rate / $rated->num_rows);
    } else {
        $row['danhgia'] = '0';
    }

    array_push($arr, $row);
}

echo json_encode($arr);

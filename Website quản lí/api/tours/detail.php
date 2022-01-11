<?php 
require('../config.php');

$id = $_GET['id'];

if($id != ''){
    $arr = array();
    $tour = $conn->query("SELECT * FROM danhsachtour WHERE matour = '$id'");    

    $arr = $tour->fetch_assoc();
    $Img = $conn->query("SELECT b.hinhanh FROM tour_diemden a, diemden b WHERE a.madiemden = b.madiemden AND a.matour = '$id' LIMIT 1");
    if($tour->num_rows > 0){
        while($e = $tour->fetch_assoc()){
            $row['hinhanh'] = implode("", array_values($e));
        }  
    }  else {
        $row['hinhanh'] = '';
    }  

    $rated = $conn->query("SELECT * FROM danhgiatour a, vetour b WHERE a.sove = b.sove AND b.matour = '$id'");
    if($rated->num_rows > 0) {
        $rate = 0;
        while($r = $rated->fetch_assoc()) {
            $rate += $r['sosao'];
        }
        $row['danhgia'] = strval($rate / $rated->num_rows);
    }else{
        $row['danhgia'] = '0';
    }
}

echo json_encode($arr);

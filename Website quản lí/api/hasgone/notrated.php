<?php
require('../config.php');

$username = $_GET['username'];

$listTickets = $conn->query("SELECT * FROM `phieudangki` WHERE `madangnhap` = '$username'");

$arr = array();

while ($rowTicket = $listTickets->fetch_assoc()) {
    $makhachhang = $rowTicket['makhachhang'];
    $matour = $rowTicket['matour'];    
    //find tour has book
    $result = $conn->query("SELECT * FROM vetour WHERE makhachhang = '$makhachhang' AND matour = '$matour'");

    //find the tour
    if ($result->num_rows > 0) { 
        $resultTicket = $result->fetch_assoc();
        $sove = $resultTicket['sove'];        
        
        $hasrated = $conn->query("SELECT * FROM danhgiatour WHERE sove = '$sove'");
        if($hasrated->num_rows == 0) {
            $tours = $conn->query("SELECT * FROM danhsachtour WHERE matour = '$matour'");

            while ($row = $tours->fetch_assoc()) {
                $tour = $conn->query("SELECT b.hinhanh FROM tour_diemden a, diemden b WHERE a.madiemden = b.madiemden AND a.matour = '$matour' LIMIT 1");
                if($tour->num_rows > 0){
        while($e = $tour->fetch_assoc()){
            $row['hinhanh'] = implode("", array_values($e));
        }  
    }  else {
        $row['hinhanh'] = '';
    }
                $row['sove'] = $sove;

                if ($row['ngaykt'] < date('Y-m-d')) {
                    array_push($arr, $row);
                }
            }
        }
    }
}

echo json_encode($arr);

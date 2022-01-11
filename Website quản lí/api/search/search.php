
<?php
require('../config.php');

// $keyword = $_GET['keyword'];
$keyword=mysqli_real_escape_string($conn,$_GET['keyword']);

$arr = array();
$tours = $conn->query("SELECT a.* FROM danhsachtour a, tour_diemden b, diemden c WHERE a.matour = b.matour AND b.madiemden = c.madiemden AND (a.tentour LIKE '%$keyword%' OR c.tendiemden LIKE '%$keyword%') ORDER BY a.matour");

while ($row = $tours->fetch_assoc()) {
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
    if($rated->num_rows > 0) {
        $rate = 0;
        while($r = $rated->fetch_assoc()) {
            $rate += $r['sosao'];
        }
        $row['danhgia'] = strval($rate / $rated->num_rows);
    }else{
        $row['danhgia'] = '0';
    }

    array_push($arr, $row);
}

echo json_encode($arr);
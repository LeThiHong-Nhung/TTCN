<?php
require('../config.php');

$id = '';
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
$arr = array();

if ($id = '') {
    $places = $conn->query("SELECT * FROM diemden a, tour_diemden b WHERE  a.madiemden = b.madiemden AND b.matour = '$id'");
    while($row = $places->fetch_assoc()){        
         array_push($arr, $row);    
     };
} else {
    $places = $conn->query("SELECT * FROM diemden");
}
while ($row = $places->fetch_assoc()) {
    $place_code = $row['madiemden'];
    $counter = $conn->query("SELECT COUNT(*) FROM `tour_diemden` WHERE tour_diemden.madiemden = '$place_code'");
    while ($e = $counter->fetch_assoc()) {
        $row['related_tour'] = implode("", array_values($e));
    }
    array_push($arr, $row);
};
echo json_encode($arr);

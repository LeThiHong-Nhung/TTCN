<?php
require('../config.php');

$sove = $_POST['sove'];
$rating = $_POST['rating'];


if (isset($sove) && isset($rating)) {
    $insertRating = $conn->query("INSERT INTO danhgiatour VALUES ('$sove','$rating')");
    if ($insertRating) {
        $msg = array("message" => "Successfull");
    } else {
        $msg = array("message" => "Failure");
    }
}

echo json_encode($msg);

<?php
//include for bien siteurl
include("config/constants.php");

//destroy session
unset($_SESSION['user']);//unset session user
session_destroy();

//chuyen ve trang login
header("location:".SITEURL."login.php");
?>
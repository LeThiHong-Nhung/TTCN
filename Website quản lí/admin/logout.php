<?php
//include for bien siteurl
include("../config/constants.php");

//destroy session
unset($_SESSION['admin']);//unset session user
//chuyen ve trang login
header("location:".SITEURL."admin/login.php");
?>
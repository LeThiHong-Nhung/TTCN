<?php
if (!isset($_SESSION['admin'])) //neu session user chua duoc thiet lap
{
    $_SESSION['no-login-message'] = "<div class='error text-center'>Trước tiên, hãy đăng nhập để vào trang quản trị!</div>";
    header("location:".SITEURL."admin/login.php");
}
?>
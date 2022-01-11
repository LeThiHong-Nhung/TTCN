<?php include('config/constants.php'); include('admin/resize.php'); include('login-check.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Trang quản trị EJM - Nhân viên</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/style.css">
<script src='separate.js'></script>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>
<body>
    <div class="header"></div>
  <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
  <label for="openSidebarMenu" class="sidebarIconToggle">
    <div class="spinner diagonal part-1"></div>
    <div class="spinner horizontal"></div>
    <div class="spinner diagonal part-2"></div>
  </label>
  <div id="sidebarMenu" style="z-index:5;">
    <ul class="sidebarMenuInner">
        <li>QUẢN LÍ TOUR <span>Enjoy the Moment</span></li>
        <li><a href="<?php echo SITEURL; ?>index.php" >TRANG CHỦ</a></li><!--target="_blank": de mo trong tab moi -->
        <li><a href="<?php echo SITEURL; ?>tour.php" >TOUR</a></li>
        <li><a href="<?php echo SITEURL; ?>place.php" >ĐIỂM ĐẾN</a></li>
        <li><a href="<?php echo SITEURL; ?>phuongtien.php" >PHƯƠNG TIỆN</a></li>
        <li><a href="<?php echo SITEURL; ?>vetour.php" >VÉ TOUR</a></li>
        <li><a href="<?php echo SITEURL; ?>thongtinnhanvien.php" >THÔNG TIN NHÂN VIÊN</a></li>
        <li><a href="<?php echo SITEURL; ?>logout.php" >ĐĂNG XUẤT</a></li>
    </ul>
  </div>
  <div id='center' class="main center">
    <!-- <div class="mainInner">
      <div>PURE CSS SIDEBAR TOGGLE MENU</div>
    </div> -->
    <br>
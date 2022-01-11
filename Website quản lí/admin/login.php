<?php ob_start(); include('../config/constants.php'); ?>
<?php
if(isset($_SESSION['login']))
{
  echo $_SESSION['login'];
  unset($_SESSION['login']);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Custom Styling -->
  <link rel="stylesheet" href="../css/login.css">
  <title>Đăng nhập</title>
</head>

<body>
  <h1 id="tieude">Trang đăng nhập dành cho quản lí<h1>
      <form class="login" action="" method="POST">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="matkhau" placeholder="Mật khẩu">
        <button type="submit" name="submit">Đăng nhập</button>
        <div><a href="<?php echo SITEURL; ?>login.php">Nhân viên</a></div>
      </form>
</body>
</html>
<?php
if(isset($_POST['submit']))
{
    //lay du lieu tu form dang nhap
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $raw_pass=mysqli_real_escape_string($conn,$_POST['matkhau']);
    $pass=md5($raw_pass);
    //$check=((isset($_POST['remember'])!=0)?1:"");

    //kiem tra co ton tai admin k AND matkhau='$pass'
    $sql = "SELECT * FROM nguoidung WHERE madangnhap='$email' AND matkhau='$pass' AND nguoiquanli='yes' ";
    // var_dump($sql);
    // die();

    //thuc thi cau truy van
    $res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);

    if($count == 1) {
        $_SESSION['admin']=$email;//kiem tra neu user da dang nhap hoac neu khong logout se unset no
        header("location:".SITEURL."admin/index.php");
    }
    else{
        //dang nhap that bai
        $_SESSION['login']="<div class='error text-center'>Đăng nhập thất bại, email hoặc mật khẩu không khớp</div>";
        header("location:".SITEURL."admin/login.php");
    }
}
ob_end_flush();?>
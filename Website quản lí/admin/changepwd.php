<?php ob_start(); include('partials/menu.php'); ?>

<div class="container-xl">
<form class="table table-striped table-hover" action="" method="POST">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Đổi mật khẩu</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
            <tr>
                    <td>Mật khẩu hiện tại</td>
                    <td>
                        <input type="password" name="current_password" value="<?php if (isset($current_password)) echo $current_password; ?>" placeholder="Điền mật khẩu hiện tại">
                    </td>
                </tr>
                <tr>
                    <td>Mật khẩu mới</td>
                    <td>
                        <input type="password" name="new_password" value="<?php if (isset($new_password)) echo $new_password; ?>" placeholder="Điền mật khẩu mới">
                    </td>
                </tr>
                <tr>
                    <td>Xác nhận lại mật khẩu</td>
                    <td>
                        <input type="password" name="confirm_password" value="<?php if (isset($confirm_password)) echo $confirm_password; ?>" placeholder="Xác nhận lại mật khẩu mới">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php if(isset($id)) echo $id; ?>">
                        <input type="submit" name="submit" value="Đổi mật khẩu" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    </form>
</div>
<?php
if(isset($_POST['submit']))
{
    //echo "Button clicked";
    //lay thong tin de update
    $manv=$_GET['manv'];
    $sql = "SELECT * FROM nhanvien WHERE manv='$manv' ";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);
    $email=$row['email'];

    $raw_current_password = md5($_POST['current_password']);
    $current_password = mysqli_real_escape_string($conn, $raw_current_password);
    $raw_new_password = md5($_POST['new_password']);
    $new_password = mysqli_real_escape_string($conn, $raw_new_password);
    $raw_confirm_password = md5($_POST['confirm_password']);
    $confirm_password = mysqli_real_escape_string($conn, $raw_confirm_password);

    //chuan bi cau truy van AND pwd='$current_password'
    $sql = "SELECT * FROM nguoidung WHERE madangnhap='$email' AND nhanvien='yes' ";

    $res = mysqli_query($conn, $sql);

    var_dump($res);
    var_dump($sql);

    if($res == true)
    {
        //echo "co du lieu";
        $count = mysqli_num_rows($res);
        if($count == 1)
        {
            //co the doi mk
            echo "Tìm thấy nhân viên!";
            if($new_password==$confirm_password)
            {
                //echo "Password match";
                $sql2 = "UPDATE nguoidung SET 
                matkhau='$new_password'
                WHERE madangnhap='$email'  
                ";

                $res2 = mysqli_query($conn,$sql2);
                if($res2 == true){
                    //hien thi thong bao thanh cong
                    $_SESSION['change-pwd'] = "<div class='success'>Thay đổi mật khẩu thành công!</div>";
                    header("location:".SITEURL."admin/thongtinnhanvien.php");
                }
                else{
                    //hien thi thong bao khong thanh cong
                    $_SESSION['change-pwd'] = "<div class='error'>Thay đổi mật khẩu thất bại!</div>";
                    header("location:".SITEURL."admin/thongtinnhanvien.php");
                }
            }
            else{
                $_SESSION['pwd-not-match'] = "<div class='error'>Mật khẩu không trùng khớp!</div>";
                header("location:".SITEURL."admin/thongtinnhanvien.php");
            }
        }
        else {
            //khong the doi mk
            $_SESSION['user-not-found'] = "<div class='error'>Không tìm thấy nhân viên!</div>";
            header("location:".SITEURL."admin/index.php");
        }
    }
}
?>
<?php include('partials/footer.php'); ob_end_flush(); ?>
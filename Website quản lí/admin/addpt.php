<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['addpt'])) {
            echo $_SESSION['addpt']; //hien thi thong bao
            unset($_SESSION['addpt']); //xoa bo thong bao
        }
?>
<div class="container-xl">
<form class="table table-striped table-hover" action="" method="POST">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Thêm mới phương tiện</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã phương tiện</td>
                    <td><input type="text" name="mapt" value="<?php if(isset($mapt)) echo $mapt; ?>"></td>
                    <td>Tên phương tiện</td>
                    <td><input type="text" name="tenpt" value="<?php if(isset($tenpt)) echo $tenpt; ?>"></td>
                </tr>
                <tr>
                    <td>Mô tả (nếu có)</td>
                    <td colspan="3"><textarea name="mota" rows="2" cols="20"><?php if(isset($mota)) echo $mota; ?></textarea></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Thêm mới"><br><br>
            <a href="javascript:window.history.back(-1);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>

<?php
   if(isset($_POST['submit']))
   {
       $mapt=mysqli_real_escape_string($conn,$_POST['mapt']);
       $tenpt=mysqli_real_escape_string($conn,$_POST['tenpt']);
       $mota=mysqli_real_escape_string($conn,$_POST['mota']);

       $sql="INSERT INTO phuongtien SET
       maphuongtien='$mapt',
       tenphuongtien='$tenpt',
       mota='$mota' 
       ";

       $res=mysqli_query($conn, $sql);

       if ($res == true) {
        $_SESSION['addpt'] = "<div class='success'>Thêm phương tiện thành công!</div>";
        header('location:'.SITEURL.'admin/addpt.php');
        }
        else{
        $_SESSION['addpt'] = "<div class='error'>Thêm phương tiện thất bại!</div>";
        header("location:".SITEURL.'admin/addpt.php');
    }
   }
?>
           
        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
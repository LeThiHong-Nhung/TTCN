<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['updatept'])) {
            echo $_SESSION['updatept']; //hien thi thong bao
            unset($_SESSION['updatept']); //xoa bo thong bao
        }
?>
<div class="container-xl">
<form class="table table-striped table-hover" action="" method="POST">
<?php
        if(isset($_GET['maphuongtien']))
        {
            //lay id va dl
            $mapt=$_GET['maphuongtien'];
            //lay dl
            $sql = "SELECT * FROM phuongtien WHERE maphuongtien='$mapt' ";
            //thuc thi cau truy van
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                //lay dl
                $row = mysqli_fetch_assoc($res);
                $mapt = $row['maphuongtien'];
                $tenpt= $row['tenphuongtien'];
                $mota = $row['mota'];
            }
            else
            {
                $_SESSION['no-pt-found'] = "<div class='error'>Không tìm thấy phương tiện!</div>";
                header('location:'.SITEURL.'admin/phuongtien.php');
            }
        }
        else
        {
            //chuyen ve trang manage
            header('location:'.SITEURL.'admin/phuongtien.php');
        }
?>
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Chỉnh sửa phương tiện</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã phương tiện</td>
                    <td><input type="text" readonly name="mapt" value="<?php if(isset($mapt)) echo $mapt; ?>"></td>
                    <td>Tên phương tiện</td>
                    <td><input type="text" name="tenpt" value="<?php if(isset($tenpt)) echo $tenpt; ?>"></td>
                </tr>
                <tr>
                    <td>Mô tả (nếu có)</td>
                    <td colspan="3"><textarea name="mota" rows="2" cols="20"><?php if(isset($mota)) echo $mota; ?></textarea></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Xác nhận"><br><br>
            <a href="javascript:window.history.back(-1);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>

<?php
   if(isset($_POST['submit']))
   {
       $mapt=mysqli_real_escape_string($conn,$_POST['mapt']);
       $tenpt=mysqli_real_escape_string($conn,$_POST['tenpt']);
       $mota=mysqli_real_escape_string($conn,$_POST['mota']);

       $sql="UPDATE phuongtien SET
       tenphuongtien='$tenpt',
       mota='$mota' 
       WHERE maphuongtien='$mapt' 
       ";

       $res=mysqli_query($conn, $sql);

       if ($res == true) {
        $_SESSION['updatept'] = "<div class='success'>Chỉnh sửa phương tiện thành công!</div>";
        header('location:'.SITEURL.'admin/phuongtien.php');
        }
        else{
        $_SESSION['updatept'] = "<div class='error'>Chỉnh sửa phương tiện thất bại!</div>";
        header("location:".SITEURL.'admin/updatept.php');
    }
   }
?>
           
        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
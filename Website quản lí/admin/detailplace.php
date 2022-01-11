<?php ob_start(); include('partials/menu.php'); ?>

<div class="container-xl">
<form class="table table-striped table-hover" action="" method="POST" enctype="multipart/form-data">
<?php
        if(isset($_GET['madiemden']))
        {
            //lay id va dl
            $madiemden=$_GET['madiemden'];
            //lay dl
            $sql = "SELECT * FROM diemden WHERE madiemden='$madiemden' ";
            //thuc thi cau truy van
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                //lay dl
                $row = mysqli_fetch_assoc($res);
                $madiemden = $row['madiemden'];
                $tendiemden = $row['tendiemden'];
                $mota = $row['mota'];
                $tenanh = $row['hinhanh'];
            }
            else
            {
                $_SESSION['no-place-found'] = "<div class='error'>Không tìm thấy điểm đến!</div>";
                header('location:'.SITEURL.'admin/place.php');
            }
        }
        else
        {
            //chuyen ve trang manage
            header('location:'.SITEURL.'admin/place.php');
        }
?>
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Thông tin chi tiết điểm đến</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã điểm đến</td>
                    <td><input type="text" readonly name="madiemden" value="<?php if(isset($madiemden)) echo $madiemden; ?>"></td>
                    <td>Tên điểm đến</td>
                    <td><textarea name="tendiemden" readonly rows="2" cols="20"><?php if(isset($tendiemden)) echo $tendiemden; ?></textarea></td>
                </tr>
                <tr>
                    <td>Mô tả</td>
                    <td><textarea name="mota" readonly rows="2" cols="20"><?php if(isset($mota)) echo $mota; ?></textarea></td>
                    <td>Hình ảnh</td>
                    <td>
<?php
                    if($tenanh!="")
                    {
                        //hien thi anh
?>
                            <img src="<?php echo SITEURL; ?>images/<?php echo $tenanh; ?>" width="100px">
<?php
                    }
                    else{
                        //hien thong bao
                        echo "<div class='error'>Không có ảnh</div>";
                    }
?>
                </td>
                </tr>
                <tr><td>
                    <input type="hidden" name="hinhanh" value="<?php echo $tenanh; ?>">
                    <input type="hidden" name="madiemden" value="<?php echo $madiemden; ?>"></td>
                </tr>
            </table>
            <a href="javascript:window.history.back(-2);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>

        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
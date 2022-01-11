<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['updateplace'])) {
            echo $_SESSION['updateplace']; //hien thi thong bao
            unset($_SESSION['updateplace']); //xoa bo thong bao
        }
    if (isset($_SESSION['upload-place'])) {
            echo $_SESSION['upload-place']; //hien thi thong bao
            unset($_SESSION['upload-place']); //xoa bo thong bao
        }
    if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove']; //hien thi thong bao
            unset($_SESSION['failed-remove']); //xoa bo thong bao
        }
?>
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
                        <h2>Chỉnh sửa thông tin điểm đến</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã điểm đến</td>
                    <td><input type="text" readonly name="madiemden" value="<?php if(isset($madiemden)) echo $madiemden; ?>"></td>
                    <td>Tên điểm đến</td>
                    <td><textarea name="tendiemden" rows="2" cols="20"><?php if(isset($tendiemden)) echo $tendiemden; ?></textarea></td>
                </tr>
                <tr>
                    <td>Mô tả</td>
                    <td><textarea name="mota" rows="2" cols="20"><?php if(isset($mota)) echo $mota; ?></textarea></td>
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
                    <td><input type="file" name="hinhanh_moi"></td>
                </tr>
                <tr><td>
                    <input type="hidden" name="hinhanh" value="<?php echo $tenanh; ?>">
                    <input type="hidden" name="madiemden" value="<?php echo $madiemden; ?>"></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Xác nhận"><br><br>
            <a href="javascript:window.history.back(-2);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>

        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ?>
<?php
   if(isset($_POST['submit']))
   {
       $madiemden=mysqli_real_escape_string($conn,$_POST['madiemden']);
       $tendiemden=mysqli_real_escape_string($conn,$_POST['tendiemden']);
       $mota=mysqli_real_escape_string($conn,$_POST['mota']);
       $anhhientai=$_POST['hinhanh'];

        //cap nhat anh neu chon anh moi
        if(isset($_FILES['hinhanh_moi']['name'])){
            //echo $anhhientai;
            //get detail
            $tenanh=$_FILES['hinhanh_moi']['name'];
            if($tenanh!="")
            {
                //co anh, tai anh len, xoa anh cu
                //auto rename file
                //lay duoi file
                $ext = explode('.',$tenanh);
                $ext = end($ext);

                //doi ten file
                $tenanh="Place_".rand(0000,9990).'.'.$ext;

                $source_path=$_FILES['hinhanh_moi']['tmp_name'];
                $destination_path="../images/".$tenanh;
                //upload image
                $upload = move_uploaded_file($source_path,$destination_path);
                //kiem tra anh da tai len hay chua
                if($upload==false)
                {
                    $_SESSION['upload-place']="<div class='error'>Tải ảnh thất bại!</div>";
                    header('location:'.SITEURL.'admin/updateplace.php');
                    die();
                }
                //xoa anh cu
                if($anhhientai!=""){
                    $remove_path="../images/".$anhhientai;
                    $remove=unlink($remove_path);
                    //kiem tra anh cu da xoa hay chua, hien thong bao, stop
                    if($remove==false){
                        $_SESSION['failed-remove']="<div class='error'>Xoá ảnh cũ thất bại!</div>";
                        header('location:'.SITEURL.'admin/updateplace.php');
                        die();
                    }
                }
                
            }
            else{
            //khong co anh
            $tenanh=$anhhientai;
        }
        }
        else{
            $tenanh=$anhhientai;
        }
       $sql="UPDATE diemden SET
       tendiemden='$tendiemden',
       mota='$mota',
       hinhanh='$tenanh' 
       WHERE madiemden='$madiemden' 
       ";

       $res=mysqli_query($conn, $sql);
       if ($res == true) {
        $_SESSION['updateplace'] = "<div class='success'>Chỉnh sửa điểm đến thành công!</div>";
        //header("refresh: 1; url = javascript.history.goback(-1)")
        header('location:'.SITEURL.'admin/place.php');
        }
        else{
        $_SESSION['updateplace'] = "<div class='error'>Chỉnh sửa điểm đến thất bại!</div>";
        header("location:".SITEURL.'admin/updateplace.php');
        }
   }
ob_end_flush();
?>
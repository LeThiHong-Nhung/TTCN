<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['addplace'])) {
            echo $_SESSION['addplace']; //hien thi thong bao
            unset($_SESSION['addplace']); //xoa bo thong bao
        }
?>
<div class="container-xl">
<form class="table table-striped table-hover" action="" method="POST" enctype="multipart/form-data">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Thêm mới điểm đến</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã điểm đến</td>
                    <td><input type="text" name="madiemden" value="<?php if(isset($madiemden)) echo $madiemden; ?>"></td>
                    <td>Tên điểm đến</td>
                    <td><textarea name="tendiemden" rows="2" cols="20"><?php if(isset($tendiemden)) echo $tendiemden; ?></textarea></td>
                </tr>
                <tr>
                    <td>Mô tả</td>
                    <td><textarea name="mota" rows="2" cols="20"><?php if(isset($mota)) echo $mota; ?></textarea></td>
                    <td>Hình ảnh</td>
                    <td><input type="file" name="hinhanh"></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Thêm mới"><br><br>
            <a href="javascript:window.history.back(-1);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>

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
       $tenanh='';

    //kiem tra anh duoc chon chua
    //print_r($_FILES['hinhanh']);
    //die();//kiem tra va dung tai day

    if(isset($_FILES['hinhanh']['name']))
    {
        //tai anh lên
        //ten, nguon, dich
        //resize
        //resize_image('force',&$_FILES['hinhanh'],&$_FILES['hinhanh'],1700,1225);
        $tenanh=$_FILES['hinhanh']['name'];

        //upload anh khi anh khong duoc chon
        if($tenanh!="")
        {
        //auto rename file
        //lay duoi file
        $ext = explode('.',$tenanh);
        $ext = end($ext);

        //doi ten file
        $tenanh="Place_".rand(0000,9999).'.'.$ext;

        $source_path=$_FILES['hinhanh']['tmp_name'];
        $destination_path="../images/".$tenanh;
        

        //upload image
        $upload = move_uploaded_file($source_path,$destination_path);
        //kiem tra anh da tai len hay chua
        if($upload==false)
        {
            $_SESSION['upload']="<div class='error'>Tải ảnh thất bại!</div>";
            header('location:'.SITEURL.'admin/addplace.php');
            die();
        }
    }
    }
    else{
        //khong tai anh va gan gia tri la ''
        $tenanh='';
    }
       $sql="INSERT INTO diemden SET
       madiemden='$madiemden',
       tendiemden='$tendiemden',
       mota='$mota',
       hinhanh='$tenanh' 
       ";

       $res=mysqli_query($conn, $sql);
       if ($res == true) {
        $_SESSION['addplace'] = "<div class='success'>Thêm điểm đến thành công!</div>";
        //header("refresh: 1; url = javascript.history.goback(-1)")
        //header("refresh: 1; url = javascript:window.history.back(-1);");
        header('location:'.SITEURL.'admin/addplace.php');
        }
        else{
        $_SESSION['addplace'] = "<div class='error'>Thêm điểm đến thất bại!</div>";
        header("location:".SITEURL.'admin/addplace.php');
        }
   }
ob_end_flush();
?>
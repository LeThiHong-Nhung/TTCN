<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['addlang'])) {
            echo $_SESSION['addlang']; //hien thi thong bao
            unset($_SESSION['addlang']); //xoa bo thong bao
        }
?>
<div class="container-xl">
<form class="table table-striped table-hover" action="" method="POST">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Thêm mới ngoại ngữ</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã trình độ</td>
                    <td><input type="text" name="matrinhdo" value="<?php if(isset($matd)) echo $matd; ?>"></td>
                    <td>Tên trình độ</td>
                    <td><input type="text" name="tentrinhdo" value="<?php if(isset($tentd)) echo $tentd; ?>"></td>
                </tr>
                <tr>
                    <td>Tên ngoại ngữ</td>
                    <td colspan="2"><input type="text" name="tenngoaingu" value="<?php if(isset($tennn)) echo $tennn; ?>"></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Thêm mới">
<?php
   if(isset($_POST['submit']))
   {
       $matd=mysqli_real_escape_string($conn,$_POST['matrinhdo']);
       $tentd=mysqli_real_escape_string($conn,$_POST['tentrinhdo']);
       $tennn=mysqli_real_escape_string($conn,$_POST['tenngoaingu']);

       $sql="INSERT INTO ngoaingu SET
       matrinhdo='$matd',
       tentrinhdo='$tentd',
       tenngoaingu='$tennn' 
       ";

       $res=mysqli_query($conn, $sql);

       if ($res == true) {
        $_SESSION['addlang'] = "<div class='success'>Thêm ngoại ngữ thành công!</div>";
        header('location:'.SITEURL.'admin/addnv.php');
        }
        else{
        $_SESSION['addlang'] = "<div class='error'>Thêm ngoại ngữ thất bại!</div>";
        header("location:".SITEURL.'admin/addlang.php');
    }
   }
?>
           
        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
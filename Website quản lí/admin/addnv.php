<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['addnv'])) {
            echo $_SESSION['addnv']; //hien thi thong bao
            unset($_SESSION['addnv']); //xoa bo thong bao
        }
        if (isset($_SESSION['addlang'])) {
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
                        <h2>Thêm mới nhân viên</h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="<?php echo SITEURL; ?>admin/addlang.php" class="btn btn-secondary" name="addlang"><i class="material-icons">&#xE147;</i> <span>Thêm ngoại ngữ</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã nhân viên</td>
                    <?php
                    $sql3="SELECT MAX(substring(manv,3)+0) as stt from nhanvien";
                    //$sql3="SELECT manv FROM nhanvien order by manv desc LIMIT 1";
                    $res3=mysqli_query($conn,$sql3);
                    $row3=mysqli_fetch_array($res3);
                    // //var_dump($row3);
                    // $ma1=$row3['manv'];
                    // //var_dump($ma1);
                    // $stt=substr($ma1,2,6);
                    // //var_dump($stt);
                    // $stt=$stt+1;
                    // //var_dump($stt);
                    // $manv="NV".$stt;
                    // //var_dump($matour);
                    
                    $ma1=$row3['stt'];
                    $stt=$ma1+1;
                    $manv="NV".$stt;
                    ?>
                    <td><input type="text" readonly name="manv" value="<?php if(isset($manv)) echo $manv; ?>"></td>
                    <td>Họ tên</td>
                    <td><input type="text"  name="hoten" value="<?php if(isset($hoten)) echo $hoten; ?>"></td>
                    <td>Giới tính</td>
                    <td><input type="radio" name="gioitinh" value="Nữ">Nữ <input type="radio" name="gioitinh" value="Nam">Nam <input type="radio" name="gioitinh" value="T3">Giới tính thứ 3 </td>
                </tr>
                <tr>
                    <td>Ngày sinh</td>
                    <td><input type="date" name="ngaysinh"></td>
                    <td>Trình độ</td>
                    <td>
                            <div>
                            <input type="text" name="trinhdo" list="trinhdo" multiple="multiple" style="width: 100%;" />

                            <datalist id="trinhdo">
                            <?php
                                $sql2 = "SELECT trinhdo FROM nhanvien";
                                $res2 = mysqli_query($conn, $sql2);
                                while ($row2 = mysqli_fetch_assoc($res2)) {
                                $trinhdo = $row2['trinhdo'];
                                echo "<option value='$trinhdo'>";
                                echo $trinhdo;
                                echo "</option>";
                                }
                                ?>
                            </datalist>                               
                            </div>
                        </td>
                </tr>
                <tr>
                    <td>Số điện thoại</td>
                    <td><input type="number" name="sdt" value="<?php if(isset($sdt)) echo $sdt; ?>"></td>
                    <td>Email</td>
                    <td><input type="email" name="email" value="<?php if(isset($email)) echo $email; ?>"></td>
                </tr>
                <tr>
                    <td>Ngoại ngữ</td>
                    <td colspan="3">
                            <div>
                            <input type="text" name="ngoaingu" list="Suggestions" multiple="multiple" style="width: 100%;" />

                            <datalist id="Suggestions">
                            <?php
                                $sql1 = "SELECT * FROM ngoaingu";
                                $res1 = mysqli_query($conn, $sql1);
                                while ($row1 = mysqli_fetch_assoc($res1)) {
                                $matrinhdo = $row1['matrinhdo'];
                                $tentrinhdo = $row1['tentrinhdo'];
                                echo "<option value='$matrinhdo'>";
                                echo $tentrinhdo;
                                echo "</option>";
                                }
                                ?>
                            </datalist>                               
                            </div>
                        </td>
                </tr>
                <tr>
                    <td>Vai trò</td>
                    <td><input type="radio" name="nguoiquanli" value="yes">Người quản lí  <input type="radio" name="nhanvien" value="yes">Nhân viên</td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Thêm mới"><br><br>
            <a href="javascript:window.history.back(-1);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>

<?php
   if(isset($_POST['submit']))
   {
       $manv=mysqli_real_escape_string($conn,$_POST['manv']);
       $hoten=mysqli_real_escape_string($conn,$_POST['hoten']);
       $ngaysinh=$_POST['ngaysinh'];
       $sdt=$_POST['sdt'];
       $gioitinh=$_POST['gioitinh'];
       $trinhdo=mysqli_real_escape_string($conn,$_POST['trinhdo']);
       $email=mysqli_real_escape_string($conn,$_POST['email']);
       $manglang=$_POST['ngoaingu'];
       $ngoaingu=explode(",",$manglang);
       
       $mk='1234';
       $mk=md5($mk);
       if($_POST['nhanvien']!='')
       {
        $nhanvien=$_POST['nhanvien'];
       }
       else{
           $nhanvien=NULL;
       }
       if($_POST['nguoiquanli']!='')
       {
        $nguoiquanli=$_POST['nguoiquanli'];
    }
       else{
           $nguoiquanli=NULL;
       }

       $sql="INSERT INTO nhanvien SET
       manv='$manv',
       hoten='$hoten',
       trinhdo='$trinhdo',
       gioitinh='$gioitinh',
       ngaysinh='$ngaysinh',
       sdt='$sdt',
       email='$email' 
       ";

       $res=mysqli_query($conn, $sql);

       if($res == true)
       {
        foreach ($ngoaingu as $key => $value) {
                        $sqldd="INSERT INTO nv_ngoaingu SET
                        manv='$manv',
                        matrinhdo='$value' 
                        ";
                        $resdd=mysqli_query($conn,$sqldd);
                    }
        $sqlmk="INSERT INTO nguoidung SET madangnhap='$email',tennguoidung='$hoten',matkhau='$mk',nhanvien='$nhanvien',nguoiquanli='$nguoiquanli' ";
        $resmk=mysqli_query($conn,$sqlmk);
       }

       if ($res == true) {
        $_SESSION['addnv'] = "<div class='success'>Thêm nhân viên thành công!</div>";
        header('location:'.SITEURL.'admin/nhanvien.php');
        }
        else{
        $_SESSION['addnv'] = "<div class='error'>Thêm nhân viên thất bại!</div>";
        header("location:".SITEURL.'admin/addnv.php');
    }
   }
?>
           
        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
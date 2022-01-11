<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['updatenv'])) {
            echo $_SESSION['updatenv']; //hien thi thong bao
            unset($_SESSION['updatenv']); //xoa bo thong bao
        }
?>
<div class="container-xl">
<form class="table table-striped table-hover" action="" method="POST">
<?php
        if(isset($_GET['manv']))
        {
            //lay id va dl
            $manv=$_GET['manv'];
            //lay dl
            $sql = "SELECT * FROM nhanvien WHERE manv='$manv' ";
            //thuc thi cau truy van
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                //lay dl
                $row = mysqli_fetch_assoc($res);
                $manv = $row['manv'];
                $hoten = $row['hoten'];
                $trinhdo = $row['trinhdo'];
                $gioitinh = $row['gioitinh'];
                $ngaysinh=$row['ngaysinh'];
                $sdt=$row['sdt'];
                $email=$row['email'];

                //lay tt ngoai ngu
                $sqlnn="SELECT b.tentrinhdo,b.matrinhdo
                FROM nv_ngoaingu a join ngoaingu b on a.matrinhdo=b.matrinhdo
                WHERE a.manv='$manv' ";
                $resnn=mysqli_query($conn,$sqlnn);
                $rownn=mysqli_fetch_assoc($resnn);
                $nn=$rownn['tentrinhdo'];
                $nns=$rownn['matrinhdo'];
            }
            else
            {
                $_SESSION['no-nv-found'] = "<div class='error'>Không tìm thấy nhân viên!</div>";
                header('location:'.SITEURL.'admin/nhanvien.php');
            }
        }
        else
        {
            //chuyen ve trang manage
            header('location:'.SITEURL.'admin/nhanvien.php');
        }
?>
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Chỉnh sửa thông tin nhân viên</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã nhân viên</td>
                    <td><input type="text" readonly name="manv" value="<?php if(isset($manv)) echo $manv; ?>"></td>
                    <td>Họ tên</td>
                    <td><input type="text" name="hoten" value="<?php if(isset($hoten)) echo $hoten; ?>"></td>
                    <td>Giới tính</td>
                    <td><input type="radio" name="gioitinh" value="Nữ" <?php if($gioitinh=='Nữ') echo "checked"; ?>>Nữ <input type="radio" <?php if($gioitinh=='Nam') echo "checked"; ?> name="gioitinh" value="Nam" >Nam <input type="radio" <?php if($gioitinh=='T3') echo "checked"; ?> name="gioitinh" value="T3">Giới tính thứ 3 </td>
                </tr>
                <tr>
                    <td>Ngày sinh</td>
                    <td><input type="date" name="ngaysinh" value="<?php echo $ngaysinh; ?>"></td>
                    <td>Trình độ</td>
                    <td><input type="text" readonly name="trinhdoht" value="<?php echo $trinhdo; ?>"></td>
                    <td>Cập nhật</td>
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
                    <td><input type="text" readonly name="nnht" value="<?php echo $nn; ?>"></td>
                    <td>Cập nhật</td>
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
            </table>
            <input type="submit" name="submit" value="Xác nhận"><br><br>
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
       $trinhdoht=$_POST['trinhdoht'];
       $nnht=$nns;

       //trinhdo va nn cuoi cung
       $tdcc=$trinhdo;
       $nncc=$ngoaingu;


       if($trinhdo=="")
       {
           $tdcc=$trinhdoht;
       }
       if($ngoaingu=="")
       {
           $nncc=$nnht;
       }

       //var_dump($tdcc);
       //var_dump($nncc);
       //echo "<br>";

       $sql="UPDATE nhanvien SET
       hoten='$hoten',
       trinhdo='$tdcc',
       gioitinh='$gioitinh',
       ngaysinh='$ngaysinh',
       sdt='$sdt',
       email='$email' 
       WHERE manv='$manv' 
       ";
        //var_dump($sql);
        //die();
       $res=mysqli_query($conn, $sql);
       //var_dump($res);
       //echo mysqli_error($conn);
       //die();

       if($res == true)
       {
        //xoa trinh do ngoai ngu cu, cap nhat trinh do ngoai ngu moi
        $sqlx="DELETE FROM nv_ngoaingu WHERE manv='$manv' ";
        $resx=mysqli_query($conn,$sqlx);
        foreach ($nncc as $key => $value) {
                        $sqldd="INSERT INTO nv_ngoaingu SET
                        manv='$manv',
                        matrinhdo='$value' 
                        ";
                        $resdd=mysqli_query($conn,$sqldd);
                    }
       }

       if ($res == true) {
        $_SESSION['updatenv'] = "<div class='success'>Chỉnh sửa nhân viên thành công!</div>";
        header('location:'.SITEURL.'admin/nhanvien.php');
        }
        else{
        $_SESSION['updatenv'] = "<div class='error'>Chỉnh sửa nhân viên thất bại!</div>";
        header("location:".SITEURL.'admin/updatenv.php');
    }
   }
?>
           
        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
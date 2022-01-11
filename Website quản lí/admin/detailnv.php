<?php ob_start(); include('partials/menu.php'); ?>

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

                //lấy chứng chỉ ngoại ngữ của nv
                $sqlnn="SELECT b.tentrinhdo
                FROM nv_ngoaingu a join ngoaingu b on a.matrinhdo=b.matrinhdo
                WHERE a.manv='$manv' ";
                $resnn=mysqli_query($conn,$sqlnn);
                $rownn=mysqli_fetch_assoc($resnn);
                $tentrinhdo=$rownn['tentrinhdo'];
            }
            else
            {
                $_SESSION['no-place-found'] = "<div class='error'>Không tìm thấy nhân viên!</div>";
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
                    <td><input type="text" readonly name="hoten" value="<?php if(isset($hoten)) echo $hoten; ?>"></td>
                    <td>Giới tính</td>
                    <td><input type="text" readonly name="gioitinh" value="<?php echo $gioitinh; ?>"> </td>
                </tr>
                <tr>
                    <td>Ngày sinh</td>
                    <td><input type="date" readonly name="ngaysinh" value="<?php echo $ngaysinh; ?>"></td>
                    <td>Trình độ</td>
                    <td><input type="text" readonly name="trinhdo" value="<?php echo $trinhdo; ?>"></td>
                </tr>
                <tr>
                    <td>Số điện thoại</td>
                    <td><input type="number" readonly name="sdt" value="<?php if(isset($sdt)) echo $sdt; ?>"></td>
                    <td>Email</td>
                    <td><input type="email" readonly name="email" value="<?php if(isset($email)) echo $email; ?>"></td>
                </tr>
                <tr>
                    <td>Ngoại ngữ</td>
                    <td><input type="text" readonly name="ngoaingu" value="<?php echo $tentrinhdo; ?>"></td>
                </tr>
            </table>
            <a href="javascript:window.history.back(-1);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>

        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
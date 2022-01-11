<?php ob_start(); include('partials/menu.php'); ?>
<div class="container-xl">
<form class="table table-striped table-hover" action="" method="POST">
<?php
        if(isset($_GET['matour']))
        {
            //lay id va dl
            $matour=$_GET['matour'];
            //lay dl
            $sql = "SELECT * FROM danhsachtour WHERE matour='$matour' ";
            //thuc thi cau truy van
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                //lay dl
                $row = mysqli_fetch_assoc($res);
                $matour = $row['matour'];
                $tentour = $row['tentour'];
                $ngaybd = $row['ngaybd'];
                $ngaykt= $row['ngaykt'];
                $giatour = $row['giatour'];
                $khachsan = $row['khachsan'];
                $mota = $row['mota'];
                $tinhtrang = $row['tinhtrang'];

                //tim anh trong bang diem den
                $sqldd="SELECT a.hinhanh, a.tendiemden from diemden a join tour_diemden b on a.madiemden=b.madiemden where b.matour='$matour' LIMIT 1 ";
                $resdd=mysqli_query($conn, $sqldd);
                $rowdd=mysqli_fetch_assoc($resdd);
                $tenanh=$rowdd['hinhanh'];
                $tendiemden=$rowdd['tendiemden'];

                //tìm các phuong tien lien quan
                $sqld="SELECT b.tenphuongtien
                FROM tour_phuongtien a join phuongtien b on a.maphuongtien=b.maphuongtien
                WHERE a.matour='$matour' ";
                $resd=mysqli_query($conn, $sqld);
                $rowd=mysqli_fetch_assoc($resd);
                $tenphuongtien=$rowd['tenphuongtien'];

            }
            else
            {
                $_SESSION['no-tour-found'] = "<div class='error'>Không tìm thấy tour</div>";
                header('location:'.SITEURL.'admin/tour.php');
            }
        }
        else
        {
            //chuyen ve trang manage
            header('location:'.SITEURL.'admin/tour.php');
        }
?>
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Thông tin chi tiết tour</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã tour</td>
                    <td><input type="text" readonly name="matour" value="<?php if(isset($matour)) echo $matour; ?>"></td>
                    <td>Ngày bắt đầu</td>
                    <td><input type="date" readonly name="ngaybd" value="<?php if(isset($ngaybd)) echo $ngaybd; ?>"></td>
                    <td>Ngày kết thúc</td>
                    <td><input type="date" readonly name="ngaykt" value="<?php if(isset($ngaykt)) echo $ngaykt; ?>"></td>
                </tr>
                <tr>
                    <td>Tên tour</td>
                    <td><textarea name="tentour" readonly rows="2" cols="20"><?php if(isset($tentour)) echo $tentour; ?></textarea></td>
                    <td>Giá tour</td>
                    <td><input type="number" readonly name="giatour" value="<?php if(isset($giatour)) echo $giatour; ?>"></td>
                    <td>Khách sạn</td>
                    <td><textarea name="khachsan" readonly rows="2" cols="20"><?php if(isset($khachsan)) echo $khachsan; ?></textarea></td>
                </tr>
                <tr>
                    <td>Mô tả</td>
                    <td><textarea name="mota" readonly rows="2" cols="20"><?php if(isset($mota)) echo $mota; ?></textarea></td>
                    <td>Tình trạng</td>
                    <td><input type="text" readonly name="tinhtrang" value="<?php if($tinhtrang=='no') echo 'Đóng'; else echo 'Mở'; ?>"  ></td>
                    <td>Phương tiện</td>
                    <td><input type="text" readonly name="phuongtien" value="<?php echo $tenphuongtien; ?>"></td>
                </tr>
                <tr>
                        <td>Điểm đến</td>
                        <td><input type="text" readonly name="diemden" value="<?php echo $tendiemden; ?>"></td>
                        <td>Hình ảnh</td>
                        <td>
                        <div>
                            <?php
                            if ($tenanh == "") {
                                echo "<div class='error'>Không có ảnh</div>";
                            } else {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/<?php echo $tenanh; ?>" alt="Diemden" width="120px" height="auto">
                            <?php
                            }
                            ?>
                        </div>
                    <div>
                        </td>
                </tr>
            </table>
            <a href="javascript:window.history.back(-1);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>

        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
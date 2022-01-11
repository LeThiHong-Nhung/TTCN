<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; //hien thi thong bao
            unset($_SESSION['add']); //xoa bo thong bao
        }
        if (isset($_SESSION['addplace'])) {
            echo $_SESSION['addplace']; //hien thi thong bao
            unset($_SESSION['addplace']); //xoa bo thong bao
        }
        if (isset($_SESSION['addpt'])) {
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
                        <h2>Thêm mới tour</h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="<?php echo SITEURL; ?>admin/addplace.php" class="btn btn-secondary" name="adduser"><i class="material-icons">&#xE147;</i> <span>Thêm địa điểm</span></a>
                        <a href="<?php echo SITEURL; ?>admin/addpt.php" class="btn btn-secondary"><i class="material-icons">&#xE147;</i> <span>Thêm phương tiện</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>Mã tour</td>
                    <?php
                    $sql3="SELECT MAX(substring(matour,2)+0) as stt from danhsachtour";
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
                    $matour="T".$stt;
                    ?>
                    <td><input type="text" readonly name="matour" value="<?php if(isset($matour)) echo $matour; ?>"></td>
                    <td>Ngày bắt đầu</td>
                    <td><input type="date" name="ngaybd" value="<?php if(isset($ngaybd)) echo $ngaybd; ?>"></td>
                    <td>Ngày kết thúc</td>
                    <td><input type="date" name="ngaykt" value="<?php if(isset($ngaykt)) echo $ngaykt; ?>"></td>
                </tr>
                <tr>
                    <td>Tên tour</td>
                    <td><textarea name="tentour" rows="2" cols="20"><?php if(isset($tentour)) echo $tentour; ?></textarea></td>
                    <td>Giá tour</td>
                    <td><input type="number" name="giatour" value="<?php if(isset($giatour)) echo $giatour; ?>"></td>
                    <td>Khách sạn</td>
                    <td><textarea name="khachsan" rows="2" cols="20"><?php if(isset($khachsan)) echo $khachsan; ?></textarea></td>
                </tr>
                <tr>
                    <td>Mô tả</td>
                    <td><textarea name="mota" rows="2" cols="20"><?php if(isset($mota)) echo $mota; ?></textarea></td>
                    <td>Tình trạng</td>
                    <td><input type="radio" name="tinhtrang" value="yes">Mở <input type="radio" name="tinhtrang" value="no">Đóng</td>
                    <td>Phương tiện</td>
                    <td>
                            <div>
                            <input type="text" name="phuongtien" list="phuongtien" multiple="multiple" style="width: 100%;" />

                            <datalist id="phuongtien">
                            <?php
                                $sql2 = "SELECT * FROM phuongtien";
                                $res2 = mysqli_query($conn, $sql2);
                                while ($row2 = mysqli_fetch_assoc($res2)) {
                                $mapt = $row2['maphuongtien'];
                                $tenpt = $row2['tenphuongtien'];
                                echo "<option value='$mapt'>";
                                echo $tenpt;
                                echo "</option>";
                                }
                                ?>
                            </datalist>                               
                            </div>
                        </td>
                </tr>
                <tr>
                        <td>Điểm đến</td>
                        <td colspan="3">
                            <div>
                            <input type="text" name="place" list="Suggestions" multiple="multiple" style="width: 100%;" />

                            <datalist id="Suggestions">
                            <?php
                                $sql1 = "SELECT * FROM diemden";
                                $res1 = mysqli_query($conn, $sql1);
                                while ($row1 = mysqli_fetch_assoc($res1)) {
                                $madiemden = $row1['madiemden'];
                                $tendiemden = $row1['tendiemden'];
                                echo "<option value='$madiemden'>";
                                echo $tendiemden;
                                echo "</option>";
                                }
                                ?>
                            </datalist>                               
                            </div>
                        </td>
                    </tr>
            </table>
            <input type="submit" name="submit" value="Thêm mới"><br><br>
            <a href="javascript:window.history.back(-1);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>

<?php
   if(isset($_POST['submit']))
   {
       $matour=mysqli_real_escape_string($conn,$_POST['matour']);
       $tentour=mysqli_real_escape_string($conn,$_POST['tentour']);
       $ngaybd=$_POST['ngaybd'];
       $ngaykt=$_POST['ngaykt'];
       $giatour=$_POST['giatour'];
       $khachsan=mysqli_real_escape_string($conn,$_POST['khachsan']);
       $mota=mysqli_real_escape_string($conn,$_POST['mota']);
       $tinhtrang=$_POST['tinhtrang'];
       $mangdd=$_POST['place'];
       $place=explode(",",$mangdd);
       $mangpt=$_POST['phuongtien'];
       $phuongtien=explode(",",$mangpt);

       $sql="INSERT INTO danhsachtour SET
       matour='$matour',
       tentour='$tentour',
       ngaybd='$ngaybd',
       ngaykt='$ngaykt',
       giatour='$giatour',
       khachsan='$khachsan',
       mota='$mota',
       tinhtrang='$tinhtrang' 
       ";

       $res=mysqli_query($conn, $sql);

       if($res == true)
       {
        foreach ($place as $key => $value) {
                        $sqldd="INSERT INTO tour_diemden SET
                        matour='$matour',
                        madiemden='$value' 
                        ";
                        $resdd=mysqli_query($conn,$sqldd);
                    }
        foreach ($phuongtien as $key => $value) {
                        $sqlpt="INSERT INTO tour_phuongtien SET
                        matour='$matour',
                        maphuongtien='$value' 
                        ";
                        $respt=mysqli_query($conn,$sqlpt);
                    }
       }

       
       
       
       if ($res == true) {
        $_SESSION['add'] = "<div class='success'>Thêm tour thành công!</div>";
        header('location:'.SITEURL.'admin/tour.php');
        }
        else{
        $_SESSION['add'] = "<div class='error'>Thêm tour thất bại!</div>";
        header("location:".SITEURL.'admin/addtour.php');
    }
   }
?>
           
        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
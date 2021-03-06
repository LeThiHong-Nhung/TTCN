<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['updatetour'])) {
            echo $_SESSION['updatetour']; //hien thi thong bao
            unset($_SESSION['updatetour']); //xoa bo thong bao
        }
?>
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

                //lay du lieu lien quan den phuong tien va diem den
                $sqlp="SELECT b.maphuongtien,b.tenphuongtien
                FROM tour_phuongtien a join phuongtien b on a.maphuongtien=b.maphuongtien
                WHERE a.matour='$matour' ";
                $resp=mysqli_query($conn,$sqlp);
                $rowp=mysqli_fetch_assoc($resp);
                $ptht=$rowp['maphuongtien'];//ds ma phuong tien hien tai
                $tptht=$rowp['tenphuongtien'];//ds ten phuong tien hien tai

                $sqld="SELECT b.madiemden,b.tendiemden
                FROM tour_diemden a join diemden b on a.madiemden=b.madiemden
                WHERE a.matour='$matour' ";
                $resd=mysqli_query($conn,$sqld);
                $rowd=mysqli_fetch_assoc($resd);
                $ddht=$rowd['madiemden'];//ds ma diem den hien tai
                $tddht=$rowd['tendiemden'];//ds ten diem den hien tai
            }
            else
            {
                $_SESSION['no-tour-found'] = "<div class='error'>Kh??ng t??m th???y tour</div>";
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
                        <h2>Ch???nh s???a th??ng tin tour</h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <tr>
                    <td>M?? tour</td>
                    <td><input type="text" readonly name="matour" value="<?php if(isset($matour)) echo $matour; ?>"></td>
                    <td>Ng??y b???t ?????u</td>
                    <td><input type="date" name="ngaybd" value="<?php if(isset($ngaybd)) echo $ngaybd; ?>"></td>
                    <td>Ng??y k???t th??c</td>
                    <td><input type="date" name="ngaykt" value="<?php if(isset($ngaykt)) echo $ngaykt; ?>"></td>
                </tr>
                <tr>
                    <td>T??n tour</td>
                    <td><textarea name="tentour" rows="2" cols="20"><?php if(isset($tentour)) echo $tentour; ?></textarea></td>
                    <td>Gi?? tour</td>
                    <td><input type="number" name="giatour" value="<?php if(isset($giatour)) echo $giatour; ?>"></td>
                    <td>Kh??ch s???n</td>
                    <td><textarea name="khachsan" rows="2" cols="20"><?php if(isset($khachsan)) echo $khachsan; ?></textarea></td>
                </tr>
                <tr>
                    <td>M?? t???</td>
                    <td><textarea name="mota" rows="2" cols="20"><?php if(isset($mota)) echo $mota; ?></textarea></td>
                    <td>T??nh tr???ng</td>
                    <td><input type="radio" <?php if($tinhtrang=='yes') echo "checked"; ?> name="tinhtrang" value="yes">M??? <input type="radio" <?php if($tinhtrang=='no') echo "checked"; ?> name="tinhtrang" value="no">????ng</td>
                </tr>
                <tr>
                    <td>Ph????ng ti???n</td>
                    <td><input type="text" readonly name="ptht" value="<?php echo $tptht; ?>"></td>
                    <td>C???p nh???t</td>
                    <td>
                            <div>
                            <input type="text" name="phuongtien" list="phuongtien" multiple="multiple" style="width: 100%;" value="<?php if(isset($phuongtien)) echo implode(",",$phuongtien); ?>" />

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
                        <td>??i???m ?????n</td>
                        <td><input type="text" readonly name="ddht" value="<?php echo $tddht; ?>"></td>
                        <td>C???p nh???t</td>
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
                    <tr>
                    <td><input type="hidden" name="matour" value="<?php echo $matour; ?>"></td>
                    </tr>
            </table>
            <input type="submit" name="submit" value="X??c nh???n"><br><br>
            <a href="javascript:window.history.back(-1);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Tr??? l???i trang tr?????c"></a>

<?php
   if(isset($_POST['submit']))
   {
       //$matour=mysqli_real_escape_string($conn,$_POST['matour']);
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
       $ddcc=$place;//ds diem den cuoi cung
       $ptcc=$phuongtien;//ds phuong tien cuoi cung

       if($place=="")
       {
            $ddcc=$ddht;
       }
       if($phuongtien=="")
       {
           $ptcc=$ptht;
       }

       $sql="UPDATE danhsachtour SET
       tentour='$tentour',
       ngaybd='$ngaybd',
       ngaykt='$ngaykt',
       giatour='$giatour',
       khachsan='$khachsan',
       mota='$mota',
       tinhtrang='$tinhtrang' 
       WHERE matour='$matour' 
       ";

       $res=mysqli_query($conn, $sql);

       if($res == true)
       {
        //xoa cac ban ghi cu, ghi lai cac ban ghi moi
        $sqlx="DELETE FROM tour_diemden WHERE matour='$matour' ";
        $resx=mysqli_query($conn,$sqlx);

        $sqls="DELETE FROM tour_phuongtien WHERE matour='$matour' ";
        $ress=mysqli_query($conn,$sqls);

        foreach ($ddcc as $key => $value) {
                        $sqldd="INSERT INTO tour_diemden SET
                        madiemden='$value',
                        matour='$matour' 
                        ";
                        $resdd=mysqli_query($conn,$sqldd);
                    }
        foreach ($ptcc as $key => $value) {
                        $sqlpt="INSERT INTO tour_phuongtien SET
                        maphuongtien='$value',
                        matour='$matour' 
                        ";
                        $respt=mysqli_query($conn,$sqlpt);
                    }
       }

       
       
       
       if ($res == true) {
        $_SESSION['updatetour'] = "<div class='success'>Ch???nh s???a tour th??nh c??ng!</div>";
        header('location:'.SITEURL.'admin/tour.php');
        }
        else{
        $_SESSION['updatetour'] = "<div class='error'>Ch???nh s???a tour tour th???t b???i!</div>";
        header("location:".SITEURL.'admin/updatetour.php');
    }
   }
?>
           
        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
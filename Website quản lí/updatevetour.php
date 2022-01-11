<?php ob_start();
include('partials/menu.php'); ?>
<?php
if (isset($_SESSION['updatevetour'])) {
    echo $_SESSION['updatevetour']; //hien thi thong bao
    unset($_SESSION['updatevetour']); //xoa bo thong bao
}
if(isset($_GET['sove']))
{
    $sove=$_GET['sove'];
}
else{
    header('location:'.SITEURL.'ve.php');
}
?>
<div class="container-xl">
    <form class="table table-striped table-hover" action="" method="POST">
        <?php
        $sqlvt="SELECT * from vetour WHERE sove='$sove' ";
        $resvt=mysqli_query($conn,$sqlvt);
        $rowvt=mysqli_fetch_assoc($resvt);
        $matour=$rowvt['matour'];
        $makhachhang=$rowvt['makhachhang'];
        $sohd=$rowvt['sohd'];
        $manv=$rowvt['manv'];
        $sqlmt="SELECT group_concat(tentour) as tentour from danhsachtour WHERE matour='$matour' ";
        $resmt=mysqli_query($conn,$sqlmt);
        $rowmt=mysqli_fetch_assoc($resmt);
        $tentour=$rowmt['tentour'];
        ?>
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>Chỉnh sửa vé tour</h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>Số vé</td>
                        <td><input type="text" readonly name="sove" value="<?php echo $sove; ?>"></td>
                        <td>Khách hàng</td>
                        <td><input type="text" name="makhachhang" value="<?php if (isset($makhachhang)) echo $makhachhang; ?>" ></td>
                        
                    </tr>
                    <tr>
                        <td>Chọn tour</td>

                        <td>
                            <div>
                                <input type="text" name="matour" list="tour" size="20" />

                                <datalist id="tour">
                                    <?php
                                    $sql2 = "SELECT * FROM danhsachtour";
                                    $res2 = mysqli_query($conn, $sql2);
                                    while ($row2 = mysqli_fetch_assoc($res2)) {
                                        $matour2 = $row2['matour'];
                                        $tentour = $row2['tentour'];
                                        echo "<option value='$matour2' >";
                                        echo $tentour;
                                        echo "</option>";
                                    }
                                    ?>
                                </datalist>
                            </div>
                        </td>
                        <td colspan="2"><input type="text" size="50" readonly value="<?php echo $tentour; ?>"></td>
                    </tr>
                    <tr>
                        
                        <td>Nhân viên</td>
                        <td><input type="text" readonly name="manv" value="<?php if (isset($manv)) echo $manv; ?>"></td>
                        <td>Số hợp đồng</td>
                        <td><input type="text" name="sohd" value="<?php if (isset($sohd)) echo $sohd; ?>"></td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Chỉnh sửa">
                <?php
                if (isset($_POST['submit'])) {
                    $matour = mysqli_real_escape_string($conn, $_POST['matour']);
                    $makhachhang = mysqli_real_escape_string($conn, $_POST['makhachhang']);
                    $sohd = mysqli_real_escape_string($conn, $_POST['sohd']);

                    $sql="UPDATE vetour SET
                    matour='$matour',
                    makhachhang='$makhachhang',
                    manv='$manv',
                    sohd='$sohd' 
                    ";

                    $res = mysqli_query($conn, $sql);

                    if ($res == true) {
                        $_SESSION['updatevetour'] = "<div class='success'>Chỉnh sửa vé tour thành công!</div>";
                        header('location:'.SITEURL.'vetour.php');
                    } else {
                        $_SESSION['updatevetour'] = "<div class='error'>Chỉnh sửa vé tour thất bại!</div>";
                        header("location:".SITEURL.'vetour.php');
                    }
                }
                ?>

            </div>
        </div>
    </form>
</div>
<?php include('partials/footer.php');
ob_end_flush(); ?>
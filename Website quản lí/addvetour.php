<?php ob_start();
include('partials/menu.php'); ?>
<?php
if (isset($_SESSION['addvetour'])) {
    echo $_SESSION['addvetour']; //hien thi thong bao
    unset($_SESSION['addvetour']); //xoa bo thong bao
}
if (isset($_SESSION['user'])) {
    //lay id va dl
    $email = $_SESSION['user'];
    //lay dl
    $sql = "SELECT * FROM nhanvien WHERE email='$email' ";
    //thuc thi cau truy van
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if ($count == 1) {
        //lay dl
        $row = mysqli_fetch_assoc($res);
        $manv = $row['manv'];
    }
}
?>
<div class="container-xl">
    <form class="table table-striped table-hover" action="" method="POST">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>Tạo vé tour</h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>Chọn tour</td>
                        <td>
                            <div>
                                <input type="text" name="matour" list="tour" style="width: 100%;" />

                                <datalist id="tour">
                                    <?php
                                    $sql2 = "SELECT * FROM danhsachtour";
                                    $res2 = mysqli_query($conn, $sql2);
                                    while ($row2 = mysqli_fetch_assoc($res2)) {
                                        $matour = $row2['matour'];
                                        $tentour = $row2['tentour'];
                                        echo "<option value='$matour'>";
                                        echo $tentour;
                                        echo "</option>";
                                    }
                                    ?>
                                </datalist>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Khách hàng</td>
                        <td><input type="text" name="makhachhang" <?php if (isset($makhachhang)) echo $makhachhang; ?>></td>
                        <td>Nhân viên</td>
                        <td><input type="text" readonly name="manv" value="<?php if (isset($manv)) echo $manv; ?>"></td>
                    </tr>
                    <tr>
                        <td>Số hợp đồng</td>
                        <td><input type="text" name="sohd" value="<?php if (isset($sohd)) echo $sohd; ?>"></td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Thêm mới">
                <?php
                if (isset($_POST['submit'])) {
                    $matour = mysqli_real_escape_string($conn, $_POST['matour']);
                    $makhachhang = mysqli_real_escape_string($conn, $_POST['makhachhang']);
                    $sohd = mysqli_real_escape_string($conn, $_POST['sohd']);

                    $sql="INSERT INTO vetour SET
                    matour='$matour',
                    makhachhang='$makhachhang',
                    manv='$manv',
                    sohd='$sohd' 
                    ";

                    $res = mysqli_query($conn, $sql);

                    if ($res == true) {
                        $_SESSION['addvetour'] = "<div class='success'>Tạo vé tour thành công!</div>";
                        header('location:'.SITEURL.'vetour.php');
                    } else {
                        $_SESSION['addvetour'] = "<div class='error'>Tạo vé tour thất bại!</div>";
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
<?php ob_start();
include('partials/menu.php'); ?>
<?php
if (isset($_SESSION['addvetour'])) {
    echo $_SESSION['addvetour']; //hien thi thong bao
    unset($_SESSION['addvetour']); //xoa bo thong bao
}
if (isset($_SESSION['updatevetour'])) {
    echo $_SESSION['updatevetour']; //hien thi thong bao
    unset($_SESSION['updatevetour']); //xoa bo thong bao
}
?>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5" style="position:relative;z-index:1;">
                        <h2><b>Quản lí vé tour</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="<?php echo SITEURL; ?>phieudangki.php" class="btn btn-secondary" name="addplace"><i class="material-icons">&#xE147;</i> <span>Xem phiếu đăng kí</span></a>
                        <a href="<?php echo SITEURL; ?>addvetour.php" class="btn btn-secondary" name="addplace"><i class="material-icons">&#xE147;</i> <span>Thêm vé tour</span></a>
                        <a href="<?php echo SITEURL; ?>export-vetour.php" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Xuất Excel</span></a>
                    </div>
                </div>
            </div>
            <form action="" method="POST">
                Tìm kiếm vé tour <input type="text" name="search" value="<?php if (isset($search)) echo $search; ?>">
                <input type="submit" name="tim" value="Tìm">
            </form><br>
            <table class="table table-striped table-hover">
                <tr>
                    <th>Số vé</th>
                    <th>Tên tour</th>
                    <th>Tên khách hàng</th>
                    <th>Nhân viên lập</th>
                    <th>Số hợp đồng</th>
                    <th>Hành động</th>
                </tr>
                <?php
                //phan trang
                $rowsPerPage = 4;
                if (!isset($_GET['page'])) {
                    $_GET['page'] = 1;
                }
                $_GET['page']=(int)$_GET['page'];
                $offset = ($_GET['page'] - 1) * $rowsPerPage;

                //dem tong so dong
                $s = "SELECT * from vetour";
                $r = mysqli_query($conn, $s);
                $c = mysqli_num_rows($r);

                //tao bien dem
                if (isset($_POST['tim'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT * FROM vetour WHERE sove LIKE '%$search%' OR matour LIKE '%$search%' OR makhachhang LIKE '%$search%' OR manv LIKE '%$search%' LIMIT $offset, $rowsPerPage ";
                    $res = mysqli_query($conn, $sql);
                    //
                } else {
                    $sql = "SELECT * from vetour LIMIT $offset, $rowsPerPage";
                    //thuc thi cau truy van
                    $res = mysqli_query($conn, $sql);
                }
                //kiem tra ket qua cau truy van
                if ($res == true) {
                    //dem so ban ghi
                    $count = mysqli_num_rows($res); //lay het cac dong
                    $maxPage = ceil($count / $rowsPerPage);
                    if ($count > 0) { //co du lieu

                        //lay tung hang
                        while ($rows = mysqli_fetch_assoc($res)) {
                            $sove = $rows['sove'];
                            $matour = $rows['matour'];
                            $makhachhang = $rows['makhachhang'];
                            $manv = $rows['manv'];
                            $sohd = $rows['sohd'];
                            $sqlkh = "SELECT tenkh from khachhang WHERE cmnd='$makhachhang' ";
                            $reskh = mysqli_query($conn, $sqlkh);
                            $rowkh = mysqli_fetch_assoc($reskh);
                            $tenkh = $rowkh['tenkh'];

                            $sqlnv = "SELECT hoten from nhanvien WHERE manv='$manv' ";
                            $resnv = mysqli_query($conn, $sqlnv);
                            $rownv = mysqli_fetch_assoc($resnv);
                            $tennv = $rownv['hoten'];

                            $sqltour = "SELECT tentour from danhsachtour WHERE matour='$matour' ";
                            $restour = mysqli_query($conn, $sqltour);
                            $rowtour = mysqli_fetch_assoc($restour);
                            $tentour = $rowtour['tentour'];

                            //hien thi du lieu
                ?>

                            <tr>
                                <td><?php echo $sove; ?> </td>
                                <td><?php echo $tentour; ?></td>
                                <td><?php echo $tenkh; ?></td>
                                <td><?php echo $tennv; ?></td>
                                <td><?php echo $sohd; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>updatevetour.php?sove=<?php echo $sove; ?>" class="edit" title="Chỉnh sửa vé tour" data-toggle="tooltip"><i class="material-icons">edit</i></a>
                                </td>
                            </tr>

                <?php


                        }
                    }
                }
                ?>


            </table>
            <div class="clearfix"></div>
            <div class="hint-text">Xem <b><?php echo $rowsPerPage; ?></b> trên tổng số <b><?php echo $c; ?></b> vé tour</div>
            <ul class="pagination">
                <?php
                $re = mysqli_query($conn, 'select * from vetour');
                $numRows = mysqli_num_rows($re);
                $maxPage = floor($numRows / $rowsPerPage) + 1;
                if ($_GET['page'] > 1) {
                    echo "<li class='page-item'><a href=" . $_SERVER['PHP_SELF'] . "?page=" . (1) . "> Về trang đầu </a></li>";
                    echo "<li class='page-item'><a href=" . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] - 1) . "> Trang trước </a></li>";
                }
                for ($i = 1; $i <= $maxPage; $i++) {
                    if ($i == $_GET['page']) {
                        echo "<li class='page-item active'><a href='#' class='page-link'>" . $i . "</a></li>";
                    } else echo "<li class='page-item active'><a href=" . $_SERVER['PHP_SELF'] . "?page=" . $i . "class='page-link'>" . $i . "</a></li>";
                }
                if ($_GET['page'] < $maxPage) {
                    echo "<li class='page-item'><a href=" . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] + 1) . "> Tiếp theo </a></li>";
                    echo "<li class='page-item'><a href=" . $_SERVER['PHP_SELF'] . "?page=" . ($maxPage) . ">Tới trang cuối</a></li>";
                }
                ?>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>
<?php include('partials/footer.php');
ob_end_flush(); ?>
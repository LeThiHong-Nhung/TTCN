<?php ob_start();
include('partials/menu.php'); ?>
<?php
    if (!function_exists('currency_format')) {
        function currency_format($number, $suffix = 'VNĐ')
        {
            if (!empty($number)) {
                return number_format($number, 0, ',', '.') . "{$suffix}";
            }
        }
    }
    ?>
<!-- echo session here -->
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5" style="position:relative;z-index:1;">
                        <h2><b>Trang quản trị EJM - Nhân viên</b></h2>
                    </div>
                </div>
            </div>
            <div class="col-4 text-center">
                <?php
                $sql = "SELECT * FROM danhsachtour";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                ?>
                <h1><?php echo $count; ?></h1>
                <br />
                Tổng số tour<br><br>
            </div>

            <div class="col-4 text-center">
                <?php
                $sql = "SELECT * FROM diemden";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                ?>
                <h1><?php echo $count; ?></h1>
                <br />
                Điểm đến<br><br>
            </div>

            <div class="col-4 text-center">
                <?php
                $sql = "SELECT * FROM khachhang";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                ?>
                <h1><?php echo $count; ?></h1>
                <br />
                Khách hàng<br><br>
            </div>

            <div class="col-4 text-center">
                <?php
                $sql = "SELECT * FROM nhanvien";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                ?>
                <h1><?php echo $count; ?></h1>
                <br />
                Nhân viên<br><br>
            </div>

            <div class="col-4 text-center">
                <?php
                $sql = "SELECT * FROM phieudangki";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                ?>
                <h1><?php echo $count; ?></h1>
                <br />
                Lượt đăng kí<br><br>
            </div>
            <div align="center" class="col3 text-center">
                <?php
                $sql = "SELECT SUM(b.giatour*a.soluong) as doanhthu FROM phieudangki a join danhsachtour b on a.matour=b.matour";
                $res = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($res);
                $count=$row['doanhthu'];
                ?>
                <h1><?php echo currency_format($count); ?></h1>
                <br />
                Tổng doanh thu<br><br>
            </div>
            <div align="center" class="col3 text-center">
                <?php
                $nam=date("Y");
                $sql = "SELECT SUM(b.giatour*a.soluong) as doanhthu FROM phieudangki a join danhsachtour b on a.matour=b.matour WHERE YEAR(a.thoigiandk)='$nam' ";
                $res = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($res);
                $count=$row['doanhthu'];
                ?>
                <h1><?php echo currency_format($count); ?></h1>
                <br />
                Tổng doanh thu năm <?php echo date("Y"); ?><br><br>
            </div>
            <div class="col3 text-center">
                <h5>Lượt đăng kí tour trong năm <?php echo date("Y"); ?></h5>
                <?php error_reporting(E_ERROR | E_PARSE); include('data-chart.php'); ?>
            </div>
            <div class="col3 text-center">
                <h5>Các tour được yêu thích</h5>
                <?php error_reporting(E_ERROR | E_PARSE); include('chart_yeuthich.php'); ?>
            </div>
            <div class="col2 text-center">
                <h5>Doanh thu trong năm nay - <?php echo date("Y"); ?></h5>
                <?php error_reporting(E_ERROR | E_PARSE); include('chart_doanhthu.php'); ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div><br><br>
<?php include('partials/footer.php');
ob_end_flush(); ?>
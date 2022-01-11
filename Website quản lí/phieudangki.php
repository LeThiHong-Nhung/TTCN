<?php ob_start(); include('partials/menu.php'); ?>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5" style="position:relative;z-index:1;">
                        <h2><b>Phiếu đăng kí</b></h2>
                    </div>
                </div>
            </div>
            <form action="" method="POST">
                Tìm kiếm phiếu đăng kí <input type="text" name="search" value="<?php if(isset($search)) echo $search; ?>">
                <input type="submit" name="tim" value="Tìm">
            </form><br>
            <table class="table table-striped table-hover">
                <tr>
                    <th>Mã phiếu</th>
                    <th>Tên tour</th>
                    <th>Tên khách hàng</th>
                    <th>Số lượng</th>
                    <th>Thời gian đăng kí</th>
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
                $s = "SELECT * from phieudangki";
                $r = mysqli_query($conn, $s);
                $c = mysqli_num_rows($r);

                //tao bien dem
                if (isset($_POST['tim'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT * FROM phieudangki WHERE maphieu LIKE '%$search%' OR matour LIKE '%$search%' OR makhachhang LIKE '%$search%' LIMIT $offset, $rowsPerPage ";
                    $res = mysqli_query($conn, $sql);
                    //
                } else {
                    $sql = "SELECT * from phieudangki LIMIT $offset, $rowsPerPage";
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
                            $maphieu = $rows['maphieu'];
                            $matour = $rows['matour'];
                            $makhachhang = $rows['makhachhang'];
                            $soluong = $rows['soluong'];
                            $thoigiandk=$rows['thoigiandk'];
                            $sqlkh="SELECT tenkh from khachhang WHERE cmnd='$makhachhang' ";
                            $reskh=mysqli_query($conn,$sqlkh);
                            $rowkh=mysqli_fetch_assoc($reskh);
                            $tenkh=$rowkh['tenkh'];

                            $sqltour="SELECT tentour from danhsachtour WHERE matour='$matour' ";
                            $restour=mysqli_query($conn,$sqltour);
                            $rowtour=mysqli_fetch_assoc($restour);
                            $tentour=$rowtour['tentour'];

                            //hien thi du lieu
                ?>

                            <tr>
                                <td><?php echo $maphieu; ?> </td>
                                <td><?php echo $tentour; ?></td>
                                <td><?php echo $tenkh; ?></td>
                                <td><?php echo $soluong; ?></td>
                                <td><?php echo $thoigiandk; ?></td>
                            </tr>

                <?php


                        }
                    }
                }
                ?>


            </table>
            <div class="clearfix"></div>
            <div class="hint-text">Xem <b><?php echo $rowsPerPage; ?></b> trên tổng số <b><?php echo $c; ?></b> phiếu đăng kí</div>
            <ul class="pagination">
            <?php
                $re = mysqli_query($conn, 'select * from phieudangki');
                $numRows = mysqli_num_rows($re);
                $maxPage = floor($numRows / $rowsPerPage) + 1;
                if ($_GET['page'] > 1) {
                    echo "<li class='page-item'><a href=".$_SERVER['PHP_SELF']."?page=".(1)."> Về trang đầu </a></li>";
                    echo "<li class='page-item'><a href=".$_SERVER['PHP_SELF']."?page=".($_GET['page']-1)."> Trang trước </a></li>";
                }
                for ($i = 1; $i <= $maxPage; $i++) {
                    if ($i == $_GET['page']) {
                        echo "<li class='page-item active'><a href='#' class='page-link'>".$i."</a></li>";
                    }
                    else echo "<li class='page-item active'><a href=".$_SERVER['PHP_SELF']."?page=".$i."class='page-link'>".$i."</a></li>";
                }
                if ($_GET['page'] < $maxPage) {
                    echo "<li class='page-item'><a href=".$_SERVER['PHP_SELF']."?page=".($_GET['page']+1)."> Tiếp theo </a></li>";
                    echo "<li class='page-item'><a href=".$_SERVER['PHP_SELF']."?page=".($maxPage).">Tới trang cuối</a></li>";
                }
            ?>
            </ul>

            <div class="clearfix"></div>
            <a href="javascript:window.history.back(-1);"><img src="<?php echo SITEURL; ?>images/back.png" width="40px" title="Trở lại trang trước"></a>
        </div>
    </div>
</div>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
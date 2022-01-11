<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; //hien thi thong bao
            unset($_SESSION['add']); //xoa bo thong bao
        }
        if (isset($_SESSION['updatetour'])) {
            echo $_SESSION['updatetour']; //hien thi thong bao
            unset($_SESSION['updatetour']); //xoa bo thong bao
        }    
        if (isset($_SESSION['deletetour'])) {
            echo $_SESSION['deletetour']; //hien thi thong bao
            unset($_SESSION['deletetour']); //xoa bo thong bao
        }
        if (isset($_SESSION['no-tour-found'])) {
            echo $_SESSION['no-tour-found']; //hien thi thong bao
            unset($_SESSION['no-tour-found']); //xoa bo thong bao
        }
        if (isset($_SESSION['deletetour'])) {
            echo $_SESSION['deletetour']; //hien thi thong bao
            unset($_SESSION['deletetour']); //xoa bo thong bao
        }
?>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5" style="position:relative;z-index:1;">
                        <h2><b>Quản lí tour</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="<?php echo SITEURL; ?>admin/addtour.php" class="btn btn-secondary" name="addtour"><i class="material-icons">&#xE147;</i> <span>Thêm tour</span></a>
                        <a href="<?php echo SITEURL; ?>admin/export-tour.php" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Xuất Excel</span></a>
                    </div>
                </div>
            </div>
            <form action="" method="POST">
                Tìm kiếm tour <input type="text" name="search" value="<?php if(isset($search)) echo $search; ?>">
                <input type="submit" name="tim" value="Tìm">
            </form><br>
            <table class="table table-striped table-hover">
                <tr>
                    <th>Mã tour</th>
                    <th>Tên tour</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Giá tour</th>
                    <th>Tình trạng</th>
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
                $s = "SELECT * from danhsachtour";
                $r = mysqli_query($conn, $s);
                $c = mysqli_num_rows($r);

                //tao bien dem
                if (isset($_POST['tim'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT * FROM danhsachtour WHERE matour LIKE '%$search%' OR tentour LIKE '%$search%' OR mota LIKE '%$search%' OR giatour LIKE '%$search%' LIMIT $offset, $rowsPerPage ";
                    $res = mysqli_query($conn, $sql);
                    //
                } else {
                    $sql = "SELECT * from danhsachtour LIMIT $offset, $rowsPerPage";
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
                            $matour = $rows['matour'];
                            $tentour = $rows['tentour'];
                            $ngaybd = $rows['ngaybd'];
                            $ngaykt = $rows['ngaykt'];
                            $giatour = $rows['giatour'];
                            $khachsan = $rows['khachsan'];
                            $mota = $rows['mota'];
                            $tinhtrang = $rows['tinhtrang'];

                            //hien thi du lieu
                ?>

                            <tr>
                                <td><?php echo $matour; ?> </td>
                                <td><?php echo $tentour; ?></td>
                                <td><?php echo $ngaybd; ?></td>
                                <td><?php echo $ngaykt; ?></td>
                                <td><?php echo $giatour; ?></td>
                                <td><?php if($tinhtrang=='no') echo "Đóng"; else echo "Mở"; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/updatetour.php?matour=<?php echo $matour; ?>" class="edit" title="Chỉnh sửa thông tin tour" data-toggle="tooltip"><i class="material-icons">edit</i></a>
                                    <a href="<?php echo SITEURL; ?>admin/deletetour.php?matour=<?php echo $matour; ?>" class="delete" title="Xoá tour" data-toggle="tooltip"><i class="material-icons">delete</i></a>
                                    <a href="<?php echo SITEURL; ?>admin/detailtour.php?matour=<?php echo $matour; ?>" class="info" title="Thông tin chi tiết" data-toggle="tooltip"><i class="material-icons">info</i></a>
                                </td>
                            </tr>

                <?php


                        }
                    }
                }
                ?>


            </table>
            <div class="clearfix"></div>
            <div class="hint-text">Xem <b><?php echo $rowsPerPage; ?></b> trên tổng số <b><?php echo $c; ?></b> tour</div>
            <ul class="pagination">
            <?php
                $re = mysqli_query($conn, 'select * from danhsachtour');
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
        </div>
    </div>
</div>
</div>
<?php include('partials/footer.php'); ob_end_flush(); ?>
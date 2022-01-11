<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['addnv'])) {
            echo $_SESSION['addnv']; //hien thi thong bao
            unset($_SESSION['addnv']); //xoa bo thong bao
        }
        if (isset($_SESSION['updatenv'])) {
            echo $_SESSION['updatenv']; //hien thi thong bao
            unset($_SESSION['updatenv']); //xoa bo thong bao
        }
        if (isset($_SESSION['deletenv'])) {
            echo $_SESSION['deletenv']; //hien thi thong bao
            unset($_SESSION['deletenv']); //xoa bo thong bao
        }
        if (isset($_SESSION['no-nv-found'])) {
            echo $_SESSION['no-nv-found']; //hien thi thong bao
            unset($_SESSION['no-nv-found']); //xoa bo thong bao
        }
?>
<!-- echo session here -->
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5" style="position:relative;z-index:1;">
                        <h2><b>Quản lí nhân viên</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="<?php echo SITEURL; ?>admin/addnv.php" class="btn btn-secondary" name="addpt"><i class="material-icons">&#xE147;</i> <span>Thêm nhân viên</span></a>
                        <a href="<?php echo SITEURL; ?>admin/export-nv.php" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Xuất Excel</span></a>
                    </div>
                </div>
            </div>
            <form action="" method="POST">
                Tìm kiếm nhân viên <input type="text" name="search" value="<?php if(isset($search)) echo $search; ?>">
                <input type="submit" name="tim" value="Tìm">
            </form><br>
            <table class="table table-striped table-hover">
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Họ tên</th>
                    <th>Trình độ</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
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
                $s = "SELECT * from nhanvien";
                $r = mysqli_query($conn, $s);
                $c = mysqli_num_rows($r);

                //tao bien dem
                if (isset($_POST['tim'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT * FROM nhanvien WHERE manv LIKE '%$search%' OR hoten LIKE '%$search%' OR sdt LIKE '%$search%' OR email LIKE '%$search%' LIMIT $offset, $rowsPerPage ";
                    $res = mysqli_query($conn, $sql);
                    //
                } else {
                    $sql = "SELECT * from nhanvien LIMIT $offset, $rowsPerPage";
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
                            $manhanvien = $rows['manv'];
                            $hoten = $rows['hoten'];
                            $trinhdo = $rows['trinhdo'];
                            $gioitinh=$rows['gioitinh'];
                            $ngaysinh=$rows['ngaysinh'];

                            //hien thi du lieu
                ?>

                            <tr>
                                <td><?php echo $manhanvien; ?> </td>
                                <td><?php echo $hoten; ?> </td>
                                <td><?php echo $trinhdo; ?></td>
                                <td><?php echo $gioitinh; ?></td>
                                <td><?php echo $ngaysinh; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/updatenv.php?manv=<?php echo $manhanvien; ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>
                                    <a href="<?php echo SITEURL; ?>admin/deletenv.php?manv=<?php echo $manhanvien; ?>" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">delete</i></a>
                                    <a href="<?php echo SITEURL; ?>admin/detailnv.php?manv=<?php echo $manhanvien; ?>" class="info" title="Info" data-toggle="tooltip"><i class="material-icons">info</i></a>

                                </td>
                            </tr>

                <?php

                        }
                    }
                }
                ?>


            </table>
            <div class="clearfix"></div>
            <div class="hint-text">Xem <b><?php echo $rowsPerPage; ?></b> trên tổng số <b><?php echo $c; ?></b> nhân viên</div>
            <ul class="pagination">
            <?php
                $re = mysqli_query($conn, 'select * from nhanvien');
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
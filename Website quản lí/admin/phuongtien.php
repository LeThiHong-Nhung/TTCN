<?php ob_start(); include('partials/menu.php'); ?>
<?php if (isset($_SESSION['addpt'])) {
            echo $_SESSION['addpt']; //hien thi thong bao
            unset($_SESSION['addpt']); //xoa bo thong bao
        }
        if (isset($_SESSION['updatept'])) {
            echo $_SESSION['updatept']; //hien thi thong bao
            unset($_SESSION['updatept']); //xoa bo thong bao
        }
        if (isset($_SESSION['deletept'])) {
            echo $_SESSION['deletept']; //hien thi thong bao
            unset($_SESSION['deletept']); //xoa bo thong bao
        }
        if (isset($_SESSION['no-pt-found'])) {
            echo $_SESSION['no-pt-found']; //hien thi thong bao
            unset($_SESSION['no-pt-found']); //xoa bo thong bao
        }
?>
<!-- echo session here -->
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5" style="position:relative;z-index:1;">
                        <h2><b>Quản lí phương tiện</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="<?php echo SITEURL; ?>admin/addpt.php" class="btn btn-secondary" name="addpt"><i class="material-icons">&#xE147;</i> <span>Thêm phương tiện</span></a>
                        <a href="<?php echo SITEURL; ?>admin/export-pt.php" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Xuất Excel</span></a>
                    </div>
                </div>
            </div>
            <form action="" method="POST">
                Tìm kiếm phương tiện <input type="text" name="search" value="<?php if(isset($search)) echo $search; ?>">
                <input type="submit" name="tim" value="Tìm">
            </form><br>
            <table class="table table-striped table-hover">
                <tr>
                    <th>Mã phương tiện</th>
                    <th>Tên phương tiện</th>
                    <th>Mô tả</th>
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
                $s = "SELECT * from phuongtien";
                $r = mysqli_query($conn, $s);
                $c = mysqli_num_rows($r);

                //tao bien dem
                if (isset($_POST['tim'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT * FROM phuongtien WHERE maphuongtien LIKE '%$search%' OR tenphuongtien LIKE '%$search%' OR mota LIKE '%$search%' LIMIT $offset, $rowsPerPage ";
                    $res = mysqli_query($conn, $sql);
                    //
                } else {
                    $sql = "SELECT * from phuongtien LIMIT $offset, $rowsPerPage";
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
                            $maphuongtien = $rows['maphuongtien'];
                            $tenphuongtien = $rows['tenphuongtien'];
                            $mota = $rows['mota'];

                            //hien thi du lieu
                ?>

                            <tr>
                                <td><?php echo $maphuongtien; ?> </td>
                                <td><?php echo $tenphuongtien; ?> </td>
                                <td><?php echo $mota; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/updatept.php?maphuongtien=<?php echo $maphuongtien; ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>
                                    <a href="<?php echo SITEURL; ?>admin/deletept.php?maphuongtien=<?php echo $maphuongtien; ?>" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">delete</i></a>
                                </td>
                            </tr>

                <?php

                        }
                    }
                }
                ?>


            </table>
            <div class="clearfix"></div>
            <div class="hint-text">Xem <b><?php echo $rowsPerPage; ?></b> trên tổng số <b><?php echo $c; ?></b> phương tiện</div>
            <ul class="pagination">
            <?php
                $re = mysqli_query($conn, 'select * from phuongtien');
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
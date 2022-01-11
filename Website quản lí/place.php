<?php ob_start(); include('partials/menu.php'); ?>
<?php
    if (isset($_SESSION['updateplace'])) {
            echo $_SESSION['updateplace']; //hien thi thong bao
            unset($_SESSION['updateplace']); //xoa bo thong bao
        }
    if (isset($_SESSION['no-place-found'])) {
            echo $_SESSION['no-place-found']; //hien thi thong bao
            unset($_SESSION['no-place-found']); //xoa bo thong bao
        }
    if (isset($_SESSION['upload-place'])) {
            echo $_SESSION['upload-place']; //hien thi thong bao
            unset($_SESSION['upload-place']); //xoa bo thong bao
        }
    if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove']; //hien thi thong bao
            unset($_SESSION['failed-remove']); //xoa bo thong bao
        }
?>
<!-- echo session here -->
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5" style="position:relative;z-index:1;">
                        <h2><b>Cập nhật điểm đến</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="<?php echo SITEURL; ?>export-place.php" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Xuất Excel</span></a>
                    </div>
                </div>
            </div>
            <form action="" method="POST">
                Tìm kiếm điểm đến <input type="text" name="search" value="<?php if(isset($search)) echo $search; ?>">
                <input type="submit" name="tim" value="Tìm">
            </form><br>
            <table class="table table-striped table-hover">
                <tr>
                    <th>Mã điểm đến</th>
                    <th>Tên điểm đến</th>
                    <th>Hình ảnh</th>
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
                $s = "SELECT * from diemden";
                $r = mysqli_query($conn, $s);
                $c = mysqli_num_rows($r);

                //tao bien dem
                if (isset($_POST['tim'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT * FROM diemden WHERE madiemden LIKE '%$search%' OR tendiemden LIKE '%$search%' OR mota LIKE '%$search%' LIMIT $offset, $rowsPerPage ";
                    $res = mysqli_query($conn, $sql);
                    //
                } else {
                    $sql = "SELECT * from diemden LIMIT $offset, $rowsPerPage";
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
                            $madiemden = $rows['madiemden'];
                            $tendiemden = $rows['tendiemden'];
                            $mota = $rows['mota'];
                            $tenanh = $rows['hinhanh'];

                            //hien thi du lieu
                ?>

                            <tr>
                                <td><?php echo $madiemden; ?> </td>
                                <td><?php echo $tendiemden; ?></td>
                                <td>
                                <?php
                                //kiem tra co anh hay khong
                                if ($tenanh != "") {
                                    //hien thi anh
                                ?>

                                    <img src="<?php echo SITEURL; ?>images/<?php echo $tenanh; ?>" width="100px">

                                <?php

                                } else {
                                    //hien thong bao
                                    echo "<div class='error'>Không có ảnh</div>";
                                }
                                ?>

                            </td>
                                
                                <td>
                                    <a href="<?php echo SITEURL; ?>updateplace.php?madiemden=<?php echo $madiemden; ?>&tenanh=<?php echo $tenanh; ?>" class="edit" title="Chỉnh sửa thông tin" data-toggle="tooltip"><i class="material-icons">edit</i></a>
                                    <a href="<?php echo SITEURL; ?>detailplace.php?madiemden=<?php echo $madiemden; ?>&tenanh=<?php echo $tenanh; ?>" class="info" title="Thông tin chi tiết" data-toggle="tooltip"><i class="material-icons">info</i></a>
                                </td>
                            </tr>

                <?php


                        }
                    }
                }
                ?>


            </table>
            <div class="clearfix"></div>
            <div class="hint-text">Xem <b><?php echo $rowsPerPage; ?></b> trên tổng số <b><?php echo $c; ?></b> điểm đến</div>
            <ul class="pagination">
            <?php
                $re = mysqli_query($conn, 'select * from diemden');
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
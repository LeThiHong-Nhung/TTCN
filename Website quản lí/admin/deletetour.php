<?php
    //include config
    include('../config/constants.php');
    if(isset($_GET['matour']))
    {
        //lay dl va xoa
        $matour = $_GET['matour'];
        
        //xoa dl
        //chuan bi cau truy van xoa
        $sqlna = "DELETE FROM tour_phuongtien WHERE matour='$matour' ";
        $sqlnn = "DELETE FROM tour_diemden WHERE matour='$matour' ";
        $sql = "DELETE FROM danhsachtour WHERE matour='$matour' ";

        //thuc thi cau truy van
        $resna = mysqli_query($conn,$sqlna);
        $resnn = mysqli_query($conn,$sqlnn);
        $res = mysqli_query($conn,$sql);

        //kiem tra ban ghi da duoc xoa chua
        if($res == true AND $resnn == true AND $resna == true){
            //thiet lap session thong bao thanh cong
            $_SESSION['deletetour']="<div class='success'>Xoá tour thành công!</div>";
            header('location:'.SITEURL.'admin/tour.php');
        }
        else{
            //thiet lap session thong bao that bai
            $_SESSION['deletetour']="<div class='error'>Xoá tour thất bại!</div>";
            //var_dump($res);
            header('location:'.SITEURL.'admin/tour.php');
        }
    }
    else
    {
        header('location:'.SITEURL.'admin/tour.php');
    }
?>
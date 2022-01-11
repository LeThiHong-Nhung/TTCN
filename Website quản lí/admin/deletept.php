<?php
    //include config
    include('../config/constants.php');
    //kiem tra co id va tenanh khong
    if(isset($_GET['maphuongtien']))
    {
        //lay dl va xoa
        $mapt = $_GET['maphuongtien'];

        //xoa dl
        //chuan bi cau truy van xoa
        $sql = "DELETE FROM phuongtien WHERE maphuongtien='$mapt' ";
        $sqlnn="DELETE FROM tour_phuongtien WHERE maphuongtien='$mapt' ";

        //thuc thi cau truy van
        $resnn = mysqli_query($conn,$sqlnn);
        $res = mysqli_query($conn,$sql);
        

        //kiem tra ban ghi da duoc xoa chua
        if($res == true AND $resnn == true){
            //thiet lap session thong bao thanh cong
            $_SESSION['deletept']="<div class='success'>Xoá phương tiện thành công!</div>";
            header('location:'.SITEURL.'admin/phuongtien.php');
        }
        else{
            //thiet lap session thong bao that bai
            $_SESSION['deletept']="<div class='error'>Xoá phương tiện thất bại!</div>";
            //var_dump($res);
            header('location:'.SITEURL.'admin/phuongtien.php');
        }
    }
    else
    {
        //chuyen ve trang manage book
        header('location:'.SITEURL.'admin/phuongtien.php');
    }
?>
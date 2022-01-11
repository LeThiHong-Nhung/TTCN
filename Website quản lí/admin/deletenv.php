<?php
    //include config
    include('../config/constants.php');
    //kiem tra co id va tenanh khong
    if(isset($_GET['manv']))
    {
        //lay dl va xoa
        $manv = $_GET['manv'];
        $sqlt="SELECT email FROM nhanvien WHERE manv='$manv' ";
        $rest=mysqli_query($conn, $sqlnd);
        $rowt=mysqli_fetch_assoc($rest);
        $email=$rowt['email'];

        //xoa dl
        //chuan bi cau truy van xoa
        $sql = "DELETE FROM nhanvien WHERE manv='$manv' ";
        $sqlnn="DELETE FROM nv_ngoaingu WHERE manv='$manv' ";
        $sqlnd="DELETE FROM nguoidung WHERE madangnhap='$email' ";

        //thuc thi cau truy van
        $resnn=mysqli_query($conn,$sqlnn);
        $rest=mysqli_query($conn,$sqlnd);
        $res = mysqli_query($conn,$sql);


        //kiem tra ban ghi da duoc xoa chua
        if($res == true AND $resnn == true AND $rest == true){
            //thiet lap session thong bao thanh cong
            $_SESSION['deletenv']="<div class='success'>Xoá nhân viên thành công!</div>";
            header('location:'.SITEURL.'admin/nhanvien.php');
        }
        else{
            //thiet lap session thong bao that bai
            $_SESSION['deletenv']="<div class='error'>Xoá nhân viên thất bại!</div>";
            //var_dump($res);
            header('location:'.SITEURL.'admin/nhanvien.php');
        }
    }
    else
    {
        //chuyen ve trang manage book
        header('location:'.SITEURL.'admin/nhanvien.php');
    }
?>
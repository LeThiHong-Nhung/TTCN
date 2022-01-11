<?php
    //include config
    include('../config/constants.php');
    //kiem tra co id va tenanh khong
    if(isset($_GET['madiemden']) AND isset($_GET['tenanh']))
    {
        //lay dl va xoa
        $madiemden = $_GET['madiemden'];
        $tenanh = $_GET['tenanh'];

        //xoa anh neu co anh
        if($tenanh!="")
        {
            $path = "../images/".$tenanh;
            //xoa anh
            $remove = unlink($path);

            //neu xoa k thanh cong thi dung va in thong bao
            if($remove==false)
            {
                //thiet lap session
                $_SESSION['remove'] = "<div class='error'>Xoá ảnh thất bại!</div>";
                //chuyen ve trang manage + stop
                header('location:'.SITEURL.'admin/place.php');
                die();
            }
        }
        //xoa dl
        //chuan bi cau truy van xoa
        $sqlnn = "DELETE FROM tour_diemden WHERE madiemden='$madiemden' ";
        $sql = "DELETE FROM diemden WHERE madiemden='$madiemden' ";

        //thuc thi cau truy van
        $resnn = mysqli_query($conn,$sqlnn);
        $res = mysqli_query($conn,$sql);

        //kiem tra ban ghi da duoc xoa chua
        if($res == true){
            //thiet lap session thong bao thanh cong
            $_SESSION['deleteplace']="<div class='success'>Xoá điểm đến thành công!</div>";
            header('location:'.SITEURL.'admin/place.php');
        }
        else{
            //thiet lap session thong bao that bai
            $_SESSION['deleteplace']="<div class='error'>Xoá điểm đến thất bại!</div>";
            //var_dump($res);
            header('location:'.SITEURL.'admin/place.php');
        }
    }
    else
    {
        //chuyen ve trang manage book
        header('location:'.SITEURL.'admin/manage-book.php');
    }
?>
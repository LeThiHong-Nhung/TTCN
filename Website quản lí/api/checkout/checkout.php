<?php
require('../config.php');
require('../configmail.php');

$matour = $_POST['matour'];
$username = $_POST['username'];
$quantity = (int)$_POST['quantity'];
$name = $_POST['name'];
$gender = $_POST['gender'];
$cmnd = $_POST['cmnd'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$existUser = $conn->query("SELECT * FROM khachhang WHERE cmnd = '$cmnd'");

if ($existUser->num_rows > 0) {
    $user = $existUser->fetch_assoc();
    if (mb_strtolower($user['tenkh']) == mb_strtolower($name) && $user['gioitinh'] == $gender) {

        $updateCustomer = $conn->query("UPDATE `khachhang` SET sdt='$phone',email='$email',diachi='$address' WHERE cmnd = '$cmnd'");
        if (!$updateCustomer) {
            $msg = array('message' => 'error insert');
        }
    } else {
        $msg = array('message' => 'error information');
    }
} else {
    $insertCustomer = $conn->query("INSERT INTO khachhang VALUES ('$cmnd','$name','$gender','$phone','$email','$address')");
    if (!$insertCustomer) {
        $msg = array('message' => 'error insert');
    }
}

if (!isset($msg)) {

    $existTicket = $conn->query("SELECT * FROM phieudangki WHERE makhachhang = '$cmnd' AND madangnhap = '$username' AND matour = '$matour'");

    $result = $existTicket->fetch_assoc();
    $quantity += (int)$result['soluong'];
    $now = date('Y-m-d');
    if ($existTicket->num_rows > 0) {
        $result = $existTicket->fetch_assoc();
        $quantity += (int)$result['soluong'];
        $updateTickets = $conn->query("UPDATE `phieudangki` SET soluong = $quantity,`thoigiandk`='$now' WHERE makhachhang = '$cmnd' AND madangnhap = '$username' AND matour = '$matour'");

        if (!$updateTickets) {
            $msg = array('message' => 'error insert');
        } else {
            $msg = array('message' => 'successful');
        }
    } else {

        $insertTicket = $conn->query("INSERT INTO phieudangki(makhachhang, madangnhap, matour, soluong, thoigiandk) 
                                            VALUES ('$cmnd','$username','$matour',$quantity,'$now')");

        if (!$insertTicket) {
            $msg = array('message' => 'error insert');
        } else {

            $tour = $conn->query("SELECT * FROM danhsachtour WHERE matour = '$matour'");
            if ($tour->num_rows > 0) {
                $row = $tour->fetch_assoc();

                $nameTour = $row['tentour'];
                $start = $row['ngaybd'];
                $end = $row['ngaykt'];
                $price = $row['giatour'];

                $content = "            
                <table align='center'>
                  <tr>
                    <th colspan='2'><h2>THÔNG TIN TOUR</h2></th>
                  </tr>
                  <tr>
                    <td>Tour:</td>
                    <td>" . $nameTour . "</td>
                  </tr>
                  <tr>
                    <td>" . date("d-m-Y", strtotime($start)) . "</td>
                    <td>" . date("d-m-Y", strtotime($end)) . "</td>
                  </tr>
                  <tr>
                    <td>Số lượng người:</td>
                    <td>" . $quantity . "</td>
                  </tr>
                  <tr>
                    <td>Tổng chi phí:</td>
                    <td>" . (int)$quantity * (int)$price . "</td>
                  </tr>
                </table>
                <hr />
                <table align='center'>
                  <tr>
                    <th colspan='2'><h3>Thông tin khách hàng</h3></th>
                  </tr>
                  <tr>
                    <td>Họ và tên:</td>
                    <td>" . $name . "</td>
                  </tr>
                  <tr>
                    <td>CMND:</td>
                    <td>" . $cmnd . "</td>
                  </tr>
                  <tr>
                    <td>SDT:</td>
                    <td>" . $phone . "</td>
                  </tr>
                  <tr>
                    <td>Địa chỉ:</td>
                    <td>" . $address . "</td>
                  </tr>
                </table>
                <hr />
                <table align='center'>
                    <tr>
                        <td>
                            <h3>
                                <b>Lưu ý: </b> Đến công ty EJM - Tầng 10, Nhà đa năng, Trường đại học Nha Trang (02, Nguyễn Đình Chiểu, Nha Trang, Khánh Hòa) <br>
                                Trước ngày bắt đầu tour 1 ngày để nhận được vé tuor và thanh toán các khoản cần thiết.
                            </h3>
                        </td>
                    </tr>
                </table>
                
                            ";

                if (sendEmail($email, 'Xác nhận đã đặt tuor ' . $matour . ',', $content)) {
                    $msg = array('message' => 'successful');
                } else {
                    $msg = array('message' => 'error insert');
                }
            }
        }
    }
}

echo json_encode($msg);

// // echo $cmnd.$username.$matour.'-'.$quantity.$now;

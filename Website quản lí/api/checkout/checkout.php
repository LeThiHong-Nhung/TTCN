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
                    <th colspan='2'><h2>TH??NG TIN TOUR</h2></th>
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
                    <td>S??? l?????ng ng?????i:</td>
                    <td>" . $quantity . "</td>
                  </tr>
                  <tr>
                    <td>T???ng chi ph??:</td>
                    <td>" . (int)$quantity * (int)$price . "</td>
                  </tr>
                </table>
                <hr />
                <table align='center'>
                  <tr>
                    <th colspan='2'><h3>Th??ng tin kh??ch h??ng</h3></th>
                  </tr>
                  <tr>
                    <td>H??? v?? t??n:</td>
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
                    <td>?????a ch???:</td>
                    <td>" . $address . "</td>
                  </tr>
                </table>
                <hr />
                <table align='center'>
                    <tr>
                        <td>
                            <h3>
                                <b>L??u ??: </b> ?????n c??ng ty EJM - T???ng 10, Nh?? ??a n??ng, Tr?????ng ?????i h???c Nha Trang (02, Nguy???n ????nh Chi???u, Nha Trang, Kh??nh H??a) <br>
                                Tr?????c ng??y b???t ?????u tour 1 ng??y ????? nh???n ???????c v?? tuor v?? thanh to??n c??c kho???n c???n thi???t.
                            </h3>
                        </td>
                    </tr>
                </table>
                
                            ";

                if (sendEmail($email, 'X??c nh???n ???? ?????t tuor ' . $matour . ',', $content)) {
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

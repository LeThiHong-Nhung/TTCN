<?php ob_start();
include("../Classes/PHPExcel.php");
include('../Classes/PHPExcel/Writer/Excel5.php');

include('../config/constants.php');

$excel=new PHPExcel();
$num=1;
$sql="SELECT a.manv, a.hoten, a.trinhdo, a.gioitinh, a.ngaysinh, a.sdt, a.email,
group_concat(distinct c.tentrinhdo) as dstrinhdo, group_concat(distinct c.tenngoaingu) as dsngoaingu 
from nhanvien a join nv_ngoaingu b on a.manv=b.manv join ngoaingu c on c.matrinhdo=b.matrinhdo
group by a.manv, a.hoten, a.trinhdo, a.gioitinh, a.ngaysinh, a.sdt, a.email";

$res=mysqli_query($conn,$sql);

    $excel->getActiveSheet()->setCellValue('A'.$num, 'Mã nhân viên');
    $excel->getActiveSheet()->setCellValue('B'.$num, 'Tên nhân viên');
    $excel->getActiveSheet()->setCellValue('C'.$num, 'Trình độ');
    $excel->getActiveSheet()->setCellValue('D'.$num, 'Giới tính');
    $excel->getActiveSheet()->setCellValue('E'.$num, 'Ngày sinh');
    $excel->getActiveSheet()->setCellValue('F'.$num, 'SĐT');
    $excel->getActiveSheet()->setCellValue('G'.$num, 'Email');
    $excel->getActiveSheet()->setCellValue('H'.$num, 'Trình độ ngoại ngữ');
    $excel->getActiveSheet()->setCellValue('I'.$num, 'Tên ngoại ngữ');
while($row=mysqli_fetch_assoc($res))
{
    $num++;
    $excel->getActiveSheet()->setCellValue('A'.$num,$row['manv']);
    $excel->getActiveSheet()->setCellValue('B'.$num,$row['hoten']);
    $excel->getActiveSheet()->setCellValue('C'.$num,$row['trinhdo']);
    $excel->getActiveSheet()->setCellValue('D'.$num,$row['gioitinh']);
    $excel->getActiveSheet()->setCellValue('E'.$num,$row['ngaysinh']);
    $excel->getActiveSheet()->setCellValue('F'.$num,$row['sdt']);
    $excel->getActiveSheet()->setCellValue('G'.$num,$row['email']);
    $excel->getActiveSheet()->setCellValue('H'.$num,$row['dstrinhdo']);
    $excel->getActiveSheet()->setCellValue('I'.$num,$row['dsngoaingu']);
}
$writer= new PHPExcel_Writer_Excel5($excel);
$filename="danhsachnhanvien.xls";
header('Content-Encoding: UTF-8');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header( "Content-type: application/vnd.ms-excel; charset=UTF-8" );
//header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
$writer->save('php://output');
$df = fopen( 'php://output', 'w' );
fputs( $df, "\xEF\xBB\xBF" );
fclose($df);
exit();


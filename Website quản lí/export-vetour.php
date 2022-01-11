<?php ob_start();
include("Classes/PHPExcel.php");
include('Classes/PHPExcel/Writer/Excel5.php');

include('config/constants.php');

$excel=new PHPExcel();
$num=1;
$sql="SELECT a.sove,a.matour,b.tentour,a.makhachhang,c.tenkh,a.manv,d.hoten,a.sohd 
from vetour a join danhsachtour b on a.matour=b.matour
join khachhang c on c.cmnd=a.makhachhang 
join nhanvien d on d.manv=a.manv";

$res=mysqli_query($conn,$sql);

    $excel->getActiveSheet()->setCellValue('A'.$num, 'Số vé');
    $excel->getActiveSheet()->setCellValue('B'.$num, 'Mã tour');
    $excel->getActiveSheet()->setCellValue('C'.$num, 'Tên tour');
    $excel->getActiveSheet()->setCellValue('D'.$num, 'Mã khách hàng');
    $excel->getActiveSheet()->setCellValue('E'.$num, 'Tên khách hàng');
    $excel->getActiveSheet()->setCellValue('F'.$num, 'Mã nhân viên');
    $excel->getActiveSheet()->setCellValue('G'.$num, 'Tên nhân viên');
    $excel->getActiveSheet()->setCellValue('H'.$num, 'Số hợp đồng');
while($row=mysqli_fetch_assoc($res))
{
    $num++;
    $excel->getActiveSheet()->setCellValue('A'.$num,$row['sove']);
    $excel->getActiveSheet()->setCellValue('B'.$num,$row['matour']);
    $excel->getActiveSheet()->setCellValue('C'.$num,$row['tentour']);
    $excel->getActiveSheet()->setCellValue('D'.$num,$row['makhachhang']);
    $excel->getActiveSheet()->setCellValue('E'.$num,$row['tenkh']);
    $excel->getActiveSheet()->setCellValue('F'.$num,$row['manv']);
    $excel->getActiveSheet()->setCellValue('G'.$num,$row['hoten']);
    $excel->getActiveSheet()->setCellValue('H'.$num,$row['sohd']);
}
$writer= new PHPExcel_Writer_Excel5($excel);
$filename="danhsachvetour.xls";
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


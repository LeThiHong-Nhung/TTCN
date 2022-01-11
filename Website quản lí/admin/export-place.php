<?php ob_start();
include("../Classes/PHPExcel.php");
include('../Classes/PHPExcel/Writer/Excel5.php');

include('../config/constants.php');

$excel=new PHPExcel();
$num=1;
$sql="SELECT * from diemden";

$res=mysqli_query($conn,$sql);

    $excel->getActiveSheet()->setCellValue('A'.$num, 'Mã điểm đến');
    $excel->getActiveSheet()->setCellValue('B'.$num, 'Tên điểm đến');
    $excel->getActiveSheet()->setCellValue('C'.$num, 'Mô tả');
    $excel->getActiveSheet()->setCellValue('D'.$num, 'Hình ảnh');
while($row=mysqli_fetch_assoc($res))
{
    $num++;
    $excel->getActiveSheet()->setCellValue('A'.$num,$row['madiemden']);
    $excel->getActiveSheet()->setCellValue('B'.$num,$row['tendiemden']);
    $excel->getActiveSheet()->setCellValue('C'.$num,$row['mota']);
    $excel->getActiveSheet()->setCellValue('D'.$num,$row['hinhanh']);
}
$writer= new PHPExcel_Writer_Excel5($excel);
$filename="danhsachdiemden.xls";
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


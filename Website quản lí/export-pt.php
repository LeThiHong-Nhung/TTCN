<?php ob_start();
include("Classes/PHPExcel.php");
include('Classes/PHPExcel/Writer/Excel5.php');

include('config/constants.php');

$excel=new PHPExcel();
$num=1;
$sql="SELECT * from phuongtien";

$res=mysqli_query($conn,$sql);

    $excel->getActiveSheet()->setCellValue('A'.$num, 'Mã phương tiện');
    $excel->getActiveSheet()->setCellValue('B'.$num, 'Tên phương tiện');
    $excel->getActiveSheet()->setCellValue('C'.$num, 'Mô tả');
while($row=mysqli_fetch_assoc($res))
{
    $num++;
    $excel->getActiveSheet()->setCellValue('A'.$num,$row['maphuongtien']);
    $excel->getActiveSheet()->setCellValue('B'.$num,$row['tenphuongtien']);
    $excel->getActiveSheet()->setCellValue('C'.$num,$row['mota']);
}
$writer= new PHPExcel_Writer_Excel5($excel);
$filename="danhsachphuongtien.xls";
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


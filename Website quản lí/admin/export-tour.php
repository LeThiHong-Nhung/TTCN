<?php ob_start();
include("../Classes/PHPExcel.php");
include('../Classes/PHPExcel/Writer/Excel5.php');

include('../config/constants.php');

$excel=new PHPExcel();
$num=1;
$sql="SELECT a.matour,a.tentour,a.ngaybd,a.ngaykt,a.giatour,a.khachsan,a.mota,a.tinhtrang,
GROUP_CONCAT(DISTINCT d.tendiemden) as dsdiemden,GROUP_CONCAT(DISTINCT e.tenphuongtien) as dsphuongtien 
FROM danhsachtour a join tour_diemden b on a.matour=b.matour 
join tour_phuongtien c on a.matour=c.matour join diemden d on d.madiemden=b.madiemden 
join phuongtien e on e.maphuongtien=c.maphuongtien 
GROUP BY a.matour,a.tentour,a.ngaybd,a.ngaykt,a.giatour,a.khachsan,a.mota,a.tinhtrang";

$res=mysqli_query($conn,$sql);

    $excel->getActiveSheet()->setCellValue('A'.$num, 'Mã tour');
    $excel->getActiveSheet()->setCellValue('B'.$num, 'Tên tour');
    $excel->getActiveSheet()->setCellValue('C'.$num, 'Ngày bắt đầu');
    $excel->getActiveSheet()->setCellValue('D'.$num, 'Ngày kết thúc');
    $excel->getActiveSheet()->setCellValue('E'.$num, 'Giá tour');
    $excel->getActiveSheet()->setCellValue('F'.$num, 'Khách sạn');
    $excel->getActiveSheet()->setCellValue('G'.$num, 'Mô tả');
    $excel->getActiveSheet()->setCellValue('H'.$num, 'Tình trạng');
    $excel->getActiveSheet()->setCellValue('I'.$num, 'Điểm đến');
    $excel->getActiveSheet()->setCellValue('J'.$num, 'Phương tiện');
while($row=mysqli_fetch_assoc($res))
{
    $num++;
    $excel->getActiveSheet()->setCellValue('A'.$num,$row['matour']);
    $excel->getActiveSheet()->setCellValue('B'.$num,$row['tentour']);
    $excel->getActiveSheet()->setCellValue('C'.$num,$row['ngaybd']);
    $excel->getActiveSheet()->setCellValue('D'.$num,$row['ngaykt']);
    $excel->getActiveSheet()->setCellValue('E'.$num,$row['giatour']);
    $excel->getActiveSheet()->setCellValue('F'.$num,$row['khachsan']);
    $excel->getActiveSheet()->setCellValue('G'.$num,$row['mota']);
    $excel->getActiveSheet()->setCellValue('H'.$num,$row['tinhtrang']);
    $excel->getActiveSheet()->setCellValue('I'.$num,$row['dsdiemden']);
    $excel->getActiveSheet()->setCellValue('J'.$num,$row['dsphuongtien']);
}
$writer= new PHPExcel_Writer_Excel5($excel);
$filename="danhsachtour.xls";
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


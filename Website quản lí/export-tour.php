<?php ob_start();
include("Classes/PHPExcel.php");
include('Classes/PHPExcel/Writer/Excel5.php');

include('config/constants.php');

$excel=new PHPExcel();
$num=1;
$sql="SELECT a.matour,a.tentour,a.ngaybd,a.ngaykt,a.giatour,a.khachsan,a.mota,a.tinhtrang,
GROUP_CONCAT(DISTINCT d.tendiemden) as dsdiemden,GROUP_CONCAT(DISTINCT e.tenphuongtien) as dsphuongtien 
FROM danhsachtour a join tour_diemden b on a.matour=b.matour 
join tour_phuongtien c on a.matour=c.matour join diemden d on d.madiemden=b.madiemden 
join phuongtien e on e.maphuongtien=c.maphuongtien 
GROUP BY a.matour,a.tentour,a.ngaybd,a.ngaykt,a.giatour,a.khachsan,a.mota,a.tinhtrang";
// $result=mysqli_query($conn,$sql);
// $file_ending = "xls";
// //header info for browser
// header("Content-Type: application/xls; charset=UTF-8");    
// header("Content-Disposition: attachment; filename=$filename.xls");  
// header("Pragma: no-cache"); 
// header("Expires: 0");

// /*******Start of Formatting for Excel*******/   
// //define separator (defines columns in excel & tabs in word)
// $sep = "\t"; //tabbed character
// //start of printing column names as names of MySQL fields
// for ($i = 0; $i < mysqli_num_fields($result); $i++) {
// echo mysqli_fetch_field($result)->$i . "\t";
// }
// print("\n");    
// //end of printing column names  
// //start while loop to get data
//     while($row = mysqli_fetch_row($result))
//     {
//         $schema_insert = "";
//         for($j=0; $j<mysqli_num_fields($result);$j++)
//         {
//             if(!isset($row[$j]))
//                 $schema_insert .= "NULL".$sep;
//             elseif ($row[$j] != "")
//                 $schema_insert .= "$row[$j]".$sep;
//             else
//                 $schema_insert .= "".$sep;
//         }
//         $schema_insert = str_replace($sep."$", "", $schema_insert);
//         $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
//         $schema_insert .= "\t";
//         print(trim($schema_insert));
//         print "\n";
//     }   
$res=mysqli_query($conn,$sql);

    $excel->getActiveSheet()->setCellValue('A'.$num, 'M?? tour');
    $excel->getActiveSheet()->setCellValue('B'.$num, 'T??n tour');
    $excel->getActiveSheet()->setCellValue('C'.$num, 'Ng??y b???t ?????u');
    $excel->getActiveSheet()->setCellValue('D'.$num, 'Ng??y k???t th??c');
    $excel->getActiveSheet()->setCellValue('E'.$num, 'Gi?? tour');
    $excel->getActiveSheet()->setCellValue('F'.$num, 'Kh??ch s???n');
    $excel->getActiveSheet()->setCellValue('G'.$num, 'M?? t???');
    $excel->getActiveSheet()->setCellValue('H'.$num, 'T??nh tr???ng');
    $excel->getActiveSheet()->setCellValue('I'.$num, '??i???m ?????n');
    $excel->getActiveSheet()->setCellValue('J'.$num, 'Ph????ng ti???n');
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


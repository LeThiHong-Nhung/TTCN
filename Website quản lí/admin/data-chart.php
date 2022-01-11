<?php include('../config/constants.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<hr>
<canvas id="myChart" style="width:100%;max-width:600px"></canvas>
<?php
$nam=date("Y");
$sql="SELECT 
    case month(thoigiandk) when 1 then sum(soluong) else 0 end as thang1,
    case month(thoigiandk) when 2 then sum(soluong) else 0 end as thang2,
    case month(thoigiandk) when 3 then sum(soluong) else 0 end as thang3,
    case month(thoigiandk) when 4 then sum(soluong) else 0 end as thang4,
    case month(thoigiandk) when 5 then sum(soluong) else 0 end as thang5,
    case month(thoigiandk) when 6 then sum(soluong) else 0 end as thang6,
    case month(thoigiandk) when 7 then sum(soluong) else 0 end as thang7,
    case month(thoigiandk) when 8 then sum(soluong) else 0 end as thang8,
    case month(thoigiandk) when 9 then sum(soluong) else 0 end as thang9,
    case month(thoigiandk) when 10 then sum(soluong) else 0 end as thang10,
    case month(thoigiandk) when 11 then sum(soluong) else 0 end as thang11,
    case month(thoigiandk) when 12 then sum(soluong) else 0 end as thang12
    FROM phieudangki WHERE YEAR(thoigiandk)='$nam' 
    group by thoigiandk";
$res=mysqli_query($conn, $sql);
$thang1=$thang2=$thang3=$thang4=$thang5=$thang6=$thang7=$thang8=$thang9=$thang10=$thang11=$thang12=array();
    while($row=mysqli_fetch_assoc($res))
    {$thang1[]=$row['thang1'];
    $thang2[]=$row['thang2'];
    $thang3[]=$row['thang3'];
    $thang4[]=$row['thang4'];
    $thang5[]=$row['thang5'];
    $thang6[]=$row['thang6'];
    $thang7[]=$row['thang7'];$thang11[]=$row['thang11'];
    $thang8[]=$row['thang8'];
    $thang9[]=$row['thang9'];$thang12[]=$row['thang12'];
    $thang10[]=$row['thang10'];}
    
    settype($thang1,"array");
    settype($thang2,"array");
    settype($thang3,"array");
    settype($thang4,"array");settype($thang11,"array");
    settype($thang5,"array");
    settype($thang6,"array");
    settype($thang7,"array");
    settype($thang8,"array");
    settype($thang9,"array");
    settype($thang10,"array");
    settype($thang12,"array");
    
    $thang1=array_sum($thang1);
    $thang2=array_sum($thang2);
    $thang3=array_sum($thang3);
    $thang4=array_sum($thang4);
    $thang5=array_sum($thang5);
    $thang6=array_sum($thang6);
    $thang7=array_sum($thang7);
    $thang8=array_sum($thang8);
    $thang9=array_sum($thang9);
    $thang10=array_sum($thang10);
    $thang11=array_sum($thang11);
    $thang12=array_sum($thang12);
?>
<script>
var xValues = ["Tháng 1", "Tháng 2", "Tháng 3","Tháng 4","Tháng 5","Tháng 6","Tháng 7","Tháng 8","Tháng 9","Tháng 10","Tháng 11","Tháng 12"];
var yValues = [<?= $thang1 ?>, <?= $thang2 ?>, <?= $thang3 ?>, <?= $thang4 ?>, <?= $thang5 ?>, <?= $thang6 ?>, <?= $thang7 ?>, <?= $thang8 ?>, <?= $thang9 ?>, <?= $thang10 ?>, <?= $thang11 ?>, <?= $thang12 ?>];
//console.log(yValues);
//var yValues = [1,2,3,4,5,6,7,8,9,10,11,12];
var mmax = Math.max(yValues);

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.1)",
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{ticks: {min: 0, max:50}}],
    }
  }
});
</script>

<?php include('config/constants.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<hr>
<canvas id="myYTChart" style="width:100%;max-width:600px"></canvas>
<?php
$sql="SELECT b.tentour, COUNT(a.matour) as soluotthich FROM yeuthich a join danhsachtour b on a.matour=b.matour 
    GROUP BY b.tentour ORDER BY COUNT(b.matour) DESC LIMIT 5";
$res=mysqli_query($conn, $sql);
$tentour=$soluotthich=array();
while($row=mysqli_fetch_assoc($res))
{
    $tentour[]=$row['tentour'];
    $soluotthich[]=$row['soluotthich'];
    settype($tentour,"array");
    settype($soluotthich,"array");
}  
$tentour=json_encode($tentour);
$soluotthich=json_encode($soluotthich);
?>
<script>
var xValues = <?= $tentour ?>;
var yValues = <?= $soluotthich ?>;

var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("myYTChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Top 5 tour được yêu thích nhiều nhất"
    }
  }
});
</script>

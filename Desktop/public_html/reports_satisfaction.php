<?php
session_start();
include 'include/helper.php';
include 'include/db.inc.php';
include 'views/header.php';
include 'views/footer.php';


$sql = "SELECT * FROM customers_survey";
$result = mysqli_query($conn, $sql);




$datas = [];
$query = "SELECT * FROM customers_survey";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    $datas[] = $row["activities_level"]; 
}
print_r($datas);

?>

<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<body>

<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

<script>
var xValues = [1, 2, 3, 4, 5];

var yValues = <?php echo json_encode($datas); ?>;

var count_array= [];
for (var i =0;i<yValues.length;i++)
{
   
        j=0;
        for (var j =0;j<yValues.length;j++)
        {
            if(i+1<yValues.length)
            {
                if (yValues[j]== i+1)
                 { 
                    count_array[i]++;
                 }
            }
        }
    
}
  
for (var m =0;m<count_array.length;m++)
{
    yValues[m]= count_array[m];
}

var barColors = ["pink", "green","blue","orange","brown"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "שביעות רצון מפעילויות המועדון"
    }
  }
});
</script>

</body>
</html>
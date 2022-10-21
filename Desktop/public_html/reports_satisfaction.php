<?php
session_start();

include 'include/helper.php';
include 'include/db.inc.php';
include 'views/header.php';
include 'views/footer.php';


$sql = "SELECT * FROM customers_survey";
$result = mysqli_query($conn, $sql);

$datas_activities = [];
$datas_management = [];
$datas_gear = [];
$datas_wating = [];
$datas_crew = [];
$datas_customer_id = [];


$query = "SELECT * FROM customers_survey";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    $datas_activities[] = $row["activities_level"];
    $datas_management[] = $row["management_level"];
    $datas_gear[] = $row["gear_level"];
    $datas_wating[] = $row["wating_level"];
    $datas_crew[] = $row["crew_level"];
    $datas_customer_id[] = $row["customer_id"];
    
}


?>

<html>

<body>
<script>

//1activities
var array = <?php echo json_encode($datas_activities); ?>;
var act_sum=0;
for(var i=0; i<array.length; i++){
    act_sum += parseInt(array[i]);
}
var act_avg = act_sum/array.length;



//2management
var array = <?php echo json_encode($datas_management); ?>;
var mng_sum=0;
for(var i=0; i<array.length; i++){
    mng_sum += parseInt(array[i]);
}
var mng_avg = mng_sum/array.length;


//3crew
var array = <?php echo json_encode($datas_crew); ?>;
var crew_sum=0;
for(var i=0; i<array.length; i++){
    crew_sum += parseInt(array[i]);
}
var crew_avg = crew_sum/array.length;


//4gear
var array = <?php echo json_encode($datas_gear); ?>;
var gear_sum=0;
for(var i=0; i<array.length; i++){
    gear_sum += parseInt(array[i]);
}
var gear_avg = gear_sum/array.length;



//5wating
var array = <?php echo json_encode($datas_wating); ?>;
var wating_sum=0;
for(var i=0; i<array.length; i++){
    wating_sum += parseInt(array[i]);
}
var wating_avg = wating_sum/array.length;

</script>
    <div style="text-align: center;">
                        <h2>ממוצע סקר שביעות רצון</h2>
                                <br>
                                <h3>טווח נתונים לקליטה בין 1 ל 6</h3>
                                <br>  
    </div>
    <table>
        <tr>
                <div>
                   
                    <br>
                    <?php
                    if( isset( $message )) {
                        echo '<p class="success">'.$message.'</p>';
                    } else if( isset( $error )) {
                        echo '<p class="warning"">'.$error.'</p>';
                    }
                    ?>
                    <?php
                    $levels = $conn->query("SELECT * FROM `levels`");
                    
                    ?>
                    
                    <form action="satisfaction.php" method="post">
                       
                       <table style="width: 98%;" border="1">
                        <tr>
                        <th>שאלה</th>
                        <th>ממוצע</th>
                       
                        </tr>
                             <tr>
                               <td style="text-align: right;">שביעות רצון מפעילויות המועדון:</td>
                               <td><script>document.write(act_avg)</script></td>                                
                            </tr>
                            <tr>
                                <td style="text-align: right;">שביעות רצון מהנהלת המועדון:</td>
                               <td><script>document.write(mng_avg)</script></td>       
                            </tr>
                            <tr>
                                <td style="text-align: right;">שביעות רצון מציוד המועדון:</td>
                                <td><script>document.write(gear_avg)</script></td>
                            </tr>
                        
                            <tr>
                                <td style="text-align: right;">שביעות רצון מזמני ההמתנה במועדון:</td>
                                    <td><script>document.write(wating_avg)</script></td>
                             </tr>
                             <tr>
                                <td style="text-align: right;">שביעות רצון מצוות המועדון:</td>
                                    <td><script>document.write(crew_avg)</script></td>

                             
                        </table>

                    </form>
                    <a href="reports.php" class="button">חזרה</a>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>


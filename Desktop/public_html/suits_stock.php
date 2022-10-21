<?php https://isomerte.mtacloud.co.il/edit_suits.php?edit=&id=1
session_start();
include 'include/helper.php';
include 'include/db.inc.php';
// if( !isLogin() || getRoleId() == 3 ){
//     header('location:index.php');
//     exit;
// }
$is_suit_reports = true;

if(isset($_GET['delete_id'])){
    $delete_page  = $_GET['delete_id'];

    $sql_query="DELETE FROM suits WHERE id=".$delete_page;
    // exit();
    mysqli_query($conn,$sql_query);
    header("Location: $_SERVER[PHP_SELF]");
}

if(isset($_POST['update_board'])){

    $id=$_POST['id'];
    $condition=$_POST['condition'];
    $size_id=$_POST['size_id'];
    $gender=$_POST['gender'];
    $brand=$_POST['brand'];
    // $board_type=$_POST['board_type'];
    $id_number=$_POST['id_number'];


    $update="UPDATE `suits` SET 
    `condition`='".$condition."', 
    `size_id`='".$size_id."',
    `gender`='".$gender."',
    `brand`='".$brand."',
    `id_number`='".$id_number."'  
    WHERE `id`='".$id."'";
    mysqli_query($conn, $update) or die(mysqli_error($conn));
}


// getBoards
$sql = "SELECT `suits`.*, `suits_sizes`.`size_name` FROM `suits` LEFT JOIN `suits_sizes` ON `suits`.`size_id`=`suits_sizes`.`id`";
$results = $conn->query( $sql );


$chart_arr = array();
$chart_arr[] = ['תקין/לא תקין', 'חליפות'];
$chart_arr[] = ['תקין', 0]; // $chart_arr[1][1]++;
$chart_arr[] = ['לא תקין', 0]; // $chart_arr[2][1]++;

while ( $suit = $results->fetch_assoc() ) {
    $condition = $suit['condition'];
    if($condition == 1 ) {
        $chart_arr[1][1]++;
    } else {
        $chart_arr[2][1]++;
    }
}

// return to first row
$results->data_seek(0 );
include 'views/header.php';
?>
    <table>
        <tr>
            <td style="width: 25%; vertical-align: top;">
                <?php
                include "views/sidenav.php";
                ?>
            </td>
            <td style="width: 75%;">
                <h1>ניהול מלאי</h1>
                <h2>חליפות גלישה</h2>
                <table style="width: 98%;" border="1">
                    <tr>
                        <th>#</th>
                        <th>מספר סידורי</th>
                        <th>מצב</th>
                        <th>מותג</th>
                        <th>מידה</th>
                        <th>עריכה/מחיקה</th>
                    </tr>
                    <?php
                    $counter = 1;
                    while ( $suits = $results->fetch_assoc() ) {
                        $bg_color = "#A4D74E";
                        $condition_string = "תקין";
                        if($suits['condition'] == 0 ) {
                            $bg_color = "#FC6051";
                            $condition_string = "לא תקין";
                        }
                        $gender = "נקבה";
                        if($suits['gender'] == 2 ) {
                            $gender = "זכר";
                        }
                        ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $suits['id_number']; ?></td>
                            <td style="background-color: <?php echo $bg_color; ?>"><?php echo $condition_string; ?></td>
                            <td><?php echo $suits['brand']; ?></td>
                            <td><?php echo $suits['size_name']; ?></td>
                            <td>
                            
                            <form action="edit_suits.php" method="get">
                                <button type="submit" name="edit" id="updateBoard">עדכון</button>
                                <input type="hidden" value="<?php echo $suits['id']; ?>" name="id">
                            </form>   
                            <button onclick="delete_id(<?php echo $suits['id']; ?>)" id="deleteBoard">מחק</button></td>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <br>
                <a href="stock_managment.php" class="button">חזרה</a>
            </td>
        </tr>
    </table>

    <script>
        function delete_id(id)
{
 if(confirm('Sure to Delete ?'))
 {
  window.location.href='suits_stock.php?delete_id='+id;
 }
}
    </script>

<?php
include 'views/footer.php';


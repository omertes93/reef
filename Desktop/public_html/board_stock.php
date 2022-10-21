<?php
session_start();
include 'include/helper.php';
include 'include/db.inc.php';

// if( !isLogin() || getRoleId() == 3 ){
//     header('location:index.php');
//     exit;
// }
$is_boards_reports = true;
if(isset($_GET['delete_id'])){
    $delete_page  = $_GET['delete_id'];

    $sql_query="DELETE FROM boards WHERE id=".$delete_page;
    // exit();
    mysqli_query($conn,$sql_query);
    header("Location: $_SERVER[PHP_SELF]");
    
}
if(isset($_POST['update_board'])){

    $id=$_POST['id'];
    $condition=$_POST['condition'];
    $thickness=$_POST['thickness'];
    $length=$_POST['length'];
    $width=$_POST['width'];
    $board_type=$_POST['board_type'];
    $idnumber=$_POST['idnumber'];

    $update="UPDATE `boards` SET 
    `condition`='".$condition."', 
    `thickness`='".$thickness."',
    `length`='".$length."',
    `width`='".$width."',
    `board_type_id`='".$board_type."',
    `id_number`='".$idnumber."'  
    WHERE `id`='".$id."'";
    mysqli_query($conn, $update) or die(mysqli_error($conn));
}

// getBoards
$sql = "SELECT `boards`.*, `board_types`.`name` FROM `boards` LEFT JOIN `board_types` ON `boards`.`board_type_id`=`board_types`.`id`";
$results = $conn->query( $sql );


$chart_arr = array();
$chart_arr[] = ['תקין/לא תקין', 'גלשנים'];
$chart_arr[] = ['תקין', 0]; // $chart_arr[1][1]++;
$chart_arr[] = ['לא תקין', 0]; // $chart_arr[2][1]++;

// מערך השומר את מספר הפעמים שהשתמשו בכל סוג של גלשן
// יש שלושה סוגי גלשנים: סופט, פאנבורד, הארד
$chart_arr_2 = array();
$chart_arr_2[] = ['סוג הגלשן', 'מספר הגלשנים במלאי', 'מספר הפעמים שהיה בשימוש','סה"כ תקינים','סה"כ לא תקינים'];
$chart_arr_2[] = ['Soft', 0, 0,0,0];
$chart_arr_2[] = ['Funboard', 0, 0,0,0];
$chart_arr_2[] = ['Hard', 0, 0,0,0];


while ( $board = $results->fetch_assoc() ) {
    $condition = $board['condition'];
    if($condition == 1 ) {
        $chart_arr[1][1]++;
    } else {
        $chart_arr[2][1]++;
    }

    $board_type_id = $board['board_type_id'];
    $chart_arr_2[$board_type_id][1]++;
    $chart_arr_2[$board_type_id][2] += $board['number_of_rents'];
    if($condition == 1 ) {
        $chart_arr_2[$board_type_id][3]++;
    } else {
        $chart_arr_2[$board_type_id][4]++;
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
                <h2>גלשנים</h2>
                <table style="width: 100%;" border="1">
                    <tr>
                        <th>#</th>
                        <th>סוג</th>
                        <th>מספר סידורי</th>
                        <th>מצב</th>
                        <th>אורך</th>
                        <th>רוחב</th>
                        <th>עובי</th>
                        <th>עריכה/מחיקה</th>
                    </tr>
                    <?php
                    $counter = 1;
                    while ( $board = $results->fetch_assoc() ) {
                        $condition = $board['condition'];
                        $bg_color = "#A4D74E";
                        $condition_string = "תקין";
                        if($condition == 0 ) {
                            $bg_color = "#FC6051";
                            $condition_string = "לא תקין";
                        }
                        ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $board['name']; ?></td>
                        <td><?php echo $board['id_number']; ?></td>
                        <td style="background-color: <?php echo $bg_color; ?>" > <?php echo $condition_string; ?></td>
                        <td><?php echo $board['length']; ?> ס"מ</td>
                        <td><?php echo $board['width']; ?> ס"מ</td>
                        <td><?php echo $board['thickness']; ?> ס"מ</td>
                        <td> 
                            <form action="edit_boards.php" method="get">
                                <button type="submit" name="edit" id="updateBoard">עדכון</button>
                                <input type="hidden" value="<?php echo $board['id']; ?>" name="id">
                            </form>   <button onclick="delete_id(<?php echo $board['id']; ?>)" id="deleteBoard">מחק</button></td>
                    </tr>
                    <?php
                    }
                    ?>
            </td>
             
        </tr>
    </table>
 <br>
                <a href="stock_managment.php" class="button">חזרה</a>
    <script>
        function delete_id(id)
{
 if(confirm('Sure to Delete ?'))
 {
  window.location.href='board_stock.php?delete_id='+id;
 }
}
    </script>
<?php
include 'views/footer.php';


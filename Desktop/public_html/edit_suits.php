<?php
session_start();
include 'include/helper.php';
include 'include/db.inc.php';

// if( !isLogin() || getRoleId() == 3 ){
//     header('location:index.php');
//     exit;
// }
$is_boards_reports = true;
if(isset($_GET['edit'])){
    echo $edit_page  = $_GET['id'];

    // SELECT *
    // FROM posts p
    //   LEFT JOIN comments c
    //     ON p.post_id = c.post_id
    //     AND c.deleted = 0
    //   LEFT JOIN replies r
    //     ON p.post_id = r.post_id
    //     AND r.deleted = 0  
    // WHERE p.user_id = $user_id

    $query = "SELECT `suits`.*, `suits_sizes`.`size_name` from suits LEFT JOIN `suits_sizes` ON suits.size_id = suits_sizes.id where suits.id='".$edit_page."'";  


    $result = mysqli_query($conn, $query) or die ( mysqli_error());
    $row = mysqli_fetch_assoc($result);

    // print_r($row);
    
    // $sql_query="DELETE FROM boards WHERE id=".$delete_page;
    // // exit();
    // mysqli_query($conn,$sql_query);
    // header("Location: $_SERVER[PHP_SELF]");
    $sqlboardtype = "SELECT * from suits_sizes";
    $boardtyperesult = mysqli_query($conn, $sqlboardtype) or die ( mysqli_error());
    $boardtypes = mysqli_fetch_all($boardtyperesult);
    // print_r($boardtypes);

}

include 'views/header.php';
?>
    

    <form action="suits_stock.php" method="post" onsubmit="return validateCustomerData()">
    <h3>עדכון חליפה # <?php echo $row['id_number']; ?></h3>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left;">מזהה חליפה</td>
                                <td><input type="text" name="id_number" value="<?php echo $row['id_number']; ?>" required></td>
                           
                                <td style="text-align: left;">מידה</td>
                                <td>
                                    <select name="size_id" id="size_id">
                                        <?php 
                                        foreach ($boardtypes as $key => $boardtype) { 
                                            if($row['size_id'] ===  $boardtype[0]) {
                                                continue;
                                            }
                                            ?>
                                             <option value="<?php echo $boardtype[0]; ?>"><?php echo $boardtype[1]; ?></option>
                                        <? } ?>
                                        <option selected value="<?php echo $row['size_id']; ?>"><?php echo $row['size_name']; ?></option>
                                    </select>
                                </td>       
                            </tr>
                            <tr>
                                <td style="text-align: left;">מצב החליפה</td>
                                <td>
                                    <select name="condition" id="condition">
                                        <option <?php if($row['condition'] == 0) {echo "selected"; } ?> value="0">Used</option>
                                        <option <?php if($row['condition'] == 1) {echo "selected"; } ?> value="1">New</option>
                                    </select>
                                </td>
                                <td style="text-align: left;">חברה</td>
                                <td><input type="text" name="brand" required value="<?php echo $row['brand']?>"></td>
                               
                            </tr>
                          
                            <tr>
                                <td >&nbsp;</td>
                                <br>
                                <td>
								<br>
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
						            <input type="submit" name="update_board" class="button" value="עדכון" >

                                </td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                    </form>

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


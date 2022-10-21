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
    $edit_page  = $_GET['id'];

    // SELECT *
    // FROM posts p
    //   LEFT JOIN comments c
    //     ON p.post_id = c.post_id
    //     AND c.deleted = 0
    //   LEFT JOIN replies r
    //     ON p.post_id = r.post_id
    //     AND r.deleted = 0  
    // WHERE p.user_id = $user_id

    $query = "SELECT `boards`.*, `board_types`.`name` from boards LEFT JOIN `board_types` ON boards.board_type_id = board_types.id where boards.id='".$edit_page."'";  
    $result = mysqli_query($conn, $query) or die ( mysqli_error());
    $row = mysqli_fetch_assoc($result);

    // print_r($row);
    // $sql_query="DELETE FROM boards WHERE id=".$delete_page;
    // // exit();
    // mysqli_query($conn,$sql_query);
    // header("Location: $_SERVER[PHP_SELF]");
    $sqlboardtype = "SELECT * from board_types";
    $boardtyperesult = mysqli_query($conn, $sqlboardtype) or die ( mysqli_error());
    $boardtypes = mysqli_fetch_all($boardtyperesult);
    // print_r($boardtypes);

}


include 'views/header.php';
?>
    

    <form action="board_stock.php" method="post" onsubmit="return validateCustomerData()">
    <h3>עדכון גלשן # <?php echo $row['id_number']; ?></h3>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left;">מזהה גלשן:</td>
                                <td><input type="text" name="idnumber" value="<?php echo $row['id_number']; ?>" required></td>
                           
                                <td style="text-align: left;">סוג גלשן:</td>
                                <td>
                                    <select name="board_type" id="board_type">
                                        <?php 
                                        foreach ($boardtypes as $key => $boardtype) { 
                                            if($row['board_type_id'] ===  $boardtype[0]) {
                                                continue;
                                            }
                                            ?>
                                             <option value="<?php echo $boardtype[0]; ?>"><?php echo $boardtype[1]; ?></option>
                                        <? } ?>
                                        <option selected value="<?php echo $row['board_type_id']; ?>"><?php echo $row['name']; ?></option>
                                    </select>
                                </td>       
                            </tr>
                            <tr>
                                <td style="text-align: left;">מצב הגלשן:</td>
                                <td>
                                    <select name="condition" id="condition">
                                        <option <?php if($row['condition'] == 0) {echo "selected"; } ?> value="0">לא תקין</option>
                                        <option <?php if($row['condition'] == 1) {echo "selected"; } ?> value="1">תקין</option>
                                    </select>
                                </td>
                                <td style="text-align: left;">עובי:</td>
                                <td><input type="text" name="thickness" required value="<?php echo $row['thickness']?>"></td>
                               
                            </tr>
                            <tr>
                                <td style="text-align: left;">אורך:</td>
                                <td><input type="text" name="length" required value="<?php echo $row['length']?>"></td>
                                <td style="text-align: left;">רוחב:</td>
                                <td><input type="text" name="width" required value="<?php echo $row['width']?>"></td>
                               
                            </tr>
                          
                            <tr>
                                <td >&nbsp;</td>
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
  window.location.href='stock_managment.php?delete_id='+id;
 }
}
    </script>
<?php
include 'views/footer.php';


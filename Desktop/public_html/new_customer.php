<?php
session_start();
include "include/helper.php";
include 'include/db.inc.php';
if( !isLogin() ){
    header('location:index.php');
    exit;
}

$message = null;
$error = null;
if( isset( $_REQUEST['new_customer'])) {
    $name = $_REQUEST['name'];
    $id_number = $_REQUEST['id_number'];
    $date_of_birth = $_REQUEST['date_of_birth'];
    $gender = $_REQUEST['gender'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $city = $_REQUEST['city'];
    $address = $_REQUEST['address'];
    $insurance = $_REQUEST['insurance'];
    $level_id = $_REQUEST['level_id'];
    $height = $_REQUEST['height'];
    $weight = $_REQUEST['weight'];
    $suit_size_id = $_REQUEST['suit_size_id'];
	
    $select = "SELECT * FROM `customers` WHERE `id_number`=$id_number";
    $result = $conn->query( $select );
    if( $result->num_rows === 0 ) {
        $insert = "INSERT INTO `customers`
               (`name`, `id_number`, `date_of_birth`, `gender`, `email`, `phone`, `city`, `address`, `insurance`, `level_id`, `height`, `weight`, `suit_size_id`) 
               VALUES ( '$name', $id_number, '$date_of_birth', $gender, '$email', '$phone', '$city', '$address', $insurance, $level_id, $height, $weight, $suit_size_id )";
        $conn->query($insert);
        $_SESSION['success-message'] = "המשתמש/ת נמחק/ה בהצלחה מהמערכת!";
		header('location:customers.php');
    } else {
        $error = " הלקוח ($id_number) כבר קיים במערכת";
    }
}

include 'views/header.php';
?>
    <table>
        <tr>
            <td style="width: 25%; vertical-align: top;">
                <?php
                include "views/sidenav.php";
                ?>
            </td>
			<td >&nbsp;</td>
            <td style="width: 75%;">
                <div>

                    <h1 style="text-align: center">הוספת לקוח/ה חדש/ה </h1>
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
                    $suits_sizes = $conn->query("SELECT * FROM `suits_sizes`");
                    ?>
                    <form action="new_customer.php" method="post" onsubmit="return validateCustomerData()">
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left;">שם הגולש/ת:</td>
                                <td><input type="text" name="name" value="<?php if(isset( $_REQUEST['name'])) {echo $_REQUEST['name'];}?>" required></td>
                                <td style="text-align: left;">ת.ז:</td>
                                <td><input type="number" name="id_number" id="id_number" value="<?php if(isset( $_REQUEST['id_number'])) {echo $_REQUEST['id_number'];}?>" required></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">תאריך לידה:</td>
                                <td><input type="date" name="date_of_birth" value="<?php if(isset( $_REQUEST['date_of_birth'])) {echo $_REQUEST['date_of_birth'];}?>" required></td>
                                <td style="text-align: left;">מגדר:</td>
                                <td>
                                    <input type="radio" name="gender" value="1" required <?php if( isset( $_REQUEST['gender'] ) && $_REQUEST['gender'] == 1 ){ echo ' checked="checked"'; }?>> נקבה
                                    <input type="radio" name="gender" value="2" required <?php if( isset( $_REQUEST['gender'] ) && $_REQUEST['gender'] == 2 ){ echo ' checked="checked"'; }?>>  זכר
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">אימייל:</td>
                                <td><input type="email" name="email" required value="<?php if(isset( $_REQUEST['email'])) {echo $_REQUEST['email'];}?>"></td>
                                <td style="text-align: left;">טלפון:</td>
                                <td><input type="text" name="phone" required value="<?php if(isset( $_REQUEST['phone'])) {echo $_REQUEST['phone'];}?>"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">עיר:</td>
                                <td><input type="text" name="city" required value="<?php if(isset( $_REQUEST['city'])) {echo $_REQUEST['city'];}?>"></td>
                                <td style="text-align: left;">כתובת:</td>
                                <td><input type="text" name="address" required value="<?php if(isset( $_REQUEST['address'])) {echo $_REQUEST['address'];}?>"></td>
                            </tr>
							<tr>
                                <td style="text-align: left;"> מידה:</td>
                                <td>
                                    <select name="suit_size_id" id="suit_size_id">
                                        <option value="0">בחר/י</option>
                                        <?php
                                        foreach ( $suits_sizes as $size ) {
                                            $selected = "";
                                            if( isset($_REQUEST['suit_size_id'] ) && $_REQUEST['suit_size_id'] == $size['id'] ) {
                                                $selected = ' selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $size['id'];?>" <?php echo $selected;?>>
                                                <?php echo $size['size_name']; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                              
								<td style="text-align: left;">רמה:</td>
                                <td>
                                    <select name="level_id" id="level_id">
                                        <option value="0">בחר/י</option>
                                        <?php
                                        foreach ( $levels as $level ) {
                                            $selected = "";
                                            if( isset($_REQUEST['level_id'] ) && $_REQUEST['level_id'] == $level['id'] ) {
                                                $selected = ' selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $level['id'];?>" <?php echo $selected;?>>
                                                <?php echo $level['name']; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
							<tr>
                                <td style="text-align: left;">גובה(ס"מ):</td>
                                <td><input type="number" name="height" required value="<?php if(isset( $_REQUEST['height'])) {echo $_REQUEST['height'];}?>"></td>
                                <td style="text-align: left;">משקל(ק"ג):</td>
                                <td><input type="number" name="weight" required value="<?php if(isset( $_REQUEST['weight'])) {echo $_REQUEST['weight'];}?>"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">ביטוח?:</td>
                                <td>
                                    <input type="radio" name="insurance" required value="0" <?php if( isset( $_REQUEST['insurance'] ) && $_REQUEST['insurance'] == 0 ){ echo ' checked="checked"'; }?> > אין
                                    <input type="radio" name="insurance" required value="1" <?php if( isset( $_REQUEST['insurance'] ) && $_REQUEST['insurance'] == 1 ){ echo ' checked="checked"'; }?>> יש
                                </td>
                               
                            </tr>
                            <tr>
                                <td >&nbsp;</td>
                                <td>
								<br>
						            <input type="submit" name="new_customer" class="button" value="הוספת לקוח/ה" >

                                </td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
        </tr>
    </table>
<?php
include 'views/footer.php';

<?php
session_start();
include "include/helper.php";
include 'include/db.inc.php';


$message = null;
$error = null;
if( isset( $_REQUEST['new_employee'])) {
    $id_number = $_REQUEST['id_number'];
    $role_id = $_REQUEST['role_id'];
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];    
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $city = $_REQUEST['city'];
    $address = $_REQUEST['address'];
	
    $select = "SELECT * FROM `employees` WHERE `id_number`=$id_number";
    $result = $conn->query( $select );
    if( $result->num_rows === 0 ) {
        $insert = "INSERT INTO `employees`
               (`role_id`, `id_number`, `username`, `password`, `name`, `email`, `phone`, `city`, `address`) 
               VALUES ( '$role_id', $id_number, '$username', '$password', '$name', '$email', '$phone', '$city', '$address')";
        $conn->query($insert);
        $_SESSION['success-message'] = "המשתמש/ת נמחק/ה בהצלחה מהמערכת!";
		header('location:employee.php');
    } else {
        $error = " העובד ($id_number) כבר קיים במערכת";
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
            <td style="width: 75%;border: 3px solid; ">
                <div>

                    <h1 style="text-align: center">הוספת עובד/ת חדש/ה</h1>
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
                    <form action="new_employee.php" method="post">
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left;">שם העובד:</td>
                                <td><input type="text" name="name" value="" required></td>
                                <td style="text-align: left;">ת.ז:</td>
                                <td><input type="number" name="id_number" id="id_number" value="" required></td>
                               <td style="text-align: left;">רמת הרשאות:</td>
                               <td><input type="number" name="role_id" id="role_id" value="" required></td>                                
                            </tr>
                            <tr>
                                <td style="text-align: left;">שם משתמש:</td>
                                <td><input type="text" name="username" required value=""></td>
                                <td style="text-align: left;">סיסמא:</td>
                                <td><input type="password" name="password" required value=""></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">אימייל:</td>
                                <td><input type="email" name="email" required value=""></td>
                                <td style="text-align: left;">טלפון:</td>
                                <td><input type="text" name="phone" required value=""></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">עיר:</td>
                                <td><input type="text" name="city" required value=""></td>
                                <td style="text-align: left;">כתובת:</td>
                                <td><input type="text" name="address" required value=""></td>
                            </tr>
                            <tr>
                                <td >&nbsp;</td>
                              
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                        <div style="text-align:center;">
                         <input type="submit" name="new_employee" class="button" value="הוספת עובד/ת" >
                        </div>
                    </form>
                </div>
            </td>
        </tr>
    </table>
<?php
include 'views/footer.php';

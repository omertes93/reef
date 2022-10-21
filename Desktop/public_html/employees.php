<?php
session_start();
include "include/helper.php";
include 'include/db.inc.php';

if( !isLogin() ){
    header('location:index.php');
    exit;
}

unset( $_SESSION['employee_id'] );

$error = "";

// נבדוק האם הטופס נשלח

if( isset($_REQUEST['search']) ) {
    $name = $_REQUEST['name'];
    $id_number = $_REQUEST['id_number'];
    $result = $conn->query("SELECT * FROM `employees` WHERE `name`='$name' AND `id_number`='$id_number'");
    if( $result->num_rows === 1 ) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $employee_id = $row['id'];
        $_SESSION['employee_id'] = $employee_id;
        header('location:employees.php');
        exit;
    } else {
        $error = "לא נמצא/ה עובד/ת עם הפרטים שהוזנו";
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
			<td>&nbsp </td>
            <td style="width: 75%; border: 3px solid;">
                <div style="width: 400px; margin:0px auto; ">
                    <h1>חיפוש עובד/ת במערכת</h1>
					<br>
                    <?php
                    if( isset( $_SESSION['employee_deleted']  )) {
                        echo '<p class="success">המשתמש/ת נמחק/ה בהצלחה מהמערכת!</p>';
                        unset($_SESSION['employee_deleted'] );
                    }
                    if( isset( $_SESSION['success-message']  )) {
                        echo '<p class="success">המשתמש/ת נוסף/ה בהצלחה למערכת!</p>';
                        unset($_SESSION['success-message'] );
                    }
                    ?>
                    <p class="error"><?php echo $error;?></p>
                    <form action="employees.php" method="get">
                        <table style="width: 100%;">
                            <tr>
                                <td> שם העובד/ת: </td>
                                <td>
                                    <input type="text" name="name" id="name" placeholder="שם העובד/ת" required onkeyup="getNameSuggestions()" autocomplete="off">
                                   <ul id="suggestion-list">
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>ת.ז:</td>
                                <td><input type="text" name="id_number" placeholder="תעודת זהות" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" class="button" name="search" value="אישור">
                                    <input type="reset" class="button" value="איפוס" style="float: left;">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <br>
                                    <br>
                                    <a href="new_employee.php" class="button">רישום עובד/ת חדש/ה</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
        </tr>
    </table>
	<br>
<?php
include 'views/footer.php';

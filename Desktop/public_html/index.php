<?php
session_start();
include "include/helper.php";

if( isLogin() ){
    header('location:dashboard.php');
    exit;
}

include 'include/db.inc.php';
$error = "";
// נבדוק האם הטופס נשלח
if( isset($_REQUEST['login']) ) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $result = $conn->query("SELECT * FROM `employees` WHERE `username`='$username' AND `password`='$password'");
    if( $result->num_rows === 1 ) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $_SESSION['employee_id'] = $row['id'];
        $_SESSION['role_id'] = $row['role_id'];
        $_SESSION['name'] = $row['name'];
        header('location:dashboard.php');
        exit;
    } else {
        $error = "ההתחברות נכשלה. לא נמצא משתמש עם הפרטים שהוזנו.";
    }
}

include 'views/header.php';
?>
    <div style="width: 400px; margin: 100px auto 0 auto;">
        <h1>התחברות למערכת</h1>
        <p class="error"><?php echo $error;?></p>
        <form action="index.php" method="post">
            <table style="width: 80%;">
                <tr>
                    <td>שם משתמש:</td>
                    <td><input type="text" name="username" placeholder="שם משתמש..." required></td>
                </tr>
                <tr>
                    <td>סיסמה:</td>
                    <td><input type="password" name="password" placeholder="סיסמה..." required></td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>
                        <input type="submit" class="button" name="login" value="אישור">
                        <input type="reset" class="button" value="איפוס" style="float: left;">
                    </td>
                </tr>
            </table>
        </form>
    </div>
<?php
include 'views/footer.php';

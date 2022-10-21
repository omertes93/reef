<?php
session_start();
include 'include/helper.php';
include 'include/db.inc.php';
if( !isLogin() || getRoleId() == 3 || getRoleId() == 4 ){
    header('location:index.php');
    exit;
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
            <td style="width: 75%;">
                <h1> דו"חות כספיים</h1>
                <div>
                    <a href="reports.php" class="button">חזרה</a>
                </div>
            </td>
        </tr>
    </table>
<?php
include 'views/footer.php';

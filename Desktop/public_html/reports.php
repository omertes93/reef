<?php
session_start();
include 'include/helper.php';
include 'include/db.inc.php';
// if( !isLogin() || getRoleId() == 3 ){
//     header('location:index.php');
//     exit;
// }
include 'views/header.php';
?>
    <table style="width: 100%;">
    <tr>
             <td style="width: 25% ;vertical-align: top;">
                <?php
                include "views/sidenav.php";
                ?>
            </td>
            <td style="width: 75%;border: 3px solid; text-align:center;">
                <h1>דו"חות</h1>
                <br>
                <div>
                    <a href="reports_boards.php" class="button">דו"ח גלשנים</a>
                </div>
                <br>
                <div>
                    <a href="reports_suits.php" class="button">דו"ח חליפות גלישה</a>
                </div>
                <br>
                <div>
                    <a href="reports_satisfaction.php" class="button">דו"ח סקר שביעות רצון</a>
                </div>
               
            </td>
        </tr>
    </table>
<?php
include 'views/footer.php';


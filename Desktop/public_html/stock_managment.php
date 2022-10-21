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
             <td style="width: 25%;vertical-align: top;">
            <?php
            include "views/sidenav.php";
            ?>
        </td>
        <td style="width: 75%;border: 3px solid; text-align:center;">
                <h1>ניהול מלאי</h1>
                <br>
                <div>
                    <a href="board_stock.php" class="button">ניהול גלשנים</a>
                </div>
                <br>
                <div>
                    <a href="suits_stock.php" class="button">ניהול חליפות</a>
                </div>
                <br>
               
            </td>
        </tr>
    </table>
<?php
include 'views/footer.php';


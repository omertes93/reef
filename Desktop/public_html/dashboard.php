<?php
session_start();
include "include/helper.php";
if( !isLogin() ){
    header('location:index.php');
    exit;
}

include 'include/db.inc.php';
include 'views/header.php';
?>


<div id="content">
    <table>
        <tr>
            <td style="width: 30%; vertical-align: top;">
                <?php
                include "views/sidenav.php";
                ?>
            </td>
            <td style="width: 70%; text-align: center">
                <img src="images/logo.png" alt="" style="max-width: 100%; width: 500px;">
            </td>
        </tr>
    </table>
</div>

<?php
include 'views/footer.php';

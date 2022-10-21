<div  class="tab" data-tab_id="5" <?php if($tab_id == 5 ) { echo ' style="display:block;"';}?>>
<?php
session_start();

include 'include/db.inc.php';

$message = null;
$error = null;
if( isset( $_REQUEST['new_survey'])) {
    $id_number = $_REQUEST['id_number'];
    $activities_level = $_REQUEST['ractivities_level'];
    $management_level = $_REQUEST['management_level'];
    $gear_level = $_REQUEST['gear_level'];    
    $wating_level = $_REQUEST['wating_level'];
    $crew_level = $_REQUEST['crew_level'];
    $customer_id = $_REQUEST['customer_id'];
	
    $select = "SELECT * FROM `customers_survey` WHERE `id_number`=$id_number";
    $result = $conn->query( $select );
    if( $result->num_rows === 0 ) {
        $insert = "INSERT INTO `customers_survey`
               (`id_number`, `ractivities_level`, `management_level`, `gear_level`, `wating_level`, `crew_level`, `customer_id`) 
               VALUES ( '$id_number', $ractivities_level, '$management_level', '$gear_level', '$wating_level', '$crew_level', '$customer_id')";
        $conn->query($insert);
        $_SESSION['success-message'] = "הטופס נקלט בהצלחה במערכת!";
    } else {
        $error = "קליטת הטופס נכשלה";
    }
}
?>
    <table>
        <tr>
                <div>
                    <h2 style="text-align: right;">הכנסת סקר שביעות רצון</h2>
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
                    <form action="satisfaction.php" method="post">
                        <table style="width: 100% ;">
                            <tr>
                                <td style="text-align: right;">ת.ז:</td>
                                <td><input type="number" name="id_number" id="id_number" value="" required></td>
                            </tr>
                             <tr>
                               <td style="text-align: right;">באיזו מידה הינך חש כי הפעילות עברה בצורה מקצועית?</td>
                               <td><input type="number" name="ractivities_level" id="ractivities_level" value="" required></td>                                
                            </tr>
                            <tr>
                                <td style="text-align: right;">מה מידת שביעות רצונך מהתנהלות המועדון?</td>
                               <td><input type="number" name="management_level" id="management_level" value="" required></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">באיזו מידה הינך שבע רצון מציוד המועדון?</td>
                                <td><input type="number" name="gear_level" required value=""></td>
                            </tr>
                        
                            <tr>
                                <td style="text-align: right;">באיזו מידה הינך שבע רצון מזמני ההמתנה במועדון?</td>
                                <td><input type="number" name="wating_level" required value=""></td>
                             </tr>
                             <tr>
                                <td style="text-align: right;">מה מידת שביעות רצונך מצוות המועדון?</td>
                                <td><input type="number" name="crew_level" required value=""></td>
                            </tr>
                                <td >&nbsp;</td>
                            </tr>
                        </table>
                        <div style="text-align:center;">
						    <input type="submit" name="satisfaction" class="button" value="שליחה" >
						</div>
                    </form>
                </div>
            </td>
        </tr>
    </table>
<?php
include 'views/footer.php';

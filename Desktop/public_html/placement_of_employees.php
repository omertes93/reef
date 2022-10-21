<?php
session_start();
include "include/helper.php";
include 'include/db.inc.php';
if( !isLogin() ||  getRoleId() == 4  ){
    header('location:index.php');
    exit;
}
include 'views/header.php';



$sunday_date = get_first_day_date( true );
$saturday_date = get_last_day_date(true);
$success = null;
$error = null;


if( isset( $_REQUEST['approved'] ) ) {
	// לפני פרסום סידור העבודה יש לוודא שלכל משמרת משובץ עובד
    $select = "SELECT * FROM `schedules` WHERE `employee_id` IS NULL AND `date_at`>='$sunday_date' AND `date_at`<='$saturday_date'";
    $results = $conn->query( $select );
    if( $results->num_rows === 0 ) {
        $update = "UPDATE `schedules` SET `is_approved`=1 WHERE `employee_id` IS NOT NULL AND `is_approved`=0 AND `date_at`>='$sunday_date' AND `date_at`<='$saturday_date'";
        $conn->query($update);
        header('location:working_arrangement.php?next_week=1');
        exit;
    } else {
        $error = "יש לשבץ את כל המשמרות";
    }
}

// שיבוץ עובד לפעילות מסויימת
if( isset($_REQUEST['assign_employee'])) {
     $schedule_id = $_REQUEST['schedule_id'];
     echo $employee_id = $_REQUEST['employee_id'];
    if( $employee_id != 0 ) {
        $update = "UPDATE `schedules` SET `employee_id`=$employee_id WHERE `id`=$schedule_id";
        $conn->query( $update );
    } else {
        $error = "נא לבחור עובד/ת";
    }

}

if( isset($_REQUEST['cancel_employee_assignment'])) {
    $schedule_id = $_REQUEST['schedule_id'];
    $update = "UPDATE `schedules` SET `employee_id`=NULL, `is_approved`=0 WHERE `id`=$schedule_id";
    $conn->query( $update );
}


// בוחרים את כל הפעילויות של השבוע הבא
$sql = "SELECT `schedules`.*, `courses`.`name` AS `course_name` 
        FROM `schedules` LEFT JOIN `courses`
        ON `schedules`.`course_id`=`courses`.`id`
        WHERE `date_at`>='$sunday_date' AND `date_at`<='$saturday_date' ORDER BY `schedules`.`date_at`, `schedules`.`start_at`, `schedules`.`id`";
$results = $conn->query($sql);

$display_sunday_date = date('d/m/Y', strtotime($sunday_date)); // change from Y-m-d to d-m-Y
$display_saturday_date = date('d/m/Y', strtotime($saturday_date)); // change from Y-m-d to d-m-Y
?>
<table style="width: 100%;">
    <tr>
        <td style="width: 25%;vertical-align: top;">
            <?php
            include "views/sidenav.php";
            ?>
        </td>
        <td style="width: 75%;border: 3px solid; text-align:center;">
            <h1>שיבוץ עובדים למשמרות</h1>
            <br>
            <h3>שבוע:
                <?php echo $display_saturday_date . ' - ' . $display_sunday_date; ?>
            </h3>
            <?php
            if( isset( $success )) {
                echo '<p class="success">'.$success.'</p>';
            }
            if( isset( $error )) {
                echo '<p class="error">'.$error.'</p>';
            }
            ?>
            <table style="width: 100%;" border="1">
                <tr style="background-color:#FFFFF0">
                    <th style="width: 15%;">שם הפעילות</th>
                    <th style="width: 15%;">תאריך</th>
                    <th style="width: 10%;">יום</th>
                    <th style="width: 10%;">שעה</th>
                    <th style="width: 25%;">שם העובד</th>
                    <th style="width: 25%;">שבץ</th>
                </tr>
            </table>
            <?php
			// נבחר את כל העובדים הזמינים ביום זה
            // בשאילתה הפנימית נסננן עובד מסויים במידה והוא כבר משובץ לפעילות מקבילה באותו היום ובאותה השעה
            // כלומר לא ניתן לשבץ עובד לשתי פעילויות שמתקיימות באותו יום ושעה
            while( $schedule = $results->fetch_assoc() ) {
                 $employee_id = $schedule['employee_id'];
                 $date_at = $schedule['date_at'];
                $start_at = $schedule['start_at'];

                // אם משובץ עובד לפעילות מסויימת, אז בכל מקרה שולפים את כל העובדים הזמינים בתאריך של הפעילות
                if( isset($employee_id )) {
                    $select = "SELECT `employees`.* FROM `employees` 
                           LEFT JOIN `working_days` ON `employees`.`id`=`working_days`.`employee_id`
                           WHERE `working_days`.`date`='$date_at' AND `employees`.`role_id` !=1 AND `employees`.`role_id` !=4 ";
                } else {
                    // אם לא משובץ עובד אז נוסיף את השאילתה הפנימית בכדי לסנן את העובד במידה  והוא משובץ לפעילות אחרת באותו יום ושעה
                    // echo "NULL";
                    $select = "SELECT `employees`.* FROM `employees` 
                           LEFT JOIN `working_days` ON `employees`.`id`=`working_days`.`employee_id`
                           WHERE `working_days`.`date`='$date_at' AND `employees`.`role_id` !=1 AND `employees`.`role_id` !=4";
                


                }
                $employeeResults = $conn->query($select);

                ?>
                <form action="placement_of_employees.php" method="post">
                    <input type="hidden" name="schedule_id" value="<?php echo $schedule['id'];?>">
                    <table style="width: 100%;" border="1">
                        <tr>
                            <td style="width: 15%;"><?php echo $schedule['course_name'];?></td>
                            <td style="width: 15%;"><?php echo $date_at;?></td>
                            <td style="width: 10%;">
                                <?php
                                $weekday = get_date_number($schedule['date_at']);
                                echo $days[$weekday];
                                ?>
                            </td>
                            <td style="width: 10%;"><?php echo get_hour_format($start_at);?></td>
                            <td style="width: 25%;">

         <select name="employee_id">

                                <?php 

                                 while($row = mysqli_fetch_array($employeeResults))
     {
        // print_r($row); 

        ?> 


                                    <option value="0">בחר/י</option>
                                    <?php


                                         
                                         if( $employee_id == $row['id']) { ?>
                                            <option value="<?php echo $row['id']?>" selected="selected"><?php echo $row['name'];?></option>
                                        <?php
                                     } else { ?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
                                        <?php
                                         }
                                    
                                    ?>


     <?php } 
      ?>
                                      </select>

                                <!-- <select name="employee_id">
                                    <option value="0">בחר/י</option>
                                    <?php


                                    // $employee = $employeeResults->fetch_assoc();
                                    // // print_r( $employee );

                                    // while( $employee = $employeeResults->fetch_assoc() ) {
                                         
                                    //      if( $employee_id == $employee['id']) { ?>
                                    //         <option value="<?php echo $employee['id_number']?>" selected="selected"><?php echo $employee['name'];?></option>
                                    //     <?php
                                    //  } else { ?>
                                    //         <option value="<?php echo $employee['id_number']?>"><?php echo $employee['name'];?></option>
                                    //     <?php
                                    //      }
                                    // }
                                    ?>
                                </select> -->
                            </td>
                            <td style="width: 25%;">
                                <?php
								// אם עובד כבר שובץ לפעילות הזו אז להציג כפתור "ביטול שיבוץ" 
                                if( isset( $schedule['employee_id'] ) && is_numeric( $schedule['employee_id'])) { ?>
                                    <button type="submit" name="cancel_employee_assignment" class="button warning">ביטול שיבוץ</button>
                                <?php
                                    // אחרת להתיג כפתור "שבץ"
                                } else { ?>
                                    <button type="submit" name="assign_employee" class="button success">שיבץ</button>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </form>
            <?php
            }
            ?>
            <br>
            <a href="placement_of_employees.php?approved=1" class="button">אישור המשמרות</a>
        </td>
    </tr>
</table>
<br>
<?php
include 'views/footer.php';

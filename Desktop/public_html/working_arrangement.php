<?php
session_start();
include 'include/db.inc.php';
include 'include/helper.php';

if( !isLogin() ){
    header('location:index.php');
    exit;
}


if( isset( $_REQUEST['next_week'])) {
    $sunday_date = get_first_day_date( true );
    $saturday_date = get_last_day_date( true );
} else {
    $sunday_date = get_first_day_date( false );
    $saturday_date = get_last_day_date( false );
}

// נבחר את כל הפעליויות של השבוע הנוכחי אשר משובצות להן מדריך
$sql = "SELECT `schedules`.*, `courses`.`name` AS `course_name`, `employees`.`name` AS `employee_name` FROM `schedules` 
        LEFT JOIN `courses` ON `schedules`.`course_id`=`courses`.`id`
        LEFT JOIN `employees` ON `schedules`.`employee_id`=`employees`.`id`
        WHERE `date_at`>='$sunday_date' AND `date_at`<='$saturday_date' AND `employee_id` IS NOT NULL AND `is_approved`=1
        ORDER BY `schedules`.`date_at`, `schedules`.`start_at`";
$results = $conn->query($sql);
$schedules = $results->fetch_all( MYSQLI_ASSOC );
$display_sunday_date = date('d/m/Y', strtotime($sunday_date)); // change from Y-m-d to d-m-Y
$display_saturday_date = date('d/m/Y', strtotime($saturday_date)); // change from Y-m-d to d-m-Y
include 'views/header.php';
?>
<table  style="width: 100%;">
    <tr>
        <td style="width: 25%; vertical-align: top;">
            <?php
            include "views/sidenav.php";
            ?>
        </td>
        <td style="width: 75%;border: 3px solid; text-align:center;">
            <h1>סידור עבודה</h1>
            <br>
            <h3>שבוע:
                <?php echo $display_saturday_date . ' - ' . $display_sunday_date; ?>
            </h3>

            <table border="1" style="width: 100%;">
                <tr style="background-color:#FFFFF0">
                    <th style="width: 14.2857%;">
                        ראשון
                        <?php echo substr($display_sunday_date, 0, 5);?>
                    </th>
                    <th style="width: 14.2857%;">
                        שני
                        <?php
                        $display_next_date = date('d/m', strtotime($sunday_date ." +1 day"));
                        echo $display_next_date;
                        ?>
                    </th>
                    <th style="width: 14.2857%;">שלישי
                        <?php
                        $display_next_date = date('d/m', strtotime($sunday_date ." +2 day"));
                        echo $display_next_date;
                        ?>
                    </th>
                    <th style="width: 14.2857%;">רביעי
                        <?php
                        $display_next_date = date('d/m', strtotime($sunday_date ." +3 day"));
                        echo $display_next_date;
                        ?>
                    </th>
                    <th style="width: 14.2857%;">חמישי
                        <?php
                        $display_next_date = date('d/m', strtotime($sunday_date ." +4 day"));
                        echo $display_next_date;
                        ?>
                    </th>
                    <th style="width: 14.2857%;">שישי
                        <?php
                        $display_next_date = date('d/m', strtotime($sunday_date ." +5 day"));
                        echo $display_next_date;
                        ?>
                    </th>
                    <th style="width: 14.2857%;">שבת
                        <?php
                        $display_next_date = date('d/m', strtotime($sunday_date ." +6 day"));
                        echo $display_next_date;
                        ?>
                    </th>
                </tr>
                <?php
                // אם לא בוצע שיבוץ עדיין להציג הודעה שהשיבוץ עדיין לא בוצע
                if( sizeof( $schedules ) === 0 ) {
                    echo '<tr><th colspan="7">טרם בוצע שיבוץ</th></tr>';
                } else {
                    ?>
                    <tr style="vertical-align: top;">
                        <?php
                        for( $i = 0; $i < 7; $i++ ) { ?>
                            <td>
                                <?php
                                $day_date = date('Y-m-d', strtotime($sunday_date ." +$i day"));
                                foreach ($schedules as $scl ) {
                                    if( $scl['date_at'] == $day_date ) {
                                        $start_at = get_hour_format($scl['start_at']);
                                        echo '<div style="border-bottom: 1px solid grey; margin-bottom: 10px;">'.$scl['employee_name'] . ' - ' . $scl['course_name'].' ('.$start_at.')</div>';
                                    }
                                }
                                ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>
            </table>
            <br>
            <div>
                <?php
                if( isset( $_REQUEST['next_week'])) { ?>
                    <a href="working_arrangement.php" class="button">צפיה במשמרות של השבוע הנוכחי</a>
                    <?php
                } else { ?>
                    <a href="working_arrangement.php?next_week=1" class="button">צפיה במשמרות של שבוע הבא</a>
                <?php
                }
                ?>
            </div>
        </td>
    </tr>
</table>
<br>
<?php
include 'views/footer.php';


<?php
session_start();
include 'include/helper.php';
include 'include/db.inc.php';

if( !isLogin() || getRoleId() == 3 ){
    header('location:index.php');
    exit;
}
$is_participants_reports = true;

$year = 2020;
if( isset( $_REQUEST['display_chart'])) {
    $year = $_REQUEST['year'];
}
// מספר משתתפים בכל חודש
$participants_data = array(
        1 => array( 'number' => 0, 'month' => 'ינואר') ,
        2 => array( 'number' => 0, 'month' => 'פברואר'),
        3 => array( 'number' => 0, 'month' => 'מרץ'),
        4 => array( 'number' => 0, 'month' => 'אפריל'),
        5 => array( 'number' => 0, 'month' => 'מאי'),
        6 => array( 'number' => 0, 'month' => 'יוני'),
        7 => array( 'number' => 0, 'month' => 'יולי'),
        8 => array( 'number' => 0, 'month' => 'אוגוסט'),
        9 => array( 'number' => 0, 'month' => 'ספטמבר'),
        10 => array( 'number' => 0, 'month' => 'אוקטובר'),
        11 => array( 'number' => 0, 'month' => 'נובמבר'),
        12 => array( 'number' => 0, 'month' => 'דצמבר')
);
// נבחר את כל הפעילויות שהיו בשנה מסויימת
// לכל פעילות אנו מבקשים את ה id ואת החודש בה היא הייתה
$schedules_result = $conn->query("SELECT `id`, MONTH(`date_at`) AS `month` FROM `schedules` WHERE YEAR(`date_at`)=$year ORDER BY MONTH(`date_at`)");
// רצים בלולאה על כל הפעילויות
while( $schedule = $schedules_result->fetch_assoc() ) {
    $schedule_id = $schedule['id'];
    $month = $schedule['month'];
    // סופרים את מספר הנרשמים לכל פעילות
    $count_result = $conn->query("SELECT COUNT(`id`) AS participant_number FROM `customers_schedules` WHERE `schedule_id`=$schedule_id");
    $row = $count_result->fetch_assoc();
    // מוסיפים את מספר המשתתפים בפעילות לחודש בה היא מתקיימת.
    $participants_data[$month]['number'] += $row['participant_number'];
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
                <h1>דו"חות</h1>
                <h2>דו"ח משתתפים בפעילויות</h2>
                <form action="reports_participants.php" method="get">
                    <table>
                        <tr>
                            <td>
                                <select name="year">
                                    <option value="0">בחר שנה</option>
                                    <option value="2020" <?php if( $year == 2020 ){ echo ' selected="selected"'; }?>>2020</option>
                                    <option value="2021" <?php if( $year == 2021 ){ echo ' selected="selected"'; }?>>2021</option>
                                    <option value="2022" <?php if( $year == 2022 ){ echo ' selected="selected"'; }?>>2022</option>
                                </select>
                            </td>
                            <td>
                                <input type="submit" class="button" name="display_chart" value="הצג">
                            </td>
                        </tr>
                    </table>
                </form>
                <br>
                <div id="top_x_div" style="width: 800px; height: 600px; direction: ltr"></div>
            </td>
        </tr>
    </table>
	<br>
<?php
include 'views/footer.php';


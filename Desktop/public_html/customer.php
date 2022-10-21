<?php
session_start();
include "include/helper.php";
include 'include/db.inc.php';
// בדיקת התחברות של המשתמש
if( !isLogin() ){
    header('location:index.php');
    exit;
}

// בדיקה האם ת.ז של הלקוח קיימת בבסיס הנתונים
if( !isset($_SESSION['customer_id']) ){
    header('location:customers.php');
    exit;
}


$customer_id = $_SESSION['customer_id'];
$tab_id = 1;
// או מטופס החיפוש או מהקישור "הירשם"
if( isset($_REQUEST['tab_id']) ){
    $tab_id = $_REQUEST['tab_id'];
}

/****************** פרטים אישיים ***************/
// update_customer
if( isset( $_REQUEST['update_customer']) ) {
    $name = $_REQUEST['name'];
    $id_number = $_REQUEST['id_number'];
    $date_of_birth = $_REQUEST['date_of_birth'];
    $gender = $_REQUEST['gender'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $city = $_REQUEST['city'];
    $address = $_REQUEST['address'];
    $insurance = $_REQUEST['insurance'];
    $level_id = $_REQUEST['level_id'];
    $height = $_REQUEST['height'];
    $weight = $_REQUEST['weight'];
    $suit_size_id = $_REQUEST['suit_size_id'];
    $update = "UPDATE `customers` SET `name`='$name', 
                                      `date_of_birth`='$date_of_birth',  
                                      `id_number`='$id_number', 
                                      `gender`=$gender, 
                                      `email`='$email', 
                                      `phone`='$phone', 
                                      `city`='$city', 
                                      `address`='$address', 
                                      `insurance`=$insurance,
                                      `level_id`=$level_id,
                                      `height`=$height,
                                      `weight`=$weight,
                                      `suit_size_id`=$suit_size_id
                                      WHERE `id`=$customer_id";
    $conn->query( $update );
    $personal_info_updated = true;
}

if( isset( $_REQUEST['delete_customer']) ) {
    $conn->query( "UPDATE `boards` SET `customer_id`=NULL WHERE `customer_id`=$customer_id");
    $conn->query( "UPDATE `suits` SET `customer_id`=NULL WHERE `customer_id`=$customer_id");
    $conn->query( "DELETE FROM `customers_schedules` WHERE `customer_id`=$customer_id");
    $conn->query( "DELETE FROM `customers` WHERE `id`=$customer_id");
    $_SESSION['customer_deleted'] = true;
    header('location:customers.php');
    exit;
}

$result = $conn->query("SELECT * FROM `customers` WHERE `id`=$customer_id");
$customer = $result->fetch_array(MYSQLI_ASSOC);


/****************** פעילויות לקוח ***************/
// בדיקה האם המשתמש לחץ על הקישור "הירשם" לפעילות מסוימת

if( isset($_REQUEST['action'] ) && $_REQUEST['action'] == 'register' ){
    $schedule_id = $_REQUEST['schedule_id'];
	// בדיקה האם הלקוח כבר נרשם בעבר לפעילות וביטל אותה. במידה וכן צריך לבטל את הביטול כלומר is_cancelled=0

    $result = $conn->query("SELECT * FROM `customers_schedules` WHERE `customer_id`=$customer_id AND `schedule_id`=$schedule_id AND `is_cancelled`=1");
    if( $result->num_rows === 1 ) {
        $conn->query("UPDATE `customers_schedules` SET `is_cancelled`=0 WHERE `customer_id`=$customer_id AND `schedule_id`=$schedule_id");
    } else {
        $conn->query("INSERT INTO `customers_schedules` (`customer_id`, `schedule_id` ) VALUES($customer_id, $schedule_id)");
    }
    header('location:customer.php?tab_id=3' );
}
if( isset( $_REQUEST['search_activities']) ) {
    $course_id = $_REQUEST['course_id'];
    $date_at = $_REQUEST['date_at'];
    $result = $conn->query("SELECT * FROM `courses` WHERE `id`=$course_id");
    $searched_course = $result->fetch_array(MYSQLI_ASSOC );// first row
    $max_participants = $searched_course['max_participants'];

    // שאילתה לקבלת פעילות של קורס מסויים ובתאריך ספציפי.
	// נחפש את כל הפעילויות שנקבע להם מדריך
    // `schedules`.`employee_id`!='NULL'
	// נחפש את כל הפעילויות שהלקוח לא רשום אליהם

    $sql = "SELECT `schedules`.*, `employees`.`name`
            FROM `schedules` LEFT JOIN `employees`
            ON `schedules`.`employee_id`=`employees`.`id`
            WHERE `schedules`.`course_id`=$course_id AND
                  `schedules`.`date_at`='$date_at' AND
                  `schedules`.`employee_id`!='NULL' AND `schedules`.`is_approved`=1
                   AND `schedules`.`id` NOT IN ( SELECT `schedule_id` FROM `customers_schedules` WHERE `customer_id`=$customer_id AND `is_cancelled`=0 )  ";
    // אם תאריך החיפוש הוא של היום, כלומר הלקוח רוצה להירשם לפעילות שתתקיים ביום הנוכחי - אז צריך לבחור את כל הפעילויות שהן אחרי השעה הנוכחית.
    if( $date_at === date('Y-m-d') ) {
        $current_hour = date('H');// השעה הנוכחית
        $sql .= " AND `schedules`.`start_at` > $current_hour";
    }
    // נקבל את כל הפעילויות הזמינות בתאריך מסויים ולפי סוג הפעילות שנבחר. נוודא שלאותה פעילות נקבע מדריך
    // הלקוח כבר לא רשום לפעילות זו (מיושם ב SELECT הפנימי)
    $result = $conn->query( $sql );

    // המערך בו נשמור באופן סופי את כל הפעילויות שהמשתמש יכול להירשם אליהן
    $available_activities = array();
    // בשלב הבא יש לעבור על כל הפעילויות שהתקבלו עד כה, ולוודא שעדיין יש בהן מקום על סמך השדה max_participants שבטבלה activities
    while( $activity = $result->fetch_array(MYSQLI_ASSOC)) {
        $schedule_id = $activity['id'];
		// נחפש כמה לקוחות נרשמו לאותה פעילות
        $result2 = $conn->query("SELECT COUNT('id') FROM `customers_schedules` WHERE `schedule_id`=$schedule_id AND `is_cancelled`=0");
        $customers_schedules_row = $result2->fetch_array();
        $activity['registered_customers'] = $customers_schedules_row[0];
		// נבדוק שמספר הלקוחות הרשומים קטן מהמספר המקסימלי
        if( $customers_schedules_row[0] < $max_participants ) {
            $available_activities[] = $activity;
        }
    }
}

if( isset($_REQUEST['action'] ) && $_REQUEST['action'] == 'cancel_activity' ){
    $customer_schedule_id = $_REQUEST['customer_schedule_id'];
    $conn->query("UPDATE `customers_schedules` SET `is_cancelled`=1 WHERE `id`=$customer_schedule_id");
    $_SESSION['schedule_cancelled'] = true;
    header('location:customer.php?tab_id=3' );
    exit;
}

/******************  התאמת גלשן ***************/
// לפני שנבצע התאמת גלשן צריך לבדוק אם יש ללקוח גלשן מהטאב השכרת ציוד ללקוח
$result = $conn->query( "SELECT * FROM `boards` WHERE `customer_id`=$customer_id" );
$customer_already_have_board = false;

if( $result->num_rows === 1 ) {
    $customer_already_have_board = true;
}

$match_array = array(
        [ 'min_weight' => 0, 'max_weight' => 45, 'board_min_width' => 48, 'board_min_thickness' => 5.7 ],
        [ 'min_weight' => 46, 'max_weight' => 55, 'board_min_width' => 48, 'board_min_thickness' => 6.5 ],
        [ 'min_weight' => 56, 'max_weight' => 65, 'board_min_width' => 49.5, 'board_min_thickness' => 7 ],
        [ 'min_weight' => 66, 'max_weight' => 85, 'board_min_width' => 54, 'board_min_thickness' => 7.5 ],
        [ 'min_weight' => 86, 'max_weight' => 300, 'board_min_width' => 81, 'board_min_thickness' => 9 ]
);
define('MAX_WIDTH_SCORE', 30 );
define('MAX_HEIGHT_SCORE', 30 );
define('MAX_THICKNESS_SCORE', 40 );
if( getRoleId() != 4 ) {
	
// האלגוריתם מבתסס על המידע בקישור הבא:
// http://topsea.co.il/board.htm
    if (isset($_REQUEST['match_board'])) {
        $c_height = $customer['height']; 
        $c_weight = $customer['weight']; 
        $board_height_required = $c_weight + 25;

        $board_width_required = 0;
        $board_thickness_required = 0;
        foreach ($match_array as $match_row) {
            if ($c_weight >= $match_row['min_weight'] && $c_weight <= $match_row['max_weight']) {
                $board_width_required = $match_row['board_min_width'];
                $board_thickness_required = $match_row['board_min_thickness'];
                break;
            }
        }
		// כל הלגשנים מיועדים לגולשים מתחילים
        // אלו גלשני soft
		// הגלשנים תקינים ולא נמצאים אצל לקוח אחר
        // בנוסף הם עומדים במינימום דרישות של רוחב אורך ועובי

        $match_query = "SELECT DISTINCT * FROM `boards` WHERE 
                            `board_type_id`=1 AND 
                            `customer_id` IS NULL AND 
                            `condition`=1 AND 
                            `length`>=$board_height_required AND
                            `width`>=$board_width_required AND 
                            `thickness`>=$board_thickness_required
                            GROUP BY `length`, `width`, `thickness`";
        $soft_board_result = $conn->query($match_query);
		// המערך יכיל את כל הגלשנים שבמלאי אשר עונים על התנאים ולכל גלשן יינתן ציון

        $match_score = array();

        $max_board_height = 0;
        $max_board_width = 0;
        $max_board_thickness = 0;
        while ($soft_board = $soft_board_result->fetch_assoc()) {
            if ($soft_board['length'] > $max_board_height) {
                $max_board_height = $soft_board['length'];
            }
            if ($soft_board['width'] > $max_board_width) {
                $max_board_width = $soft_board['width'];
            }
            if ($soft_board['thickness'] > $max_board_thickness) {
                $max_board_thickness = $soft_board['thickness'];
            }
            // מוסיפים שדה של score השוה ל-0
            $soft_board['score'] = 0;
            // מוסיפים את הגלשן למערך של התוצאות הסופיות
            $match_score[] = $soft_board;
        }

        for ($i = 0; $i < sizeof($match_score); $i++) {
            /*$match_score[$i]['score'] += (MAX_THICKNESS_SCORE * $match_score[$i]['thickness']/$max_board_thickness);
            $match_score[$i]['score'] += (MAX_WIDTH_SCORE * $match_score[$i]['width']/$max_board_width);
            $match_score[$i]['score'] += (MAX_HEIGHT_SCORE * $match_score[$i]['length']/$max_board_height);*/

            $match_score[$i]['score'] += (10 + ((MAX_THICKNESS_SCORE - 10) * $match_score[$i]['thickness'] / $max_board_thickness));
            $match_score[$i]['score'] += (10 + ((MAX_WIDTH_SCORE - 10) * $match_score[$i]['width'] / $max_board_width));
            $match_score[$i]['score'] += (10 + ((MAX_HEIGHT_SCORE - 10) * $match_score[$i]['length'] / $max_board_height));

            $match_score[$i]['score'] = round($match_score[$i]['score'], 0);
        }
        usort($match_score, function ($a, $b) {
            return $b['score'] - $a['score'];
        });
    }

// do match of board to a customer
    if (isset($_REQUEST['do_match'])) {
        echo "Do match";
        $board_id = $_REQUEST['board_id'];
        $conn->query("UPDATE `boards` SET `customer_id`=$customer_id, `number_of_rents`=`number_of_rents`+1, `time_borrowed`=CURRENT_TIMESTAMP(), `time_returned`=NULL WHERE `id`=$board_id");
        // אחרי בחירת גלשן לגולש - מפנים אותו לטאב של הציוד
        header('location:customer.php?tab_id=4');
        exit;
    }
}


/* השכרת ציוד ללקוח */

// חיפוש גלשנים לפי סוג
if( isset( $_REQUEST['search_boards'])) {
    $board_type_id = $_REQUEST['board_type_id'];
    $sql = "SELECT DISTINCT * FROM `boards` 
            WHERE `board_type_id`=$board_type_id AND 
            `customer_id` IS NULL 
            AND `condition`=1
            GROUP BY `length`, `width`, `thickness`";
    $search_boards_results = $conn->query( $sql );
}
// כאשר הלקוח בוחר גלשן
// כאשר נמצאים במסך ציוד
if( isset($_REQUEST['action'] ) && $_REQUEST['action'] == 'choose_board' ){
    $board_id = $_REQUEST['board_id'];
    $conn->query("UPDATE `boards` SET `customer_id`=$customer_id, `number_of_rents`=`number_of_rents`+1, `time_borrowed`=CURRENT_TIMESTAMP(), `time_returned`=NULL WHERE `id`=$board_id");
    header('location:customer.php?tab_id=4');
}

// החזרת גלשן תקין/לא תקין
if( isset( $_REQUEST['return_board'] )) {
    $condition = $_REQUEST['return_board'];
    $board_id = $_REQUEST['board_id'];
    $sql = "UPDATE `boards` SET `customer_id`=NULL, `condition`=$condition, `time_borrowed`=NULL, `time_returned`=CURRENT_TIMESTAMP() WHERE `id`=$board_id";
    $conn->query($sql);
    header('location:customer.php?tab_id=4');
}


// חיפוש חליפות על פי מין ומידה
if( isset( $_REQUEST['search_suits'])) {
    $gender = $_REQUEST['gender'];
    $size_id = $_REQUEST['size_id'];
    $sql = "SELECT DISTINCT `suits`.*, `suits_sizes`.`size_name` 
            FROM `suits` LEFT JOIN `suits_sizes`
            ON `suits`.`size_id`=`suits_sizes`.`id`
            WHERE `gender`=$gender AND 
            `size_id`=$size_id AND 
            `customer_id` IS NULL
            GROUP BY `suits`.`brand`, `suits`.`size_id`";
    $search_suits_results = $conn->query($sql);
}

// כאשר הלקוח בוחר חליפת גלישה
if( isset($_REQUEST['action'] ) && $_REQUEST['action'] == 'choose_suit' ){
    $suit_id = $_REQUEST['suit_id'];
    $conn->query("UPDATE `suits` SET `customer_id`=$customer_id, `time_borrowed`=CURRENT_TIMESTAMP() WHERE `id`=$suit_id");
    header('location:customer.php?tab_id=4');
}

// החזרת חליפה תקינה/לא תקינה
if( isset( $_REQUEST['return_suit'] )) {
    $condition = $_REQUEST['return_suit'];
    $suit_id = $_REQUEST['suit_id'];
    $sql = "UPDATE `suits` SET `customer_id`=NULL, `condition`=$condition, `time_borrowed`=NULL, `time_returned`=CURRENT_TIMESTAMP() WHERE `id`=$suit_id";
    $conn->query($sql);
    header('location:customer.php?tab_id=4');
}


include 'views/header.php';
?>
    <table>
        <tr>
            <td style="width: 25%; vertical-align: top;height:700px">
                <?php
                include "views/sidenav.php";
                ?>
            </td>
			<td>&nbsp </td>
            <td style="width: 75%; position: relative;">
                <div class="tabs-links">
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <a class="tab-link<?php if($tab_id==1){ echo ' tab-links-active';}?>" id="1" onclick="displayTab(1)">פרטים אישיים</a>
                            </td>
                            <?php
                            if( $customer['level_id'] == 1 && getRoleId() != 4 ) {
                                ?>
                                <td>
                                    <a class="tab-link<?php if($tab_id==2){ echo ' tab-links-active';}?>" id="2" onclick="displayTab(2)">התאמת גלשן</a>
                                </td>
                            <?php
                            }
                            ?>
                            <td>
                                <a class="tab-link<?php if($tab_id==3){ echo ' tab-links-active';}?>" id="3" onclick="displayTab(3)">פעילויות לקוח</a>
                            </td>
                            <td>
                                <a class="tab-link<?php if($tab_id==4){ echo ' tab-links-active';}?>" id="4" onclick="displayTab(4)">השכרת ציוד לקוח</a>
                            </td>
                            <td>
                                <a class="tab-link<?php if($tab_id==5){ echo ' tab-links-active';}?>" id="5" onclick="displayTab(5)">סקר שביעות רצון</a>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php
                // **** TAB 1 *****
                include "views/customer/personal_info.php";
                ?>
                <?php
                // **** TAB 2 *****
                if( $customer['level_id'] == 1 && getRoleId() != 4 ) {
                    include "views/customer/board_match.php";
                }
                ?>
                <?php
                // **** TAB 3 *****
                include "views/customer/customer_activities.php";
                ?>
                <?php
                // **** TAB 4 *****
                include "views/customer/equipment.php";
                ?>
                <?php
                // **** TAB 5 *****
                include "views/customer/satisfaction.php";
                ?>
            </td>
        </tr>
    </table>
<?php
include 'views/footer.php';

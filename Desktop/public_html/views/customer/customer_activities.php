<div class="tab" data-tab_id="3" <?php if($tab_id == 3 ) { echo ' style="display:block;"';}?>>
	<h2>רישום לקוח/ה לפעילות</h2>
	<br>
    <h3>שם הלקוח/ה :<?php echo $customer['name'];?></h3>
	<br>
    <?php
    // אנו מאפשרים לרשום לקוח לפעילות רק אם יש לו ביטוח בתוקף
    if($customer['insurance'] == 1 ) {
        ?>
        
        <?php
        $result = $conn->query("SELECT * FROM `courses`");
        ?>
        <form action="customer.php" method="post">
            <table>
                <tr>
                    <td>
                        <select name="course_id">
                            <option value="0">שם הפעילות</option>
                            <?php
                            while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="date" name="date_at" min="<?php echo date('Y-m-d');?>"></td>
                    <td>
                        <input type="submit" class="button" name="search_activities" value="חיפוש">
                        <input type="hidden" name="tab_id" value="3">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_REQUEST['search_activities'])) {
            ?>
            <p>
                תוצאות עבור קורס:
                <strong><?php echo $searched_course['name'] ?></strong>,
                בתאריך:
                <strong><?php echo $date_at; ?></strong>
            </p>
            <?php
            // בודקים אם נמצאו פעילויות לקורס והתאריך שנבחרו.
            // אם יש אז מציגים אותן בטבלה
            if (sizeof($available_activities) > 0) {
                ?>
                <table style="width: 100%;" border="1">
                    <tr>
                        <th>מספר סידורי</th>
                        <th>מס' משתתפים מקס'</th>
                        <th>מס' משתתפים רשומים</th>
                        <th>מדריך/ה</th>
                        <th>מחיר</th>
                        <th>שעה</th>
                        <th>הירשם</th>
                        <?php
                        $counter = 1;
                        foreach ($available_activities as $activity) { ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $searched_course['max_participants']; ?></td>
                        <td><?php echo $activity['registered_customers']; ?></td>
                        <td><?php echo $activity['name']; ?></td>
                        <td><?php echo $searched_course['price']; ?></td>
                        <td><?php echo $activity['start_at']; ?></td>
                        <td>
                            <a href="customer.php?action=register&schedule_id=<?php echo $activity['id']; ?>&tab_id=3"
                               class="button">הירשם</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tr>

                </table>
				
                <?php
            } else {
                echo '<p><strong>לא נמצאו פעילויות לתאריך זה.</strong></p>';
            }
        }



        $current_hour = date('H');// השעה הנוכחית
        // קבלת כל הפעילויות העתידיות שהמשתמש רשום אליהם
        // אם התאריך של הפעילות הוא של היום, אז אנו בודקים את השעה ושולפים את כל הפעילויות המאוחרות מהשעה הנוכחית
        $sql = "SELECT `schedules`.*, `customers_schedules`.`id` AS `customer_schedule_id`
                            FROM `customers_schedules` 
                            LEFT JOIN `schedules` ON `customers_schedules`.`schedule_id`=`schedules`.`id`
                            WHERE `customers_schedules`.`customer_id`=$customer_id AND 
                                  ( `schedules`.`date_at` > CURDATE() OR (`schedules`.`date_at`=CURDATE() AND `schedules`.`start_at` > $current_hour)) AND 
                                  `customers_schedules`.`is_cancelled`=0";
        $result_future = $conn->query($sql);
        ?>
		<br>
        <h2>פעילויות אליהן הלקוח/ה רשום/ה</h2>
        <?php
        if( isset( $_SESSION['schedule_cancelled'] )) {
            echo '<p class="success">הפעילות בוטלה בהצלחה!</p>';
            unset($_SESSION['schedule_cancelled'] );
        }
        ?>
        <table style="width: 100%;" border="1">
            <tr>
                <th>#</th>
                <th>שם הפעילות</th>
                <th>מספר הקורס</th>
                <th>מדריך/ה</th>
                <th>מחיר</th>
                <th>תאריך</th>
                <th>שעה</th>
                <th>ביטול</th>
            </tr>
            <?php
            $counter = 1;
            // רצים בלולאה ומציגים את כולן
            while ($row = $result_future->fetch_array(MYSQLI_ASSOC)) {
                $customer_schedule_id = $row['customer_schedule_id'];
                $course_id = $row['course_id'];
                $employee_id = $row['employee_id'];
                // שולפים את הנתונים של הקורס
                $result1 = $conn->query("SELECT * FROM `courses` WHERE `id`=$course_id");
                $course = $result1->fetch_array(MYSQLI_ASSOC);
                // שולפים את הנתונים של המדריך לאותה פעילות
                $result2 = $conn->query("SELECT * FROM `employees` WHERE `id`=$employee_id");
                $employee = $result2->fetch_array(MYSQLI_ASSOC);
                ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo $course['name']; ?></td>
                    <td><?php echo $course['course_number']; ?></td>
                    <td><?php echo $employee['name']; ?></td>
                    <td><?php echo $course['price']; ?></td>
                    <td><?php echo $row['date_at']; ?></td>
                    <td><?php echo $row['start_at']; ?></td>
                    <td>
                        <a class="button warning"  onclick="return confirm('האם את/ה בטוח/ה ?')" href="customer.php?action=cancel_activity&customer_schedule_id=<?php echo $customer_schedule_id;?>" ">ביטול</a>
                    </td>
                </tr>
                <?php
            }
            if ($counter === 1) { ?>
                <tr>
                    <td colspan="8" style="text-align: center;"><strong>לא נמצאו פעילויות</strong></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else { ?>
        <h2 class="warning" style="text-align: center;">לפני רישום לפעילות יש לחדש את הביטוח</h2>
    <?php
    }
    ?>

    <?php
    $current_hour = date('H');// השעה הנוכחית
    // מקבלים את היסטוריית הפעילויות של הלקוח
    $sql = "SELECT `schedules`.* 
                            FROM `customers_schedules` 
                            LEFT JOIN `schedules` ON `customers_schedules`.`schedule_id`=`schedules`.`id`
                            WHERE `customers_schedules`.`customer_id`=$customer_id AND (`schedules`.`date_at` < CURDATE() OR (`schedules`.`date_at`=CURDATE() AND `schedules`.`start_at` < $current_hour))";
    $result_past = $conn->query($sql);
    ?>
    <h2>היסטוריית פעילויות</h2>
    <table style="width: 100%;" border="1">
        <tr>
            <th>#</th>
            <th>שם הפעילות</th>
            <th>מספר הקורס</th>
            <th>מדריך/ה</th>
            <th>מחיר</th>
            <th>תאריך</th>
            <th>שעה</th>
        </tr>
        <?php
        $counter = 1;
        // רצים בלולאה ומציגים את כולן
        while( $row = $result_past->fetch_array(MYSQLI_ASSOC)) {
            $course_id = $row['course_id'];
            $employee_id = $row['employee_id'];
            // שולפים את הנתונים של הקורס
            $result1 = $conn->query("SELECT * FROM `courses` WHERE `id`=$course_id");
            $course = $result1->fetch_array(MYSQLI_ASSOC);
            // שולפים את הנתונים של המדריך לאותה פעילות
            $result2 = $conn->query("SELECT * FROM `employees` WHERE `id`=$employee_id");
            $employee = $result2->fetch_array(MYSQLI_ASSOC);
            ?>
            <tr>
                <td><?php echo $counter++;?></td>
                <td><?php echo $course['name'];?></td>
                <td><?php echo $course['course_number'];?></td>
                <td><?php echo $employee['name'];?></td>
                <td><?php echo $course['price'];?></td>
                <td><?php echo $row['date_at'];?></td>
                <td><?php echo $row['start_at'];?></td>
            </tr>
            <?php
        }
        if( $counter === 1 ) { ?>
            <tr>
                <td colspan="7" style="text-align: center;"><strong>לא נמצאו פעילויות קודמות</strong></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

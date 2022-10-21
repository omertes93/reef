<?php

session_start();
include "include/helper.php";
include 'include/db.inc.php';

if( !isLogin() || getRoleId() == 3 ){
    header('location:index.php');
    exit;
}

$message = null;
if( isset( $_REQUEST['add_schedule'])) {
    $course_id = $_REQUEST['course_id'];
    $date_at = $_REQUEST['date_at'];
    $start_at = $_REQUEST['start_at'];

	if ( isset( $_REQUEST['course_id'] ) && (isset( $_REQUEST['start_at'])) && $course_id !=0 && $start_at !=0 )  {

        $insert = "INSERT INTO `schedules` (`course_id`, `date_at`, `start_at`) VALUES ( $course_id, '$date_at', $start_at )";
        $conn->query( $insert );

        $message = "הפעילות נוספה בהצלחה!";
	}
    else {
		$error= "הפעילות לא נוספה למערכת, אחד מהנתונים לא תקין" ;
	}

}
$result = $conn->query("SELECT * FROM `courses`");

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
			<div style="width: 100% ;">
				<h1>הוספת פעילות חדשה</h1>
				<br>
				<?php

				if( isset( $message )) {
					echo '<p class="success">'.$message.'</p>';
				}
				
				if( isset( $error )) {
					echo '<p class="warning">'.$error.'</p>';
				}
				
				?>
				<form action="add_schedule.php" method="post" onsubmit="return validateNewScheduleData()">
					<table style="width: 85%;">
						<tr>
							<td>סוג הפעילות:</td>
							<td>
								<select name="course_id" id="course_id" >
									<option value="0">בחר/י  </option>
									<?php

									while ($row = $result->fetch_assoc()) {
										$selected = "";
										if ( isset($_REQUEST['course_id']) && $_REQUEST['course_id'] == $row['id']  ) {
											$selected = ' selected="selected"';
										}
										?>
										<option value="<?php echo $row['id'];?>"<?php echo $selected; ?>>
										<?php echo $row['name'];?>
										</option>
										<?php
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
							תאריך:
							</td>
								<td>
								<input type="date" name="date_at" min="<?php echo date('Y-m-d');?>">
								</td>
						</tr>
						<tr>
							<td>שעה:</td>
							<td>
								<select name="start_at" id="start_at">
									<option value="0">בחר/י</option>
									<option value="8">08:00</option>
									<option value="10">10:00</option>
									<option value="12">12:00</option>
									<option value="14">14:00</option>
									<option value="16">16:00</option>
								</select>
								<br>
								<br>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="add_schedule" class="button" value="הוספת פעילות"></td>
						</tr>
					</table>
				</form>
			</div>
        </td>
    </tr>
</table>
<?php
include 'views/footer.php';

<div  class="tab" data-tab_id="1" <?php if($tab_id == 1 ) { echo ' style="display:block;"';}?>>
    <h2 >עידכון פרטים אישיים</h2>
	<br>
    <h3>שם הלקוח/ה :<?php echo $customer['name'];?></h3>
	<br>
    <?php
    $levels = $conn->query("SELECT * FROM `levels`");
    $suits_sizes = $conn->query("SELECT * FROM `suits_sizes`");
    ?>
    <form action="customer.php" method="post" onsubmit="return validateCustomerData()">
        <?php
        if( isset( $personal_info_updated ) && $personal_info_updated == true ) {
            echo '<p class="success"> פרטי הלקוח/ה עודכנו בהצלחה!</p>';
        }
        ?>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left; width: 15%;">שם הגולש/ת:</td>
                <td style="width: 35%;"><input type="text" name="name" value="<?php echo $customer['name'];?>" required></td>
                <td style="text-align: left;width: 15%;">ת.ז:</td>
                <td style="width: 35%;"><input type="text" name="id_number" id="id_number" value="<?php echo $customer['id_number'];?>" required></td>
            </tr>
            <tr>
                <td style="text-align: left;">תאריך לידה:</td>
                <td><input type="date" name="date_of_birth" value="<?php echo $customer['date_of_birth'];?>" required></td>
                <td style="text-align: left;">מגדר:</td>
                <td>
                    <input type="radio" name="gender" value="1" <?php if( $customer['gender'] == 1 ){ echo 'checked="checked"';}?>> נקבה
                    <input type="radio" name="gender" value="2" <?php if( $customer['gender'] == 2 ){ echo 'checked="checked"';}?>>  זכר
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">אימייל:</td>
                <td><input type="email" name="email" value="<?php echo $customer['email'];?>" required></td>
                <td style="text-align: left;">טלפון:</td>
                <td><input type="text" name="phone" value="<?php echo $customer['phone'];?>" required></td>
            </tr>
            <tr>
                <td style="text-align: left;">עיר:</td>
                <td><input type="text" name="city" value="<?php echo $customer['city'];?>" required></td>
                <td style="text-align: left;">כתובת:</td>
                <td><input type="text" name="address" value="<?php echo $customer['address'];?>" required></td>
            </tr>
            <tr>
                <td style="text-align: left;"> מידה:</td>
                <td>
                    <select name="suit_size_id" id="suit_size_id">
                        <option value="0">בחר/י</option>
                        <?php
                        foreach ( $suits_sizes as $size ) {
                            ?>
                            <option value="<?php echo $size['id'];?>" <?php if( $customer['suit_size_id'] == $size['id']){ echo ' selected="selected"'; }?>>
                                <?php echo $size['size_name']; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
			   
			   
                <td style="text-align: left;">רמה:</td>
                <td>
                    <select name="level_id" id="level_id">
                        <option value="0">בחר/י</option>
                        <?php
                        foreach ( $levels as $level ) { ?>
                            <option value="<?php echo $level['id'];?>" <?php if( $customer['level_id'] == $level['id']){ echo ' selected="selected"'; }?>>
                                <?php echo $level['name']; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">גובה(ס"מ):</td>
                <td><input type="number" name="height" value="<?php echo $customer['height'];?>" required></td>
                <td style="text-align: left;">משקל(ק"ג):</td>
                <td><input type="number" name="weight" value="<?php echo $customer['weight'];?>" required></td>
            </tr>
            <tr>
                <td style="text-align: left;">ביטוח?:</td>
                <td>
                    <input type="radio" name="insurance" value="0" <?php if( $customer['insurance'] == 0 ){ echo 'checked="checked"';}?>> אין
                    <input type="radio" name="insurance" value="1" <?php if( $customer['insurance'] == 1 ){ echo 'checked="checked"';}?>> יש
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
				<br>
                <td>
                    <br>
				
					<a href="https://portal.malam-payroll.com/Salprd3Root/faces/login.jspx?p_index_num=6500&_adf.ctrl-state=lpugfknlv_3&_afrRedirect=6843621697104886" target="_blank">לצפיה בתלוש השכר</a>
		
				</td>
				<td>
				  <br>
                    <input type="submit" name="update_customer" class="button" value="עידכון">
                    <input type="hidden" name="tab_id" value="1">
                </td>
               
                <td >
				<br>
				<input type="submit" class="button warning" name="delete_customer" value="מחיקת משתמש" onclick="return confirm('האם את/ה בטוח/ה ?')"></td>
            </tr>
        </table>
    </form>
</div>

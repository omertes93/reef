<div class="tab" data-tab_id="4" <?php if($tab_id == 4 ) { echo ' style="display:block;"';}?>>
    <h2>השכרת ציוד ללקוח</h2>
	<br>
    <h3>שם הלקוח/ה :<?php echo $customer['name'];?></h3>
	<br>
    <?php
    $customer_id = $customer['id'];
    $sql = "SELECT `boards`.*, `board_types`.`name` 
            FROM `boards` LEFT JOIN `board_types` 
            ON `boards`.`board_type_id`=`board_types`.`id` 
            WHERE `boards`.`customer_id`=$customer_id";
    $board_results = $conn->query( $sql );
    if( $board_results->num_rows > 0 ) {
        $board = $board_results->fetch_assoc();
        ?>
        <h2>החזרת גלשן </h2>
        <table border="1" style="width: 100%;">
            <tr>
                <th>#</th>
                <th>מק"ט</th>
                <th>סוג הגלשן</th>
                <th>תאריך השאלה</th>
                <th>תקין/לא תקין</th>
            </tr>
            <tr>
                <td>1</td>
                <td><?php echo $board['id_number']; ?></td>
                <td><?php echo $board['name']; ?></td>
                <td><?php echo $board['time_borrowed']; ?></td>
                <td>
                    <a href="customer.php?tab_id=4&return_board=1&board_id=<?php echo $board['id'];?>" class="button">תקין</a>
                    <a href="customer.php?tab_id=4&return_board=0&board_id=<?php echo $board['id'];?>" class="button warning">לא תקין</a>
                </td>
            </tr>
        </table>
    <?php
    } else if( $customer['insurance'] == 1 ){
        $sql = "SELECT * FROM `board_types`";
        $board_results = $conn->query($sql);
        ?>
        <h2>השאלת גלשן </h2>
        <form action="customer.php" method="get">
            <table>
               <tr>
                   <td>
                   סוג הגלשן:
                   </td>
                   <td>
                       <select name="board_type_id">
                           <option value="0">בחר/י</option>
                       <?php
                       while ($board = $board_results->fetch_assoc() ) { ?>
                           <option value="<?php echo $board['id'];?>"><?php echo $board['name'];?></option>
                       <?php
                       }
                       ?>
                       </select>
                   </td>
                   <td>
                       <input type="submit" class="button" name="search_boards" value="חיפוש גלשן">
                       <input type="hidden" name="tab_id" value="4">
                   </td>
               </tr>

            </table>
            <br>
            <?php
            if( isset( $search_boards_results ) ) {
                $counter=1;
                ?>
                <table style="width: 100%;" border="1">
                    <tr>
                        <th>#</th>
                        <th>מק"ט</th>
                        <th>אורך</th>
                        <th>רוחב</th>
                        <th>עובי</th>
                        <th>בחר גלשן</th>
                    </tr>
                    <?php
                    while( $board = $search_boards_results->fetch_assoc() ) { ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $board['id_number'];?></td>
                            <td><?php echo $board['length'];?></td>
                            <td><?php echo $board['width'];?></td>
                            <td><?php echo $board['thickness'];?></td>
                            <td><a href="customer.php?action=choose_board&board_id=<?php echo $board['id'];?>" class="button">בחר</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </form>
    <?php
    } else { ?>
        <h2 class="warning" style="text-align: center;">לפני השאלת ציוד יש לחדש את הביטוח</h2>
    <?php
    }



    $sql = "SELECT `suits`.*, `suits_sizes`.`size_name` 
            FROM `suits` LEFT JOIN `suits_sizes`
            ON `suits`.`size_id`=`suits_sizes`.`id`
            WHERE `suits`.`customer_id`=$customer_id";
    $suits_results = $conn->query( $sql );
    if( $suits_results->num_rows > 0 ) {
        $suit = $suits_results->fetch_assoc();
        ?>
        <h2>החזרת חליפת גלישה </h2>
        <table border="1" style="width: 100%;">
            <tr>
                <th>#</th>
                <th>מק"ט</th>
                <th>מותג</th>
                <th>מידה</th>
                <th>תאריך השאלה</th>
                <th>תקין/לא תקין</th>
            </tr>
            <tr>
                <td>1</td>
                <td><?php echo $suit['id_number']; ?></td>
                <td><?php echo $suit['brand']; ?></td>
                <td><?php echo $suit['size_name']; ?></td>
                <td><?php echo $suit['time_borrowed']; ?></td>
                <td>
                    <a href="customer.php?tab_id=4&return_suit=1&suit_id=<?php echo $suit['id'];?>" class="button">תקין</a>
                    <a href="customer.php?tab_id=4&return_suit=0&suit_id=<?php echo $suit['id'];?>" class="button warning">לא תקין</a>
                </td>
            </tr>
        </table>
        <?php
    } else if( $customer['insurance'] == 1 ){
        $suits_sizes_results = $conn->query("SELECT * FROM `suits_sizes`");
        ?>
		<br>
        <h2>השאלת חליפת גלישה </h2>
        <form action="customer.php" method="get">
            <table>
                <tr>
                    <td>
                        מין:
                    </td>
                    <td>
                        <select name="gender">
                            <option value="0">בחר/י</option>
                            <option value="1">נקבה</option>
                            <option value="2">זכר</option>
                        </select>
                    </td>
                    <td>
                        מידה:
                    </td>
                    <td>
                        <select name="size_id">
                            <option value="0">בחר/י</option>
                            <?php
                            while ($suit = $suits_sizes_results->fetch_assoc() ) { ?>
                                <option value="<?php echo $suit['id'];?>"><?php echo $suit['size_name'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit" class="button" name="search_suits" value="חיפוש חליפת גלישה">
                        <input type="hidden" name="tab_id" value="4">
                    </td>
                </tr>

            </table>
            <br>
            <?php
            if( isset( $search_suits_results ) ) {
                $counter =1;
                ?>
                <table style="width: 100%;" border="1">
                    <tr>
                        <th>#</th>
                        <th>מק"ט</th>
                        <th>מותג</th>
                        <th>מידה</th>
                        <th>בחר חליפת גלישה</th>
                    </tr>
                    <?php
                    while( $suit = $search_suits_results->fetch_assoc() ) { ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $suit['id_number'];?></td>
                            <td><?php echo $suit['brand'];?></td>
                            <td><?php echo $suit['size_name'];?></td>
                            <td><a href="customer.php?action=choose_suit&suit_id=<?php echo $suit['id'];?>" class="button">בחר</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </form>
        <?php
    }
    ?>
</div>

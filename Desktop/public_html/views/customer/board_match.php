<div class="tab" data-tab_id="2" <?php if($tab_id == 2 ) { echo ' style="display:block;"';}?>>
    <h2>התאמת גלשן</h2>
	<br>
    <h3>שם הלקוח/ה :<?php echo $customer['name'];?></h3>
	<br>

	<h3 >נתוני הלקוח/ה :</h3>
    <form action="customer.php" method="get">
        <table>
            <tr>
                <td>גובה:
                    <strong><?php echo $customer['height'];?> ס"מ</strong>,
                </td>
                <td>משקל:
                    <strong><?php echo $customer['weight'];?> ק"ג</strong>
                </td>
                <td>
                    <input type="submit" name="match_board" class="button" value="חיפוש גלשן">
                    <input type="hidden" name="tab_id" value="2">
                    <input type="hidden" name="customer_height" value="<?php echo $customer['height']; ?>">
                </td>
            </tr>
        </table>
    </form>

		<?php
		if(isset( $match_score )) {
			?>
			<br>
			<br>
			<h3>תוצאות החיפוש:</h3>
			<table style="width: 100%" border="1">
				<tr>
					<th>מספר הגלשן</th>
					<th>אורך</th>
					<th>רוחב</th>
					<th>עובי</th>
					<th>ציון</th>
					<th>בצע השאלה</th>
				</tr>
				<?php


				$board_number = 1;
				foreach ($match_score as $soft_board) { ?>
					<tr>
						<td><?php echo $soft_board['id_number']; ?></td>
						<td><?php echo $soft_board['length']; ?></td>
						<td><?php echo $soft_board['width']; ?></td>
						<td><?php echo $soft_board['thickness']; ?></td>
						<td><?php echo $soft_board['score']; ?></td>
						<td>
							<a
								<?php
								if( $customer_already_have_board === true ) { ?>
									href="#"
									onclick="return alert('על הלקוח/ה להחזיר את הגלשן המושכר שברשותו');"
								<?php	
								}
								if( $customer['insurance'] == 0 ) { ?>
									href="#"
									onclick="return alert('לפני בחירת הגלשן יש לחדש את הביטוח');"
								<?php
								} else { ?>
									href="customer.php?do_match=1&board_id=<?php echo $soft_board['id'];?>&tab_id=2"
								<?php
								}
								?>
									class="button">בחר</a>
						</td>
					</tr>
					<?php
					$board_number++;
					if( $board_number > 3 ) {
						break;
					}
				}
				?>
			</table>
			<?php
		}
		?>

</div>

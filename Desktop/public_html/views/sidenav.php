
<ul class="side-nav">
    <li>
        <a href="customers.php" class="menu-link">לקוחות</a>
    </li>
       <?php
    if( getRoleId() == 1 ) {
        ?>
        <li>
            <a href="new_employee.php" class="menu-link">עובדים</a>
        </li>
        <?php
    }
    ?>
    <?php
    if( getRoleId() != 4 ) { 
        ?>
        <li>
            <a href="set_shifts.php" class="menu-link">הגשת משמרות</a>
        </li>
        <?php
    }
    if( getRoleId() != 3 && getRoleId() != 4 ) { 
        ?>
        <li>
            <a href="placement_of_employees.php" class="menu-link">שיבוץ עובדים</a>
        </li>
        <?php
    }
    ?>
    <li>
        <a href="working_arrangement.php" class="menu-link">סידור עבודה</a>
    </li>
    <?php
    // if( getRoleId() != 3 ) {
        ?>
        <li>
            <a href="add_schedule.php" class="menu-link">רישום פעילות במערכת</a>
        </li>
        <li>
            <a href="reports.php" class="menu-link">דו"חות</a>
        </li>
    
      <li>
            <a href="stock_managment.php" class="menu-link">ניהול מלאי</a>
        </li>
    <li>
        <a href="logout.php" class="menu-link">התנתקות</a>
    </li>
    
    
    
     
</ul>

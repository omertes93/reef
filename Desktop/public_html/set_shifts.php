<?php
session_start();
include 'include/db.inc.php';
include 'include/helper.php';

if( !isLogin() || getRoleId() == 4 ){
    header('location:index.php');
    exit;
}



if (isset($_GET['set'])){

    if ($_GET['set'] == 1) {
        $insert = "INSERT INTO `working_days`(employee_id, date) VALUES ('". getRoleId() ."', '".$_GET['date']."')";
        mysqli_query($conn,$insert);
        //header("Location: $_SERVER[PHP_SELF]");
    } else {

        $delete = "DELETE FROM `working_days` WHERE date='".$_GET['date']."'";
        mysqli_query($conn,$delete);


        //header("Location: $_SERVER[PHP_SELF]");
    }

}


$allschedules = $conn->query("SELECT * FROM `working_days` INNER JOIN employees ON working_days.employee_id=employees.id");

$rows = [];

if( $allschedules->num_rows > 0 ) {

    $rows = $allschedules->fetch_all(MYSQLI_ASSOC);
    
    // print_r($rows);

    // $_SESSION['employee_id'] = $employee_id;
    // header('location:employee.php');
    // exit;
} else {
    $error = "לא נמצא/ה עובד/ת עם הפרטים שהוזנו";
}

include 'views/header.php';
?>



<?php 

// print_r($rows);

$dates_array = [];
$id_array = [];
$employee_name =[];
foreach ($rows as $key => $value) {
    
    $employee_id = $value['employee_id'];
    $employee_name[] = $value['name'];
    $dates_array[] = $date = $value['date'];
    $id_array[] = $date = $value['id'];
    }

    // print_r($dates_array);

?>


<table style="width: 100%;">
    <tr>
        <td style="width: 25%;vertical-align: top;">
            <?php
            include "views/sidenav.php";
            ?>
        </td>
       <td style="width: 75%;border: 3px solid; text-align:center;">
            <h1>הגשת משמרות</h1>
             <br>
           <?php
           $day = date('w');
           $sunday_date = get_first_day_date( true );
           $saturday_date = get_last_day_date(true);
           $display_sunday_date = date('d/m/Y', strtotime($sunday_date));
                // change from Y-m-d to d-m-Y
           $display_saturday_date = date('d/m/Y', strtotime($saturday_date)); // change from Y-m-d to d-m-Y



           $weekOfdays = [];
           $date = $sunday_date;
           $date = $sunday_date .' -1 day';
           
            for($i =0; $i <= 7; $i++){
                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
                $weekOfdays[$i] = date('Y-m-d', strtotime($date));
            }
            // print_r($weekOfdays);

           

            foreach($weekOfdays as $gdays){
 
                
            }

           ?>

           
           <h3>שבוע:
                <?php echo $display_saturday_date . ' - ' . $display_sunday_date; ?>
            </h3>
            <table style="width: 100%;" border="1">
                <tr>
                <?php
                foreach ($days as $key => $day) { ?>
                    <td style="height: 100px; vertical-align: top; width: 14.28%; position: relative;">
                        <div>
                            <h5><?php echo $day; ?></h5>
                            <small><?php echo $weekOfdays[$key - 1]; ?></small>
                            <h6><?php echo $employee_name[$key - 1]; ?></h6>
                            
                            
                            <?php
                            if( $key == 3 || $key == 6 ) {
                                ?>
                                <span style="float: left;"></span>
                                <?php
                            }
                            else { ?>
                                <span style="float: left;"></span>
                            <?php
                            }
                            ?>
                        </div>

                        <?php 
                if (in_array($weekOfdays[$key - 1], $dates_array))
                { ?>

<div style="margin-top: 50px;">
                                <button onclick="cancel('<?php echo $weekOfdays[$key - 1]; ?>')" class="button warning">Cancel</button>
                            </div>
                            <?php 
                }
                else
                { ?>

<div style="margin-top: 50px;">
                                <button onclick="schedule('<?php echo $weekOfdays[$key - 1]; ?>')" class="button">Schedule</button>
                            </div>
                            <?php 
                }
?>

                        <!-- <?php
                        if( $key == 3 || $key == 6 ) { ?>
                            <div style="margin-top: 50px;">
                                
                            </div>
                        <?php
                        } else if( $key == 4 ) {
                            ?>
                           
                            <?php
                        } else{ ?>
                          
                        <?php
                        }
                        ?> -->
                    </td>
                <?php
                }
                ?>
                </tr>
            </table>
            
        </td>
    </tr>
</table>

<script>
    function schedule(day){

        if (name != undefined && name != null) {
            window.location = 'set_shifts.php?set=1&date=' + day;
        }
    }

    function cancel(day){
            window.location = 'set_shifts.php?set=0&date=' + day;

}
</script>

<?php
include 'views/footer.php';
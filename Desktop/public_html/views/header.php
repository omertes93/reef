<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ריף הרצליה</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
    <?php
    if( isset( $is_boards_reports ) || isset($is_suit_reports) ) { ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['<?php echo $chart_arr[0][0]?>', '<?php echo $chart_arr[0][1]?>'],
                    ['<?php echo $chart_arr[1][0]?>', <?php echo $chart_arr[1][1]?>],
                    ['<?php echo $chart_arr[2][0]?>', <?php echo $chart_arr[2][1]?>]
                ]);

                var options = {
                    title: ''
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>
        <?php
    } else if( isset( $is_participants_reports )) { ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawStuff);

            function drawStuff() {
                var data = new google.visualization.arrayToDataTable([
                    ['חודש', 'מספר משתתפים' ], //{ role: 'style' }
                    <?php
                    foreach ( $participants_data as $participant_number ) {
                        echo "['" . $participant_number['month'] . "' , ".$participant_number['number'].' ],';
                    }
                    ?>
                ]);

                var options = {
                    width: 800,
                    vAxis: {
                        //format: ''
                    }
                };

                var chart = new google.charts.Bar(document.getElementById('top_x_div'));
                // Convert the Classic options to Material options.
                chart.draw(data, google.charts.Bar.convertOptions(options));
            };
        </script>
    <?php
    }
    ?>
    

    
</head>

    <body>
        <div id="weather">
       <div id="ww_f1026dc29d5b1" v='1.3' loc='id' a='{"t":"horizontal","lang":"en","ids":["wl4325"],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"#FFFFFF00","cl_font":"#000000","cl_cloud":"#d4d4d4","cl_persp":"#2196F3","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722"}'><a href="https://weatherwidget.org/it/" id="ww_f1026dc29d5b1_u" target="_blank">Widget delle previsioni meteo per sito web</a></div><script async src="https://app1.weatherwidget.org/js/?id=ww_f1026dc29d5b1"></script>
        </div>
        
        
        <div id="facebook">
           <div id="fb-root"></div>
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v15.0" nonce="JJvOiIOo"></script> 
            
         
        <div class="fb-page" data-href="https://www.facebook.com/reefisrael/" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/reefisrael/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/reefisrael/">‎ריף מועדון גלישה וצלילה‎</a></blockquote></div> </div>   
        
        <div id="wrapper">
            <div id="header">
                <div id="small-logo">
                    <?php
                    $link = "index.php";
                    if( isset( $_SESSION['employee_id'] )) {
                        $link = "dashboard.php";
                    }
                    ?>
                    <a href="<?php echo $link;?>" title="דף הבית">
                        <img src="images/small-logo.png" alt="" width="130px;">
                    </a>
                </div>
                <div id="nav">

                </div>
            </div>


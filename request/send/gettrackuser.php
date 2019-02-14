<?php
    require 'track_config.php';
    require 'TimeTracker.php';
    
    $timeTracker = new TimeTracker($conn);


    /**
     * user list
     */
    // $timeTracker->SetDate(date("Y-m-d"));
    $timeTracker->SetDate();
    $countList = $timeTracker->GetUserListByHours();

    $jsonUserCountStr = json_encode($countList['chart']);

    // make labels for js
    $hourslabel = [];
    for ($i = 0; $i < 12; $i++) {
        if ($i == 0) {
            $time = 12 . 'am';
        } else {
            $time = $i . 'am';
        }   
        array_push($hourslabel, $time); 
    }
    for ($i=12; $i < 24; $i++) {
        if ($i == 12) {
             $time = 12 . 'pm';
         } else {
            $time = $i - 12 . 'pm';
         }
        array_push($hourslabel, $time); 
    }

    $hourslabel = json_encode($hourslabel);

?>

<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <title>User Tracker</title>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./trackassets/theme.blue.css">
    <link rel="stylesheet" href="./trackassets/jq.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="./trackassets/jquery.tablesorter.min.js"></script>
    <script src="./trackassets/jquery.tablesorter.widgets.min.js"></script>

    <style>
        p {
            margin: 0;
            padding: 0; 
        }
        .wrapper {
            padding: 15px;
        }

        .chart-container {
            text-align: center;
        }
        #datepicker {
            margin-bottom: 20px;
        }
        .table-wrraper {
            margin-top: 25px;
        }
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .lati-long:hover {
            text-decoration: underline;
            cursor: pointer;
        }
        .bk-fix-gray {
            position: fixed;
            width: 100vw;
            height: 100vh;
            top: 0;
            left: 0;
            background: rgba(0,0,0,.3);
            display: none;
        }
        .map-dlg {
            width: 70vw;
            height: 70vh;
            margin-right: auto;
            margin-left: auto;
            background: #fff;
            margin-top: 50px;
        }
        .map-dlg .header {
            border-bottom: 1px solid #ddd;
            padding: 10px; 
        }
        .map-dlg .header .title {
            font-size: 18px;
            font-weight: 600;
            float: left;
        }
        .map-dlg .header .pos {
            font-size: 12px;
            font-color: #eee;
        }
        .map-dlg .header .close {
            float: right;
        }
        .map-dlg-content {
            width: 100%;
            height: calc(70vh - 46px);
            padding: 10px;
        }
        #googleMap {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="chart-container" style="width: 80vw">
            <label for="datepicker">Date: </label>
            <input type="text" name="date" id="datepicker">
            <canvas id="userCountListChart"></canvas>
        </div>
        <div class="table-wrraper">
            <table id='customers' class='tablesorter table table-hover'>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Duration</th>
                        <th>GPS Location</th>
                        <th>Cityname</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody id="info">
                    <?php foreach ($countList['table'] as $data) { ?>
                        <tr>
                            <td><?php echo $data['email'] ?></td>
                            <td><?php echo $data['duration'] ?></td>
                            <td class="lati-long"><?php echo $data['lati_longitude'] ?></td>
                            <td><?php echo $data['cityname'] ?></td>
                            <td><?php echo date("m/d/Y h:i A", strtotime($data['fromwhen'])) ?></td>
                            <td><?php echo $data['towhen'] == '' ? '' : date("m/d/Y h:i A", strtotime($data['towhen'])) ?></td>
                        </tr>
                    <?php } ?>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bk-fix-gray">
            <div class="map-dlg">
                <div class="header clearfix">
                    <span class="title"><span class="email"></span>(<small class="pos"></small>)</span>
                    <button class="close"><i class="glyphicon glyphicon-remove-circle"></i></button>
                </div>
                <div class="map-dlg-content">
                    <div id="googleMap"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let userListChart;
        let map;
        let mapMarker;

        window.chartColors = {
            blue: "rgb(54, 162, 235)",
            green: "rgb(75, 192, 192)",
            grey: "rgb(201, 203, 207)",
            orange: "rgb(255, 159, 64)",
            purple: "rgb(153, 102, 255)",
            yellow: "rgb(255, 205, 86)",
            red: "rgb(255, 99, 132)",
        }


        function updateUserCountListChart(data, dateLabel) {
            var maxVal = getIncreaseStepCount(data);

            userListChart.data.datasets.forEach((dataset) => {
                dataset.data.splice(0,24);
                for (var index = 0; index < 24; index ++) {
                    dataset.data.push(data[index]);
                }

                dataset.label = dateLabel;
            });

            userListChart.options.scales.yAxes[0].ticks.stepSize = maxVal;
            userListChart.update();
        }

        function getIncreaseStepCount(usersCountArr)
        {
            var max  = Math.max.apply(null, usersCountArr);

            if (max < 5) {
                return 1;
            }
            if (max < 20) {
                return 2
            }

            if (max > 100) {
                return 10;
            }

            return 5;
        }

        function gmap() {
            var mapProp= {
                center: new google.maps.LatLng(0, 0),
                zoom:5,
            };

            map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
            var myLatlng = {lat: 0, lng: 0};

            mapMarker = new google.maps.Marker({
                            position:  myLatlng,
                            map: map,
                            draggable: false,
                       });
        }

        $(document).ready(function() {
            /**
             * table sorter
             */
            $('table').tablesorter({
                theme : 'blue',
                widgets        : ['zebra', 'columns','reorder'],
                usNumberFormat : false,
                sortReset      : true,
                sortRestart    : true,
            });


            /**
             * data picker setting
             */
            $("#datepicker" ).datepicker({
                dateFormat: "mm/dd/yy",
                minDate: new Date("<?php echo $timeTracker->GetStartDay(); ?>"),
                defaultDate: new Date("<?php echo date("Y-m-d"); ?>"),
            }).on('change', function(ev){
                var date = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: './fetchdatafortrackusers.php',
                    data: {date: date},
                    success: function(data) {
                        var res = JSON.parse(data);

                        updateUserCountListChart(res.chart, date);

                        //update table
                        var html = '';
                        for(var i = 0; i<res.table.length; i++){
                            html += "<tr><td>"+res.table[i].email+"</td>"
                                +"<td>"+res.table[i].duration+"</td>"
                                +"<td class='lati-long'>"+res.table[i].lati_longitude+"</td>"
                                +"<td>"+res.table[i].cityname+"</td>"
                                +"<td>"+res.table[i].fromwhen+"</td>"
                                +"<td>"+res.table[i].towhen+"</td></tr>"
                        }

                        $("#info").html(html);
                        $("table").trigger("update");
                    }
                });
            });
            
            $("#datepicker").datepicker("setDate", new Date("<?php echo date("m/d/Y"); ?>"));


            /**
             * User Count list chart set
             */

            var usersCountArr = JSON.parse("<?php echo $jsonUserCountStr; ?>");

            var stepCount = getIncreaseStepCount(usersCountArr);

            var userListCtx = document.getElementById("userCountListChart");
            userListChart = new Chart(userListCtx, {
                type: 'line',
                data: {
                    labels: <?php echo $hourslabel; ?>,
                    datasets: [{
                        label: "<?php echo date("m/d/Y"); ?>",
                        data: usersCountArr,
                        backgroundColor: window.chartColors.red,
                        borderColor: window.chartColors.red,
                        borderWidth: 2,
                        fill: false,
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'User tracking',
                        fontSize: 24,
                        fontColor: '#059BFF',
                    },
                    scales: {
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Time Line',
                                fontColor: '#f00',
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: stepCount,
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'User Count',
                                fontColor: '#f00',
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            title: function(tooltipItem, data) {
                                // return tooltipItem[0].xLabel + 'H:';
                                return;
                            },
                            label: function(tooltipItem, data){
                                return data.datasets[tooltipItem.datasetIndex].label + " " + tooltipItem.xLabel + ":00  Number of users count: " + tooltipItem.yLabel;
                            }
                        }
                    }
                }
            });

            $('table').on('click', '.lati-long', function(){
                var temp = $(this).text();
                var lati = Number(temp.split('/')[0]);
                var long = Number(temp.split('/')[1]);

                var panPoint = new google.maps.LatLng(lati, long);
                map.panTo(panPoint);
                mapMarker.setPosition(panPoint);


                $(".map-dlg .pos").text(temp);
                $(".map-dlg .email").text($(this).siblings()[0].innerText);
                $('.bk-fix-gray').show();
            });
            $(".close").click(function(){
                $('.bk-fix-gray').hide();
            });
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeXKc29sBRsdP2KwRkkhvm6KajuPdRYYk&callback=gmap"></script>

</body>
</html>
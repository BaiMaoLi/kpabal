<?php
    require 'track_config.php';
    require 'TimeTracker.php';
    
    $timeTracker = new TimeTracker($conn);

    $songsList = $timeTracker->GetThumbData();
?>

<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <title>Thumbs</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./trackassets/theme.blue.css">
    <link rel="stylesheet" href="./trackassets/jq.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="./trackassets/jquery.tablesorter.min.js"></script>
    <script src="./trackassets/jquery.tablesorter.widgets.min.js"></script>


    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
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
/*        #customers tr:nth-child(even){background-color: #f2f2f2;}
        #customers tr:hover {background-color: #ddd;}
        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #002366;
            color: white;
        }
*/        table td i.glyphicon {
            display: inline-block;
            width: 100%;
            text-align: center;
        }
        .wrapper {
            margin-top: 30px;
            padding: 15px;
        }
        .chart-container {
            margin-bottom: 30px;
        }
        .chart-container {
            border: 1px solid #ddd;
            box-shadow:10px 10px 20px 2px rgba(0, 35, 102, .2);
        }
        .percent-td {
            position: relative;
        }
        .percent-td:after {
            position: absolute;
            top: 0;
            right: 0;
            width: auto;
            height: 100%;
            
            line-height: 1em;
            margin-right: 3px;
            font-size: 18px;
            font-weight: 700;
            vertical-align: middle;
        }
        .percent-td.up:after {
            content: '\2191';
        }
        .percent-td.down:after {
            content: '\2193';
        }

/*        .percent.up {
            background-image: url(./trackassets/arrow-up.png);
        }
        .percent.down {
            background-image: url(./trackassets/arrow-down.png); 
        }
*/    </style>

</head>
<body>
    <div class="wrapper">
        <div class="chart-container">
            <canvas id="songsLikeListChart" style="width: 95vw"></canvas>
        </div>

        <div class="chart-container">
            <canvas id="songsDislikeListChart" style="width: 95vw"></canvas>
        </div>


        <table id='customers' class='tablesorter table table-hover'>
            <thead>
                <tr>
                    <th rowspan="2">Title</th>
                    <th rowspan="2">Artist</th>
                    <th colspan="7" class="filter-false">Likes</th>
                    <th colspan="7" class="filter-false">Dislikes</th>
                </tr>
                <tr class="filter-false">
                    <th class="filter-false">before 3 week</th>
                    <th class="filter-false">before 2 week</th>
                    <th class="filter-false">%</th>
                    <th class="filter-false">before 1 week</th>
                    <th class="filter-false">%</th>
                    <th class="filter-false">current week</th>
                    <th class="filter-false">%</th>

                    <th class="filter-false">before 3 week</th>
                    <th class="filter-false">before 2 week</th>
                    <th class="filter-false">%</th>
                    <th class="filter-false">before 1 week</th>
                    <th class="filter-false">%</th>
                    <th class="filter-false">current week</th>
                    <th class="filter-false">%</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($songsList['table'] as $data) {
                ?>
                    <tr>
                        <td><?php echo $data['title']?></td>
                        <td><?php echo $data['artist']?></td>
                        <td><?php echo $data['last3_week_likes']?></td>
                        <td><?php echo $data['last2_week_likes']?></td>
                        <?php
                            $percent = TimeTracker::CalcPercent($data['last3_week_likes'] ,$data['last2_week_likes']);
                            if ($percent >= 0) {
                                echo "<td class='percent-td up'>$percent%</td>";
                            } else {
                                echo "<td class='percent-td down'>$percent%</td>";
                            }
                        ?>
                        <td><?php echo $data['last1_week_likes']?></td>
                        <?php
                            $percent = TimeTracker::CalcPercent($data['last2_week_likes'] ,$data['last1_week_likes']);
                            if ($percent >= 0) {
                                echo "<td class='percent-td up'>$percent%</td>";
                            } else {
                                echo "<td class='percent-td down'>$percent%</td>";
                            }
                        ?>
                        <td><?php echo $data['cur_week_likes']?></td>
                        <?php
                            $percent = TimeTracker::CalcPercent($data['last1_week_likes'] ,$data['cur_week_likes']);
                            if ($percent >= 0) {
                                echo "<td class='percent-td up'>$percent%</td>";
                            } else {
                                echo "<td class='percent-td down'>$percent%</td>";
                            }
                        ?>

                        <td><?php echo $data['last3_week_dislikes']?></td>
                        <td><?php echo $data['last2_week_dislikes']?></td>
                        <?php
                            $percent = TimeTracker::CalcPercent($data['last3_week_dislikes'] ,$data['last2_week_dislikes']);
                            if ($percent > 0) {
                                echo "<td class='percent-td up'>$percent%</td>";
                            } else {
                                echo "<td class='percent-td down'>$percent%</td>";
                            }
                        ?>
                        <td><?php echo $data['last1_week_dislikes']?></td>
                        <?php
                            $percent = TimeTracker::CalcPercent($data['last2_week_dislikes'] ,$data['last1_week_dislikes']);
                            if ($percent > 0) {
                                echo "<td class='percent-td up'>$percent%</td>";
                            } else {
                                echo "<td class='percent-td down'>$percent%</td>";
                            }
                        ?>
                        <td><?php echo $data['cur_week_dislikes']?></td>
                        <?php
                            $percent = TimeTracker::CalcPercent($data['last1_week_dislikes'] ,$data['cur_week_dislikes']);
                            if ($percent > 0) {
                                echo "<td class='percent-td up'>$percent%</td>";
                            } else {
                                echo "<td class='percent-td down'>$percent%</td>";
                            }
                        ?>
                    </tr>
                <?php
                    } 
                ?>
            </tbody>
        </table>
    </div>


    <script>
        let songsLikeListChart;
        let songsDislikeListChart
        var songsList = <?php echo json_encode($songsList['chart']) ?>;

        window.chartColors = {
            blue: "rgb(54, 162, 235)",
            green: "rgb(75, 192, 192)",
            dark_green: "rgb(84, 150, 109)",
            grey: "rgb(201, 203, 207)",
            orange: "rgb(255, 159, 64)",
            purple: "rgb(153, 102, 255)",
            right_yellow: "rgb(229, 203, 133)",
            yellow: "rgb(255, 205, 86)",
            red: "rgb(255, 99, 132)",
        }

        /**
         * songs list chart set
         */
        var songsLikeListCtx = document.getElementById("songsLikeListChart");
        var songsDisListCtx = document.getElementById("songsDislikeListChart");

        songsLikeListChart = new Chart(songsLikeListCtx, {
            type: 'bar',
            data: {
                labels: songsList.like_title,
                datasets: [{
                    label: "before 3 week (" + songsList.last3_week_range + ')',
                    data: songsList.like_data.last3.map(function(info){
                        return Number(info[0]);
                    }),
                    backgroundColor: window.chartColors.right_yellow,
                    borderColor: window.chartColors.right_yellow,
                },
                {
                    label: "before 2 week (" + songsList.last2_week_range + ')',
                    data: songsList.like_data.last2.map(function(info){
                        return Number(info[0]);
                    }),
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,

                },
                {
                    label: "before 1 week (" + songsList.last1_week_range + ')',
                    data: songsList.like_data.last1.map(function(info){
                        return Number(info[0]);
                    }),
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,

                },
                {
                    label: "current week (" + songsList.cur_week_range + ')',
                    data: songsList.like_data.cur.map(function(info){
                        return Number(info[0]);
                    }),
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Likes',
                    fontSize: 24,
                    fontColor: '#059BFF',
                },
                responsive: true,
                scales: {
                    xAxes: [{
                        distribution: 'series',
                        display: true,
                        position: 'left',
                        ticks : {
                            autoSkip: false
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks : {
                            source: 'labels',
                            beginAtZero: true,
                        }
                    }]
                },
                tooltips: {
                }
            }
        });


        songsDislikeListChart = new Chart(songsDisListCtx, {
            type: 'bar',
            data: {
                labels: songsList.dislike_title,
                datasets: [{
                    label: "before 3 week (" + songsList.last3_week_range + ')',
                    data: songsList.dislike_data.last3.map(function(info){
                        return Number(info[1]);
                    }),
                    backgroundColor: window.chartColors.grey,
                    borderColor: window.chartColors.grey,
                },
                {
                    label: "before 2 week (" + songsList.last2_week_range + ')',
                    data: songsList.dislike_data.last2.map(function(info){
                        return Number(info[1]);
                    }),
                    backgroundColor: window.chartColors.dark_green,
                    borderColor: window.chartColors.dark_green,

                },
                {
                    label: "before 1 week (" + songsList.last1_week_range + ')',
                    data: songsList.dislike_data.last1.map(function(info){
                        return Number(info[1]);
                    }),
                    backgroundColor: window.chartColors.orange,
                    borderColor: window.chartColors.orange,

                },
                {
                    label: "current week (" + songsList.cur_week_range + ')',
                    data: songsList.dislike_data.cur.map(function(info){
                        return Number(info[1]);
                    }),
                    backgroundColor: window.chartColors.purple,
                    borderColor: window.chartColors.purple,
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Dislikes',
                    fontSize: 24,
                    fontColor: '#FF8CA5'
                },
                responsive: true,
                scales: {
                    xAxes: [{
                        distribution: 'series',
                        display: true,
                        position: 'left',
                        ticks : {
                            autoSkip: false
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks : {
                            source: 'labels',
                            beginAtZero: true,
                        }
                    }]
                },
                tooltips: {
                }
            }
        });

        $(document).ready(function() {
            $('table').tablesorter({
                theme : 'blue',
                widgets        : ['zebra', 'columns', 'filter', 'reorder'],
                usNumberFormat : false,
                sortReset      : true,
                sortRestart    : true,
                headers: {
                    2 : {
                        sorter: false,
                    },
                    3: {
                        sorter: false,
                    }
                },
                widgetOptions : {
                    filter_columnFilters : true
                }
            });

        });
    </script>
</body>
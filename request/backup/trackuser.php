<?php
	require 'trackconfig.php';
	require 'TimeTracker.php';
	
	$timeTracker = new TimeTracker($conn);


	/**
	 * user list
	 */
	$timeTracker->SetDate(date("Y-m-d"));
	// $timeTracker->SetDate();

	$countList = $timeTracker->GetUserListByHours();

	$jsonUserCountStr = json_encode($countList);
	$maxCount = max($countList);

	// make labels for js
	$hourslabel = [];
	for ($i = 0; $i < 24; $i++) {
		array_push($hourslabel, sprintf("%02d", $i)); 
	}
	
	$hourslabel = json_encode($hourslabel);


	$step = 1;
	$max = 10;

	if ($maxCount > 10 && $maxCount < 20) {
		$max = 20;
		$step = 2;
	}
?>

<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<title>User Tracker</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
</head>
<body>
	<input type="text" name="date" id="datepicker">

	<div class="chart-container" style="position: relative; height:40vh; width:80vw">
		<canvas id="userCountListChart"></canvas>
	</div>

	<script>
		let userListChart;

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
			userListChart.data.datasets.forEach((dataset) => {
				dataset.data.splice(0,24);
				for (var index = 0; index < 24; index ++) {
					dataset.data.push(data[index]);
				}

				dataset.label = dateLabel;
			});


			userListChart.update();
		}


		$(document).ready(function() {
			/**
			 * data picker setting
			 */
			$("#datepicker" ).datepicker({
				dateFormat: "yy-mm-dd",
				minDate: new Date("<?php echo $timeTracker->GetStartDay(); ?>"),
				maxDate: new Date("<?php echo date("Y-m-d"); ?>"),
				defaultDate: new Date("<?php echo date("Y-m-d"); ?>"),
			}).on('change', function(ev){
				var date = $(this).val();
				$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: {date: date},
					success: function(data) {
						updateUserCountListChart(JSON.parse(data), date);
					}
				});
			});
			
			$("#datepicker").datepicker("setDate", new Date("<?php echo date("Y-m-d"); ?>"));


			/**
			 * User Count list chart set
			 */
			var maxCount = <?php echo $maxCount ?>;

			var userListCtx = document.getElementById("userCountListChart");
			userListChart = new Chart(userListCtx, {
			    type: 'line',
			    data: {
			        labels: <?php echo $hourslabel; ?>,
			        datasets: [{
			            label: "<?php echo date("Y-m-d"); ?>",
			            data: JSON.parse("<?php echo $jsonUserCountStr; ?>"),
			            backgroundColor: window.chartColors.red,
			            borderColor: window.chartColors.red,
			            borderWidth: 2,
			            fill: false,
			        }]
			    },
			    options: {
			    	title: {
			    		display: true,
			    		text: 'User tracking'
			    	},
			        scales: {
			        	xAxes: [{
			        	}],
			            yAxes: [{
			                ticks: {
			                    beginAtZero: true,
			                    // min: 0,
			                    // max: <?php echo $max; ?>,
			                    // step: <?php echo $step; ?>,
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


		});
	</script>
</body>
</html>
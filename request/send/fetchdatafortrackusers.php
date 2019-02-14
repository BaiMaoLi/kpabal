<?php
    require 'track_config.php';
    require 'TimeTracker.php';

    if(isset($_POST['date'])) {
        $date = $_POST['date'];
		$date = date("Y-m-d", strtotime($_POST['date']));
		
        $timeTracker = new TimeTracker($conn);

        $timeTracker->SetDate($date);

        $countList = $timeTracker->GetUserListByHours();
        $jsonUserCountStr = json_encode($countList);
        echo $jsonUserCountStr;
    } 
?>
<?php
	include 'track_config.php';

	$result = $conn->query("SELECT * FROM trackusers WHERE towhen=''");
	$rowCount = $result->num_rows;
	if ($rowCount > 0) {
		for ($index = 0; $index < $rowCount; $index ++) { 
			$row = $result->fetch_assoc();

			$id = $row['id'];
			$fromwhen = $row['fromwhen'];

			$towhen = date("Y-m-d H:i:s", strtotime($fromwhen.'+ 1 hour'));

			$sql = "UPDATE trackusers SET towhen='$towhen' WHERE id='$id'";
			// var_dump($sql);
			$conn->query($sql);			
		}
	}

/*	$result = $conn->query("SELECT * FROM trackusers WHERE fromwhen LIKE '2018-06-06%'");
	$rowCount = $result->num_rows;
	if ($rowCount > 0) {
		for ($index = 0; $index < $rowCount; $index ++) { 
			$row = $result->fetch_assoc();

			$fromwhen = $row['fromwhen'];
			$towhen = $row['towhen'];
			$email = $row['email'];
			$duration = $row['duration'];
			$lat_lon = $row['lati_longitude'];
			$created_at = $row['created_datetime'];
			$cityname = $row['cityname'];

			$fromwhen =  date("Y-m-d H:i:s", strtotime($fromwhen.'+ 26 day'));
			$towhen =  date("Y-m-d H:i:s", strtotime($towhen.'+ 26 day'));
			$created_at =  date("Y-m-d H:i:s", strtotime($created_at.'+ 26 day'));

			$sql = "INSERT INTO trackusers (email, duration, lati_longitude, cityname, fromwhen, towhen, created_datetime) VALUES ('$email', '$duration', '$lat_lon', '$cityname', '$fromwhen', '$towhen', '$created_at')";
			$conn->query($sql);			
		}
	}

*/
?>
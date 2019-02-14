<?php
	include 'track_config.php';

	$result = $conn->query("SELECT * FROM thumps");
	$curDate = date('Y-m-d');
	$rowCount = $result->num_rows;
	if ($rowCount > 0) {
		for ($index = 0; $index < $rowCount; $index ++) { 
			$row = $result->fetch_assoc();

			$songId = $row['id'];
			$likes = $row['likes'];
			$dislikes = $row['dislikes'];

			$sql = "INSERT INTO thumb_log (song_id, likes, dislikes, created_at) VALUES ('$songId', '$likes', '$dislikes', '$curDate')";
			$conn->query($sql);
		}
	}

	$conn->query('UPDATE thumps SET likes=0, dislikes=0');
?>
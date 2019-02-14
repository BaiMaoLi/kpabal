<?php
/**
* 
*/
class TimeTracker
{
	protected 		$conn;
	private 		$date;

	function __construct($conn)
	{
		$this->conn = $conn;
	}

	public function SetDate($date = null)
	{
		$this->date = $date == null ? date('Y-m-d') : $date;
	}

	public function GetDate()
	{
		return $this->date;
	}

	protected function GetUserCountByHour($hour = 0)
	{
		if ($hour < 0 || $hour > 23) {
			return false;
		}

		$hour = sprintf('%02d', $hour);

		$startTimeStamp = $this->GetDate() . " $hour:00:00";
		$endTimeStamp = $this->GetDate() . " $hour:59:59";


		//$sql = "SELECT ANY_VALUE(id) as id, email, ANY_VALUE(duration) as duration, ANY_VALUE(lati_longitude) as lati_longitude, ANY_VALUE(cityname) as cityname, ANY_VALUE(fromwhen) as fromwhen , ANY_VALUE(towhen) as towhen, ANY_VALUE(created_datetime) as created_datetime, IFNULL(towhen,UUID()) as unq_ancestor FROM trackusers WHERE (UNIX_TIMESTAMP(towhen) >= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) <= UNIX_TIMESTAMP('$endTimeStamp')) OR (UNIX_TIMESTAMP(fromwhen) >= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$endTimeStamp')) OR (UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) = 0) OR (UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) >= UNIX_TIMESTAMP('$endTimeStamp')) GROUP BY unq_ancestor, email ORDER BY id ASC";
		
		$sql = "SELECT id as id, email, duration as duration, lati_longitude as lati_longitude, cityname as cityname, fromwhen as fromwhen , towhen as towhen, created_datetime as created_datetime FROM trackusers WHERE (UNIX_TIMESTAMP(towhen) >= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) <= UNIX_TIMESTAMP('$endTimeStamp')) OR (UNIX_TIMESTAMP(fromwhen) >= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$endTimeStamp')) OR (UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) = 0) OR (UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) >= UNIX_TIMESTAMP('$endTimeStamp')) GROUP BY id ORDER BY id ASC";

		$res = $this->conn->query($sql);
		$count = $res->num_rows;

		return $count;
	}

	public function GetUserListByHours()
	{
		/**
		 * 
		 * chart data
		 */
		$countList = [];
		for ($index = 0; $index < 24; $index ++) {
			array_push($countList, $this->GetUserCountByHour($index));
		}


		/**
		 * table data
		 */

		$userList = [];

		$startTimeStamp = $this->GetDate() . ' 00:00:00';
		$endTimeStamp = $this->GetDate() . ' 23:59:59';

		//$sql = "SELECT ANY_VALUE(id) as id, email, ANY_VALUE(duration) as duration, ANY_VALUE(lati_longitude) as lati_longitude, ANY_VALUE(cityname) as cityname, ANY_VALUE(fromwhen) as fromwhen , ANY_VALUE(towhen) as towhen, ANY_VALUE(created_datetime) as created_datetime, IFNULL(towhen,UUID()) as unq_ancestor FROM trackusers WHERE (UNIX_TIMESTAMP(towhen) >= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) <= UNIX_TIMESTAMP('$endTimeStamp')) OR (UNIX_TIMESTAMP(fromwhen) >= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$endTimeStamp')) OR (UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) = 0) OR (UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) >= UNIX_TIMESTAMP('$endTimeStamp')) GROUP BY unq_ancestor, email ORDER BY id ASC";


		$sql = "SELECT id as id, email, duration as duration, lati_longitude as lati_longitude, cityname as cityname, fromwhen as fromwhen , towhen as towhen, created_datetime as created_datetime FROM trackusers WHERE (UNIX_TIMESTAMP(towhen) >= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) <= UNIX_TIMESTAMP('$endTimeStamp')) OR (UNIX_TIMESTAMP(fromwhen) >= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$endTimeStamp')) OR (UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) = 0) OR (UNIX_TIMESTAMP(fromwhen) <= UNIX_TIMESTAMP('$startTimeStamp') AND UNIX_TIMESTAMP(towhen) >= UNIX_TIMESTAMP('$endTimeStamp')) GROUP BY id ORDER BY id ASC";

		$res = $this->conn->query($sql);
		

		if ($res->num_rows > 0) {
			for ($index = 0 ; $index < $res->num_rows; $index ++) { 
				$row = $res->fetch_assoc();
				
				$row['fromwhen'] = date("m/d/Y h:i A", strtotime($row['fromwhen']));

				if ($row['towhen'] != '') {
					$row['towhen'] = date("m/d/Y h:i A", strtotime($row['towhen']));
				}

				array_push($userList, $row);
			}
		}

		return [
			'chart' => $countList,
			'table' => $userList,
		];
	}

	public function GetStartDay()
	{
		$sql = "SELECT * FROM trackusers LIMIT 1";

		$res = $this->conn->query($sql);

		if($res->num_rows == 1) {
			$row = $res->fetch_assoc();

			$startDate = date('Y-m-d', strtotime($row['created_datetime']));

			return $startDate;
		}
	}



	public function GetSongsList($toDate, $mode="song_id", $limit=null)
	{
		$fromDate = date("Y-m-d", strtotime($toDate . ' - 1 week'));
		
		if ($limit == null) {
			$sql = "SELECT t.title, t.id AS song_id, t.artist AS song_artist, SUM(tl.likes) AS likes, SUM(tl.dislikes) AS dislikes FROM `thumps` t LEFT JOIN `thumb_log` tl ON t.id = tl.song_id WHERE tl.created_at BETWEEN '$fromDate' AND '$toDate' GROUP BY tl.song_id, t.title ORDER BY $mode DESC";
		} else {
			$sql = "SELECT t.title, t.id AS song_id, t.artist AS song_artist, SUM(tl.likes) AS likes, SUM(tl.dislikes) AS dislikes FROM `thumps` t LEFT JOIN `thumb_log` tl ON t.id = tl.song_id WHERE tl.created_at BETWEEN '$fromDate' AND '$toDate' GROUP BY tl.song_id, t.title ORDER BY $mode DESC LIMIT $limit";
		}

		$res = $this->conn->query($sql);

		if ($res->num_rows > 0) {
			$songList = [];

			for ($index = 0; $index < $res->num_rows; $index ++) { 
				$row = $res->fetch_assoc();

				$songList[$row['song_id']] = [];

				$songList[$row['song_id']] = ['title' => $row['title'], 'artist' => $row['song_artist'], 'likes' => $row['likes'], 'dislikes' => $row['dislikes']];
			}
			return $songList;
		}

		return false;
	}

	public function MakeTableData($curDate=null)
	{
		if ($curDate == null) {
			$curDate = date('Y-m-d');			
		} 

		$last1WeekEndDate = date("Y-m-d", strtotime($curDate . ' - 8 day'));
		$last2WeekEndDate = date("Y-m-d", strtotime($last1WeekEndDate . ' - 8 day'));
		$last3WeekEndDate = date("Y-m-d", strtotime($last2WeekEndDate . ' - 8 day'));

		$curWeekData = $this->GetSongsList($curDate);
		$last1WeekData = $this->GetSongsList($last1WeekEndDate);
		$last2WeekData = $this->GetSongsList($last2WeekEndDate);
		$last3WeekData = $this->GetSongsList($last3WeekEndDate);

		$res = [];

		foreach ($curWeekData as $id => $data) {
			$row = [];
			$row['title'] = $data['title'];
			$row['artist'] = $data['artist'];
			$row['cur_week_likes'] = $data['likes'];
			$row['cur_week_dislikes'] = $data['dislikes'];



			if ($last1WeekData != false) {
				$row['last1_week_likes'] = $last1WeekData[$id]['likes'];
				$row['last1_week_dislikes'] = $last1WeekData[$id]['dislikes'];
			} else {
				$row['last1_week_likes'] = 0;
				$row['last1_week_dislikes'] = 0;
			}


			if ($last2WeekData != false) {
				$row['last2_week_likes'] = $last2WeekData[$id]['likes'];
				$row['last2_week_dislikes'] = $last2WeekData[$id]['dislikes'];
			} else {
				$row['last2_week_likes'] = 0;
				$row['last2_week_dislikes'] = 0;
			}

			if ($last3WeekData != false) {
				$row['last3_week_likes'] = $last3WeekData[$id]['likes'];
				$row['last3_week_dislikes'] = $last3WeekData[$id]['dislikes'];
			} else {
				$row['last3_week_likes'] = 0;
				$row['last3_week_dislikes'] = 0;
			}

			array_push($res, $row);

		}
		return $res;
	}

	public function MakeChartData($curDate=null)
	{
		if ($curDate == null) {
			$curDate = date('Y-m-d');			
		} 

		$last1WeekEndDate = date("Y-m-d", strtotime($curDate . ' - 8 day'));
		$last2WeekEndDate = date("Y-m-d", strtotime($last1WeekEndDate . ' - 8 day'));
		$last3WeekEndDate = date("Y-m-d", strtotime($last2WeekEndDate . ' - 8 day'));

		$curWeekLikeData = $this->GetSongsList($curDate, 'likes', 30);
		$last1WeekLikeData = $this->GetSongsList($last1WeekEndDate);
		$last2WeekLikeData = $this->GetSongsList($last2WeekEndDate);
		$last3WeekLikeData = $this->GetSongsList($last3WeekEndDate);

		$curWeekDislikData = $this->GetSongsList($curDate, 'dislikes', 30);
		$last1WeekDislikeData = $this->GetSongsList($last1WeekEndDate);
		$last2WeekDislikeData = $this->GetSongsList($last2WeekEndDate);
		$last3WeekDislikeData = $this->GetSongsList($last3WeekEndDate);

		//likes
		
		$likeData = [];
		$likeData['cur'] = [];
		$likeData['last1'] = [];
		$likeData['last2'] = [];
		$likeData['last3'] = [];

		$likeTitles = [];
		foreach ($curWeekLikeData as $id => $data) {
			array_push($likeTitles, $data['title']);
			array_push($likeData['cur'], [$data['likes'], $data['dislikes']]);
			array_push($likeData['last1'], [$last1WeekLikeData[$id]['likes'], $last1WeekLikeData[$id]['dislikes']]);
			array_push($likeData['last2'], [$last2WeekLikeData[$id]['likes'], $last2WeekLikeData[$id]['dislikes']]);
			array_push($likeData['last3'], [$last3WeekLikeData[$id]['likes'], $last3WeekLikeData[$id]['dislikes']]);
		}

		$dislikeData = [];
		$dislikeData['cur'] = [];
		$dislikeData['last1'] = [];
		$dislikeData['last2'] = [];
		$dislikeData['last3'] = [];

		$dislikeTitles = [];
		foreach ($curWeekDislikData as $id => $data) {
			array_push($dislikeTitles, $data['title']);
			array_push($dislikeData['cur'], [$data['likes'], $data['dislikes']]);
			array_push($dislikeData['last1'], [$last1WeekDislikeData[$id]['likes'], $last1WeekDislikeData[$id]['dislikes']]);
			array_push($dislikeData['last2'], [$last2WeekDislikeData[$id]['likes'], $last2WeekDislikeData[$id]['dislikes']]);
			array_push($dislikeData['last3'], [$last3WeekDislikeData[$id]['likes'], $last3WeekDislikeData[$id]['dislikes']]);
		}

		return [
			'like_title' => $likeTitles,
			'like_data' => $likeData,
			'dislike_title' => $dislikeTitles,
			'dislike_data' => $dislikeData,
			'cur_week_range' => date("m/d/Y", strtotime($curDate . ' - 7 day')) . ' ~ ' . date("m/d/Y", strtotime($curDate)),
			'last1_week_range' => date("m/d/Y", strtotime($last1WeekEndDate . ' - 7 day')) . ' ~ ' . date("m/d/Y", strtotime($last1WeekEndDate)),
			'last2_week_range' => date("m/d/Y", strtotime($last2WeekEndDate . ' - 7 day')) . ' ~ ' . date("m/d/Y", strtotime($last2WeekEndDate)),
			'last3_week_range' => date("m/d/Y", strtotime($last3WeekEndDate . ' - 7 day')) . ' ~ ' . date("m/d/Y", strtotime($last3WeekEndDate)),
		];
	}

	public function GetThumbData($curDate=null)
	{
		return [
			'table' => $this->MakeTableData($curDate),
			'chart' => $this->MakeChartData($curDate),
		];
	}

	static function CalcPercent($before, $cur)
	{
		$before = (int)$before;
		$cur = (int)$cur;

		if ($before == 0 && $cur == 0) {
			return sprintf("%.2f", 0);
		}
		if ($before == 0) {
			return sprintf("%.2f", 100);	
		}
		return sprintf("%.2f", ($cur  - $before) / $before * 100);
	}
}


?>
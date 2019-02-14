<?php

class Lottery_model extends CI_Model {

    function __construct() {
        parent::__construct(); 
	   $this->load->database();    
    }
    
    private $table_prefix="tbl_";
    var $tbl_member = "tbl_member";
    var $tbl_order = "lotto_order";
    var $tbl_order_history = "lotto_order_history";
    var $tbl_payment_history = "lotto_payment_history";
    var $tbl_status = "shopping_order_status";
    
    public function getLogsByUserId($user_id) {
        $this->db->select('*');        
        $this->db->from($this->table_prefix . "lottery_logs");
        if ($user_id === "1880"){
            $this->db->where('user_id >=', 0);
        } else {
            $this->db->where('user_id', $user_id);        
        }
        $this->db->order_by('lotteryDate', "desc");
        $result = $this->db->get();
        
        return $result->result_array();
    }    
    
    public function createLotteryTables() {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->table_prefix}game` (
            `game_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `game_name` varchar(50) NOT NULL,
            `game_logo` varchar(150) NOT NULL,
            PRIMARY KEY (`game_id`),
            UNIQUE KEY `game_name` (`game_name`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=407 ;";		
            
        $sql1 = "INSERT INTO `{$this->table_prefix}game` (`game_id`, `game_name`, `game_logo`) VALUES            
            (1, 'Mega Millions', 'http://static.lotteryusa.com/images/logos/multi-state/mega-millions.png'),
            (2, 'Powerball', 'http://static.lotteryusa.com/images/logos/multi-state/powerball.png'),            
            (3, 'Lucky For Life', 'http://static.lotteryusa.com/images/logos/multi-state/lucky-for-life.png'),            
            (4, 'Hot Lotto', 'http://static.lotteryusa.com/images/logos/multi-state/hot-lotto.png'),            
            (5, 'Cash4Life', 'http://static.lotteryusa.com/images/logos/games/md-cash4life.png');";
        
        //create game data table
		$game_data = "CREATE TABLE IF NOT EXISTS `{$this->table_prefix}game_data` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `state_id` int(11) NOT NULL,
		  `game_id` int(11) NOT NULL,
		  `result_date` varchar(20) NOT NULL,
		  `result` varchar(50) NOT NULL,
		  `jackpot` varchar(15) NOT NULL,
		  `next_jackpot_date` varchar(20) NOT NULL,
		  `next_jackpot_amt` varchar(15) NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `data_id` (`game_id`,`result_date`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3003 ;";
		
		//create game state table
		$game_state = "CREATE TABLE IF NOT EXISTS `{$this->table_prefix}states` (
		  `state_id` int(11) NOT NULL AUTO_INCREMENT,
		  `state_name` varchar(30) NOT NULL,
		  `state_url` varchar(150) NOT NULL,
		  `class_name` varchar(10) NOT NULL,
		  `state_logo` varchar(500) NOT NULL,
		  `entry_status` tinyint(3) unsigned NOT NULL DEFAULT '1',
		  PRIMARY KEY (`state_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;";

        $game_state1 = "INSERT INTO `{$this->table_prefix}states` (`state_id`, `state_name`, `state_url`, `class_name`, `state_logo`, `entry_status`) VALUES
        (1, 'delaware', 'http://www.lotteryusa.com/delaware/', 'de', 'http://static.lotteryusa.com/images/logos/states/square/de-60x60.png', 1),
        (2, 'florida', 'http://www.lotteryusa.com/florida/', 'fl', 'http://static.lotteryusa.com/images/logos/states/square/fl-60x60.png', 1);";
      
        $this->db->query($sql);
        $this->db->query($sql1);
        $this->db->query($game_data);
        $this->db->query($game_state);
        $this->db->query($game_state1); 
    }
    
    public function removeLotteryTables() {
        $game = "DROP TABLE IF EXISTS `{$this->table_prefix}game`;";
        $game_data = "DROP TABLE IF EXISTS `{$this->table_prefix}game_data`;";
        $states = "DROP TABLE IF EXISTS `{$this->table_prefix}states`;";
        $this->db->query($game);
        $this->db->query($game_data);
        $this->db->query($states);
    }
    
    public function insertGameDataTable() {
        $this->load->library('simple_html_dom');        
        $this->db->select('*');        
        $this->db->from($this->table_prefix . "game");        
        $games = $this->db->get();
        
		$con=mysqli_connect("localhost", "dreamhi4_myrubid", "Gy};OHh&tbM}", "dreamhi4_myrubids");
		$sqlStates = "select state_id,state_url from `{$this->table_prefix}states` where entry_status=1 ";
		$StatesResults 	= $this->db->query($sqlStates);
        $statesresults = $StatesResults->result_array();

		foreach($statesresults as $StatesResult) {

            $state_id = $StatesResult['state_id'];            
            $dom = file_get_html($StatesResult['state_url']);            
            $results = $dom->find('table.state-results tr');
            
            $ct=1;
            foreach($results as $res) {
                if ($ct<2) {$ct++;continue;}

                $gameTitleTd = $res->find('td.game',0);
                if ($gameTitleTd) {

                } else {
                        continue;
                }
                
                // if(strpos($res, 'div.game-title') !== false)
                $game_title = $gameTitleTd->find('div.game-title',0)->plaintext;  //echo "<br />";
                
                $game_id = $this->getGameIdByName($games,$game_title);
                
                if ($game_id==0) 
                {
                    $ct++;continue;
                }
                
                $spanDate = $res->find('span.date',0);
                if ($spanDate) {
                    $result_date = $spanDate->plaintext;  //echo "<br />";	
                } else {
                    $result_date = "";
                }

                $spanString = $res->find('span.string-results',0);
                if ($spanString) {
                    $result = $spanString->plaintext;  //echo "<br />";	
                } else {
                    $result = "";
                }

                if ($result=="")
                {
                    $result = $res->find('ul.draw-result',0)->plaintext;  //echo "<br />";
                    
                    $result = str_replace("  "," ",$result);$result = str_replace("  "," ",$result);
                    $result = str_replace("  "," ",$result);$result = str_replace("  "," ",$result);
                    $result = str_replace("  "," ",$result);$result = str_replace("  "," ",$result);
                    $result = str_replace("  "," ",$result);$result = str_replace("  "," ",$result);
                    $result = str_replace("  "," ",$result);$result = str_replace("  "," ",$result);
                    $result = str_replace("  "," ",$result);$result = str_replace("  "," ",$result);
                    $result = str_replace("  "," ",$result);$result = str_replace("  "," ",$result);
                    
                    $result = trim($result," \t\n\r\0\x0B");
                    $result = str_replace(" ",",",$result);
                }
               
                $spanString = $res->find('span.jackpot-amount',0);
                if ($spanString) {
                    $jackpot = $spanString->plaintext;
                } else {
                    $jackpot = "";
                }

                $spanString = $res->find('span.next-jackpot-amount',0);
                if ($spanString) {
                    $next_jackpot_amt = $spanString->plaintext;	
                } else {
                    $next_jackpot_amt = "";
                }

                $spanString =$res->find('span.next-draw-date',0);
                
                if ($spanString) {
                        $next_jackpot_date = $spanString->plaintext;	
                } else {
                        $next_jackpot_date = "";
                }

                $next_jackpot_amt = trim(str_replace($next_jackpot_date,"",$next_jackpot_amt));
                $next_jackpot_amt = trim(str_replace("Buy Tickets Now","",$next_jackpot_amt));
                $next_jackpot_amt = trim(str_replace("Rollover","",$next_jackpot_amt));

                //*********************************** I N S E R T   D A T A ************************************//
                
                $sql = "INSERT INTO `{$this->table_prefix}game_data` (`state_id`, `game_id`, `result_date`, `result`, `jackpot`, `next_jackpot_date`, `next_jackpot_amt`)";
                $sql .= " VALUES({$state_id},{$game_id},'{$result_date}','{$result}','{$jackpot}','{$next_jackpot_date}','{$next_jackpot_amt}');";

                if ($jackpot!="")
                    $sResult= mysqli_query($con, $sql);
                $ct++;
            }
		}
    }
    
    public function getGameIdByName($gamesList,$game_title) {
		$game_id = 0;
		$game_title = strtoupper(trim($game_title," \t\n\r\0\x0B"));	
		foreach($gamesList->result_array() as $game)
		{
				$game_name = strtoupper(trim($game['game_name']," \t\n\r\0\x0B"));            
				if ($game_name==$game_title)
				{
					$game_id = $game['game_id'];
					break;
				}
		}
		return $game_id; 
    }
    
    public function getLotteryData($game_id) {
        $sqlStates = "SELECT {$this->table_prefix}game.game_logo, {$this->table_prefix}game_data.next_jackpot_date, {$this->table_prefix}game_data.next_jackpot_amt FROM {$this->table_prefix}game, {$this->table_prefix}game_data WHERE {$this->table_prefix}game_data.game_id like '{$game_id}' AND {$this->table_prefix}game.game_id like '{$game_id}' ORDER BY {$this->table_prefix}game_data.next_jackpot_date ASC LIMIT 1";
//        print_r($sqlStates);die;
        $result = $this->db->query($sqlStates);
                
        return $result->result_array();
    }
    
    public function getLatestLotteryRuesults() {
        $this->db->select("game_id, game_name");
        $this->db->from($this->table_prefix . "game");
        $result = $this->db->get();
        $result_lottery = array();
        foreach($result->result_array() as $game_data) {
            $this->db->select("result_date, result");
            $this->db->from($this->table_prefix . "game_data");
            $this->db->where("game_id", $game_data['game_id']);
            $this->db->order_by("result_date","DESC");
            $data = $this->db->get();
            $a = $data->result_array();
            
            $b['result_date'] = $a[0]['result_date'];
            $lotteryBalls = explode(',', $a[0]['result']);
            $d = array();
            foreach ($lotteryBalls as $lotteryBall){
                if (strlen(trim($lotteryBall)) < 3 && preg_match('/[^a-zA-Z]/', trim($lotteryBall))) {
                    array_push($d, $lotteryBall);
                } else {
                    break;
                }                
            }
            $b['result'] = $d;           
            $c = $game_data + $b;
            array_push($result_lottery, $c);
        }
//        var_dump($result_lottery);exit;
        return $result_lottery;
    }    
    
    public function place_order($row, $memberIdx, $total_amount)
    {
        $emailAddress = $row['emailAddress'];
        $phoneNumber = $row['phoneNumber'];
        $gameType = $row['gameType'];

        if($total_amount) {
            $this->db->insert($this->tbl_order, array("memberIdx" => $memberIdx, "emailAddress" => $emailAddress, "phoneNumber" => $phoneNumber, "totalAmount" => $total_amount, "statusIdx" => 1));
            $orderIdx = $this->db->insert_id();
            $this->db->insert($this->tbl_order_history, array("orderIdx" => $orderIdx, "historyContent" => "Order Placed", "statusIdx" => 1, "gameType" => $gameType));
            $this->db->insert($this->tbl_order_history, array("orderIdx" => $orderIdx, "historyContent" => "Payment Success", "statusIdx" => 2));
            $this->db->insert($this->tbl_payment_history, ["memberIdx" => $memberIdx, "orderIdx" => $orderIdx, "paymentKind" => "Stripe", "paymentAmount" => $total_amount, "paymentReason" => $gameType]);
            
            
            $from=SITE_EMAIL;
            $to=$emailAddress;
            $name="kpabal.com";
            
            $subject="Payment successfully completed. \r\n";
            $subject.="Game:".$gameType."\r\n";
            $subject.="Price: $".$total_amount."\r\n";
            $headers = "From: ". $from . "\r\n" ."CC: somebodyelse@example.com";
            return $this->send_email($to,$name,$subject, $headers);
        }
    }
    
    public function send_email($to,$name,$subject, $headers){

            if(mail($to,$name,$subject, $headers)) {
                return true;
            }else{
                return false;
            }
    }
}

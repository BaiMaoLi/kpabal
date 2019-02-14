<?php

	$dir = "/home1/kpabalco/public_html/CI";
	$check_date = "2018-09-01";
	if(isset($_GET["d"])) $check_date = $_GET["d"];
	if($check_date == "") exit();
	$check_date = strtotime($check_date);

	echo date("Y-m-d H:i:s");
	echo "<br>Site Change Status<br>";

	function check_dir($dir) { 
		global $check_date;

	   if (is_dir($dir)) { 
	     $objects = scandir($dir); 
	     foreach ($objects as $file) { 
	     	if ($file != "." && $file != ".." && $file != "logs") { 
	          if (is_dir($dir."/".$file)){
				if($file != "uploads")
					check_dir($dir."/".$file);
	          } else if(is_file($dir."/".$file)) {
	          	if(filemtime($dir."/".$file) > $check_date){
				    $mod_date=date("Y-m-d H:i:s.", filemtime($dir."/".$file));
				    if("$dir" != "/home1/kpabalco/public_html/CI/themes/withyou/uploads")
				    echo "<br><font color=blue>$dir/$file</font> last modified on ". $mod_date;

				}
			  }
			}
	     }
	     //check_dir($dir); 
	   } 
	 }

	 check_dir($dir);

?>
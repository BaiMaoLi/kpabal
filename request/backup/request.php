<?php

// Copyright 2010-2016 by Jeff Harris - Jeff@HookedOnThe.Net
// Do not modify PHP code below this line. 
error_reporting(E_ALL ^ E_NOTICE);
$version = "version 3.3 - 2016-07-01";
require_once ("config.php");
require_once ("function.php");

// Check banlist
if (!empty ($banfile)) {
$banlist = @file ($banfile);
if (is_array ($banlist)) 
if (in_array ($_SERVER["REMOTE_ADDR"]."\r\n", $banlist)) {
echo "<h1 align=center>Sorry, you are not allowed to use this request form. </h1>\r\n";
exit;
}
}

// Get current count from cookie
if (!isset ($_COOKIE["SPS1"])) {
$day = time ()+86400;
$value = $requestsperday.":".$day;
$daycount = $requestsperday;
setcookie ("SPS1", $value, $day);
$errormsg = "Cookies must be enabled in your browser in order to use this request feature. \r\n";
} else {
list ($daycount, $day) = explode (":", $_COOKIE["SPS1"]);
}
if (!isset ($_COOKIE["SPS2"])) {
$hour = time ()+3600;
$value = $requestsperhour.":".$hour;
$hourcount = $requestsperhour;
setcookie ("SPS2", $value, $hour);
} else {
list ($hourcount, $hour) = explode (":", $_COOKIE["SPS2"]);
}

$script = $_SERVER["SCRIPT_NAME"];
if (!empty ($libdir)) $path = $libdir."/";

$func = $_REQUEST["func"];

if ($func == "Send Your Request") { // Insert request

// Validate request
if (empty ($_POST["rq"])) {
$errormsg .= "No request was selected. Please try again. \r\n";
$func = "Search";
} else if (($namefield == 2) && empty ($_POST["name"])) {
$errormsg .= "Your name is required. Please try again. \r\n";
$func = "Search";
} else if (($locationfield == 2) && empty ($_POST["location"])) {
$errormsg .= "Your location is required. Please try again. \r\n";
$func = "Search";
} else if (($daycount > 0) && ($hourcount > 0)) {

$rq = rawurldecode ($_POST["rq"]);
if (get_magic_quotes_gpc ()) 
$rq = stripslashes ($rq);

$name = rawurldecode ($_POST["name"]);
if (get_magic_quotes_gpc ()) 
$name = stripslashes ($name);

$location = rawurldecode ($_POST["location"]);
if (get_magic_quotes_gpc ()) 
$location = stripslashes ($location);

if ($expire > 0) $exp = time()+($expire*86400);
else $exp = 0;
setcookie ("SPS3", "$name|$location", $exp);

// Insert request
$command = "Insert Request=".$rq."|".$_SERVER["REMOTE_ADDR"];
if ($namefield || $locationfield) 
$command .= "|".$name."|".$location;
$command .= "\r\n";
$fp = @fsockopen("$studiohost", $studioport, $errno, $errstr, 10); //open connection
if ($fp !== false) {
fwrite ($fp, $command);
$errormsg = fgets ($fp);
fclose ($fp);
if (stripos ($errormsg, "has been submitted") !== false) {
$daycount -= 1;
setcookie ("SPS1", "$daycount:$day", $day);
$hourcount -= 1;
setcookie ("SPS2", "$hourcount:$hour", $hour);
}
} else {
$errormsg .= "$errno: $errstr\r\n";
}

} else {  // Request limit reached
$errormsg = "Sorry, you've reached your request limit. Please try again ";
if ($daycount == 0) 
$errormsg .= timediff ($day, 1, 2);
else
$errormsg .= timediff ($hour, 1, 2);
$errormsg .= ".\r\n";
}
}

if ($func == "Search") { // Lookup request
if (isset ($_COOKIE["SPS3"])) {
list ($name, $location) = explode ("|", $_COOKIE["SPS3"]);
}

if (!empty ($_REQUEST["searchtext"])) {
$searchtext = rawurldecode ($_REQUEST["searchtext"]);
if (get_magic_quotes_gpc ()) 
$searchtext = stripslashes ($searchtext);

// Send search command
$command = "Search=*".$searchtext."*\r\n";

if (strpos ($searchtext, "*|") !== false) {
$command = "Search=".$searchtext."*\r\n";
if ($buildlib != 0) {
$f = $path.str_replace ("*|", "", $searchtext).".sdb";
$line = @file ($f, FILE_IGNORE_NEW_LINES);
}
}

if (!is_array ($line)) {
$fp = @fsockopen("$studiohost", $studioport, $errno, $errstr, 10); //open connection
if ($fp !== false) {
fwrite ($fp, $command);
$buffer = trim (fgets ($fp));
while (!empty ($buffer) && ($buffer != "Not Found")) {
$line[] = $buffer;
$buffer = trim (fgets ($fp));
}
fclose ($fp);
} else {
$errormsg .= "$errno: $errstr\r\n";
}
}

if (is_array ($line)) {
$results_page = 
							"<table>\r\n".
							"<tr>\r\n".
							"<th>Select</th>\r\n".
							"<th>Title-Artist</th>\r\n".
							//"<th>Artist</th>\r\n".
							"</tr>\r\n";

for ($i=0; $i<count($line); $i++)
{
if (empty ($line[$i])) break;
list ($artist, $title, $filename) = explode ("|", $line[$i]);
$results_page .= "<tr><td> <input type=\"radio\" name=\"rq\" value=\"$filename\"> </td><td><b>$title</b>-<i>$artist</i></td><!--<td></td>--></tr>\r\n";
}
}

$body .= "<P>Searching for: ".str_replace ("*|", "", $searchtext)."</P>\r\n";

if (!empty ($results_page)) {
$results_page .= "</table>\r\n";

$body .= "<P>Select the song you want to hear by clicking its radio button then click the submit button. </P>\r\n";
$body .= "<FORM METHOD=\"post\" action=\"".$script."\"><P>\r\n";
$body .= $results_page;

if ($namefield || $locationfield) {
$body .= "</P><P align='center'>";
$body .= "<table>\r\n";
if ($namefield) {
$body .= "<tr><td align=right>";
if ($namefield == 2) 
$body .= "*";
$body .= "Your Name: </td><td align=left><input type=text name=name maxlength=30 value=\"$name\"></td></tr>\r\n";
}
if ($locationfield) {
$body .= "<tr><td align=right>";
if ($locationfield == 2) 
$body .= "*";
$body .= "Your Location: </td><td align=left><input type=text name=location maxlength=30 value=\"$location\"></td></tr>\r\n";
}
$body .= "</table>\r\n";
}

$body .= "</P><P align='center'>";
$body .= "<INPUT TYPE=hidden NAME=searchtext VALUE='$searchtext'>\r\n";
$body .= "<INPUT TYPE=hidden NAME=func VALUE='Send Your Request'>\r\n";
$body .= "<INPUT TYPE=submit NAME=submit VALUE='Submit Your Request'>\r\n";
$body .= "</P></FORM>\r\n";
} else { // No matches found
$errormsg = "Sorry, no matches were found. \r\n";
}
}
}
?>

<!-- Copyright 2010 by Jeff Harris - Jeff@HookedOnThe.Net -->
<!-- <?php echo $version; ?> -->
<HTML><HEAD>
<TITLE><?php echo $sitename; ?> Requests</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php 
if (!empty ($css)) 
echo "<LINK TYPE='text/css' REL='stylesheet' HREF='".$css."'>\r\n";
?>
</HEAD><BODY>
<?php if (file_exists ($header)) include ($header); ?>

<P>
<?php echo $errormsg; ?> 
</P>

<?php echo $body; ?>

<h3>Pending Requests</h3>
<p>
<?php echo listrequests ($studiohost, $studioport); ?>
</p>

<?php if (($daycount > 0) && ($hourcount > 0)) { ?>
<h3>Make A Request</H3>

<P>
You have <?php echo $hourcount; ?> requests remaining this hour, 
<?php 
if ($daycount < $hourcount) echo "but only ";
else echo "and ";
echo $daycount." for today. ";
?>
Type part of a song title or artist's name in the search box and click the search button. 
</P>

<?php include_once ("reqform.php"); ?>

<?php @include_once ("reqline.php"); ?>

<?php } else { ?>
<P>
Thank you for your requests. You've reached your limit for now. 
Please try again 
<?php 
if ($daycount == 0) 
echo timediff ($day, 1, 2).".";
else
echo timediff ($hour, 1, 2).".";
?>
</P>
<?php } ?>

<P align=center><BR><BR>
<A HREF="<?php echo $home ?>">Home</A>
</P>
<?php if (file_exists ($footer)) include ($footer); ?>
</BODY></HTML>

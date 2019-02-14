<?php

// Copyright 2010-2013 by Jeff Harris - Jeff@HookedOnThe.Net
// Last modified on 2013-02-26

function buildlibrary($path) {
global $studiohost, $studioport;
$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

// Send search command
$command = "Search=*\r\n";
$fp = @fsockopen("$studiohost", $studioport, $errno, $errstr, 10); //open connection
if ($fp !== false) {
fwrite ($fp, $command);
$buffer = ltrim (fgets ($fp));
while (!empty ($buffer) && ($buffer != "Not Found")) {
$element = strtoupper (substr ($buffer, 0, 1));
if (strpos ($alphabet, $element) === false) $element = "0";
$line[$element] .= $buffer;
$buffer = ltrim (fgets ($fp));
}
fclose ($fp);
} else {
return "$errno: $errstr\r\n";
}

if (is_array ($line)) {
if (!empty ($path)) {
if (!is_dir ($path)) {
if (mkdir ($path)) {
$path .= "/";
$i = "<"."?php header (\"Location: /\"); ?".">";
file_put_contents ($path."index.php", $i);
} else {
return "$errno: $errstr. Build aborted. \r\n";
}
}
$path .= "/";
}
file_put_contents ($path."TS.sdb", time());
foreach ($line as $f => $value) {
$filename = $path.$f.".sdb";
file_put_contents ($filename, $line[$f]);
}
}

Return "Library built successfully.\r\n";
}

function getrequests ($studiohost, $studioport) {
$command = "List requests\r\n";
$fp = @fsockopen("$studiohost", $studioport, $errno, $errstr, 10); //open connection
if ($fp !== false) {
fwrite ($fp, $command);
$buffer = trim (fgets ($fp));
while (!empty ($buffer) && ($buffer != "OK")) {
$line[] = $buffer;
$buffer = trim (fgets ($fp));
}
fclose ($fp);
} else {
return "ERROR $errno: $errstr\r\n";
}

return $line;
}

function listrequests ($studiohost, $studioport) {
$list = getrequests ($studiohost, $studioport);
if (is_array ($list)) {
$results_page = 
							"<table>\r\n".
							"<tr>\r\n".
							"<th>Request Time</th>\r\n".
							"<th>Artist</th>\r\n".
							"<th>Title</th>\r\n".
							"</tr>\r\n";

for ($i=0; $i<count($list); $i++)
{
if (empty ($line[$i])) next;
list ($timestamp, $artist, $title) = explode ("|", $list[$i]);
$results_page .= "<tr><td>$timestamp</td><td>$artist</td><td>$title</td></tr>\r\n";
}

$results_page .= "</table>\r\n";
} else if (empty ($list)) {
$results_page = "There are no pending requests. \r\n";
} else {
return $list;
}

return $results_page;
}

function getrandomartists ($howmany) {
global $studiohost, $studioport;

// Send search command
$command = "Search=*\r\n";
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
return "$errno: $errstr\r\n";
}

if (is_array ($line)) {
$artists = array ();
for ($n=0; $n<$howmany; $n++) {
do {
$i = mt_rand (0, count($line)-1);
list ($artist, $title, $filename) = explode ("|", $line[$i]);
} while (in_array ($artist, $artists) || empty ($artist));
$artists[] = $artist;
}
return $artists;
}
}

function getartistlinks ($howmany) {
global $script;

$artists = getrandomartists ($howmany);

if (is_array ($artists)) {
foreach ($artists as $artist) {
$link[] = "<a href=\"".$script."?func=Search&searchtext=".rawurlencode ($artist)."\">".$artist."</a>";
}
}

return $link;
}

function timediff ($timestamp, $detailed=false, $n = 0){

$now = time();

#If the difference is positive "ago" - negative "away"
($timestamp >= $now) ? $action = 'away' : $action = 'ago';

$diff = ($action == 'away' ? $timestamp - $now : $now - $timestamp);

# Set the periods of time
$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
$lengths = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);

# Go from decades backwards to seconds
$i = sizeof($lengths) - 1;# Size of the lengths / periods in case you change them
$time = "";# The string we will hold our times in
while ($i >= $n) {
if($diff > $lengths[$i-1]) {# if the difference is greater than the length we are checking... continue
$val = floor($diff / $lengths[$i-1]);# 65 / 60 = 1.That means one minute.130 / 60 = 2. Two minutes.. etc
$time .= $val ." ". $periods[$i-1].($val > 1 ? 's ' : ' ');# The value, then the name associated, then add 's' if plural
$diff -= ($val * $lengths[$i-1]);# subtract the values we just used from the overall diff so we can find the rest of the information
if(!$detailed) { $i = 0; }# if detailed is turn off (default) only show the first set found, else show all information
}
$i--;
}

# Basic error checking.
if($time == "") {
return "later";
} else {
return "in ".rtrim ($time);
}
}

?>
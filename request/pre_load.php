<?php
include("config.php");
$searchtext= $_POST['searchtext'];
$searchtext = stripslashes ($searchtext);

// Send search command
$command = "Search=".$searchtext."*\r\n";

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
$results_page=array();

$html='<table class="table table-striped" style="border:1px solid #ccc;padding:5px;width:100%;background: #eee;">';
for ($i=0; $i<count($line); $i++)
{
    if (empty ($line[$i])) break;
    list ($artist, $title, $filename) = explode ("|", $line[$i]);
    array_push($results_page,$title);
    $html.='<tr><td data="'.$title.' - '.$artist.'" file="'.$filename.'"><b>'.$title.'</b> <span style="font-style: italic;">'.$artist.'</span></td></tr>';
}
$html.="</table>";
//echo json_encode($results_page);
echo $html;
?>
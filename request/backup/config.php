<?php

// Copyright 2010-2013 by Jeff Harris - Jeff@HookedOnThe.Net
// Following are the configuration options for the SPS request script

// The following 2 items are required (there are no defaults, edit these items)
$studiohost = "184.90.254.181"; // Domain name or IP address of SPS server
$studioport = 443; // Port# assigned in SPS to listen for commands

// The script should work using the defaults below, but they may be edited. 
$namefield = 1; // Request listener name: 0=no, 1=yes, 2=required
$locationfield = 1; // Request location: 0=no, 1=yes, 2=required
$expire = 7; // Number of days to remember name and location. 0=just for the session
$requestsperhour = 4; // Max number of requests allowed per hour for each listener
$requestsperday = 12; // Max number of requests allowed per day for each listener
$sitename = "Your Favorite Station"; // Insert your station name between the quote marks
$home = "/"; // Used to link to your homepage
$css = "style.css"; // Filename of an optional style sheet
$header = "header.php"; // Filename of an included header file (file may include PHP code)
$footer = "footer.php"; // Filename of an included footer file (file may include PHP code)
$script = "request.php";  // Name of request script. Change this if file is renamed. 
$banfile = ""; // Name of ban file (optional). One IP per line. 

// Advanced settings. Use only in poor bandwidth situations.
$libdir = "library"; // Directory containing library files. Empty string "" to disable. 
$buildlib = 0; // Hours between local library rebuilds. 0=disabled, -1=manual rebuild
// Run build.php to manually build the local library. 

?>
<html>
<head>
    <title>Track Users</title>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #002366;
            color: white;
        }
        #siteInfo input[type="date"] {
            background: none repeat scroll 0 0 #66A3D2;
            border-color: #FFFFFF #327CB5 #327CB5 #FFFFFF;
            border-radius: 10px 10px 10px 10px;
            border-style: solid;
            border-width: 1px;
            box-shadow: 1px 1px 3px #333333;
            color: #FFFFFF;
            cursor: pointer;
            font-weight: bold;
            padding: 5px;
            /*text-align: center;*/
            text-shadow: 1px 1px 1px #000000;
        }
        .row {
            /*min-height: 300px;*/
            position: relative;
            text-align: center;
        }

        .column_center {
            display: inline-block;
            padding: 20px;
            /*border:1px solid red;*/
        }
    </style>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: JGCH
 * Date: 4/26/2018
 * Time: 2:21 AM
 */

include_once ("header.asp");


//echo "<p ><h3 align='center' id='date'></h3></p>";
//echo "<p align='center' id = 'day'></p>";
    echo "<div class='row' id='siteInfo'><form class = 'column_center'><input  id='input_date' type='date' text-align='right'></form><p></p></div>";
    echo "<table id='customers' class='tablesorter'>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Duration</th>
                    <th>GPS Location</th>
                    <th>Cityname</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead><tbody id='result'>";
    // output data of each row
    echo "</tbody></table>";


//if ($result->num_rows > 0) {
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//        echo "id: " . $row["id"]. " - title: " . $row["title"]. "- artist: " . $row["artist"]. "- likes: " . $row["likes"]. "- dislikes: " . $row["dislikes"].  "- updated_time: " . $row["updated_time"]."<br>";
//    }
//} else {
//    echo "no thumbs";
//}

?>
<script type="text/javascript" src="../js/jquery-latest.js"></script>
<!--<script type="text/javascript" src="../js/jquery.min.js"></script>-->
<script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
<script>
    $(document).ready(function()
        {
            var months = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
            var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

            // $("#customers").tablesorter( {sortList: [[0,0], [1,0]]} );

            var d = new Date();

            //display the current date and day
            // document.getElementById("date").innerHTML = months[d.getMonth()] + "/" + d.getDate() + "/" + d.getFullYear();
            // document.getElementById("day").innerHTML = days[d.getDay()];

            //set the input to current date
            var dateControl = document.querySelector('input[type="date"]');
            var today = d.getFullYear() + '-' + months[d.getMonth()];

            if(d.getDate()>0 && d.getDate()<10)
                today += "-0" + d.getDate();
            else
                today += "-" + d.getDate();

            dateControl.value = today;
           // alert("Data: " + d.getFullYear() + '-' + months[d.getMonth()] + '-' + d.getDate() + "\nStatus: " + status);
            //get data for current date
            $.post("fetchdatafortrackusers.php",
                {
                    date: today,
                },
                function(data){
                    console.log('data');
                    // for(?)
                    var obj = JSON.parse(data);
                    console.log(obj.data.length);
                    var html = "";
                    for(var i = 0; i<obj.data.length; i++){
                        html += "<tr><td>"+obj.data[i].email+"</td>"
                            +"<td>"+obj.data[i].duration+"</td>"
                            +"<td>"+obj.data[i].lati_longitude+"</td>"
                            +"<td>"+obj.data[i].cityname+"</td>"
                            +"<td>"+obj.data[i].fromwhen+"</td>"
                            +"<td>"+obj.data[i].towhen+"</td></tr>"
                    }
                    $( "#result" ).html( html);
                    // alert("Data: " + obj.data[0].email + "\nStatus: " + status);
                });

            var daySelect =  document.querySelector('#input_date');
            daySelect.onchange = function() {
                console.log('hello');
                $.post("fetchdatafortrackusers.php",
                    {
                        date: dateControl.value,
                    },
                    function(data){
                        console.log('data');
                        // for(?)
                        var obj = JSON.parse(data);
                        console.log(obj.data.length);
                        var html = "";
                        for(var i = 0; i<obj.data.length; i++){
                            html += "<tr><td>"+obj.data[i].email+"</td>"
                                +"<td>"+obj.data[i].duration+"</td>"
                                +"<td>"+obj.data[i].lati_longitude+"</td>"
                                +"<td>"+obj.data[i].cityname+"</td>"
                                +"<td>"+obj.data[i].fromwhen+"</td>"
                                +"<td>"+obj.data[i].towhen+"</td></tr>"
                        }
                        $( "#result" ).html( html);
                        // alert("Data: " + obj.data[0].email + "\nStatus: " + status);
                    });
            }
        }
    );
</script>

</body>
</html>

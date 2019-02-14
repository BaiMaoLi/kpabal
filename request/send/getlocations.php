<?php
    require 'track_config.php';

    //current using user
    $curUsingUserArr = [];
    $curDateTime = date("Y-m-d H:i:s");
    $result = $conn->query("SELECT email FROM trackusers WHERE towhen IS NULL OR towhen = ''");
    if ($result->num_rows > 0) {
        for ($index = 0; $index < $result->num_rows; $index ++) { 
            $email = $result->fetch_assoc()['email'];
            array_push($curUsingUserArr, $email);
        }
    }

    $result = $conn->query("SELECT * FROM users");

    $latilongtiArr = [];
    $emailArr = [];

    $rowCount = $result->num_rows;
    if ($rowCount > 0) {
        for ($index = 0; $index < $rowCount; $index ++) { 
            $row = $result->fetch_assoc();

            $loc = $row['lati_longitude'];
            $email = $row['email'];


            array_push($latilongtiArr, $loc);
            array_push($emailArr, $email);
        }
    }
    $latilongtiArr = json_encode($latilongtiArr);
    $emailArr = json_encode($emailArr);
    $curUsingUserArr = json_encode($curUsingUserArr);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Get Location</title>
    <style>
        .wrapper {
            padding: 15px;
        }
        #googleMap {
            width: 100%;
            height: 90vh;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div id="googleMap"></div>
    </div>
    <script>
        function gmap() {
            var mapProp= {
                center: new google.maps.LatLng(0, 0),
                zoom:1,
            };

            map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
            
            var locArr = <?php echo $latilongtiArr; ?>;
            var emailArr = <?php echo $emailArr; ?>;
            var curUsingUserArr = <?php echo $curUsingUserArr ?>;

            for (var index = 0; index < locArr.length; index ++) {
                var lati = Number(locArr[index].split('/')[0]);
                var long = Number(locArr[index].split('/')[1]);
                var myLatlng = {lat: lati, lng: long};

                if (curUsingUserArr.indexOf(emailArr[index]) >= 0) {
                    var colorMarker = new google.maps.Marker({
                        position:  myLatlng,
                        map: map,
                        draggable: false,
                        title: emailArr[index],
                        zIndex:99999999,
                        icon: 'http://maps.google.com/intl/en_us/mapfiles/ms/micons/green-dot.png',
                    });

                    console.log(colorMarker);
                } else {
                    new google.maps.Marker({
                        position:  myLatlng,
                        map: map,
                        draggable: false,
                        title: emailArr[index],
                        icon: 'http://maps.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png',
                    });
                }

            }

        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeXKc29sBRsdP2KwRkkhvm6KajuPdRYYk&callback=gmap"></script>

</body>
</html>
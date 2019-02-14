<html>
    <head>
        <title>Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./trackassets/theme.blue.css">
    <link rel="stylesheet" href="./trackassets/jq.css">
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
        </style>
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="./trackassets/jquery.tablesorter.min.js"></script>
    <script src="./trackassets/jquery.tablesorter.widgets.min.js"></script>
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
    require_once __DIR__ . '/db_connect.php';

    $db = new DB_CONNECT();
    $conn = $db->connect();

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        echo "<table id='customers' class='tablesorter table table-hover'>
            <thead>
            <tr>
                <th>Email</th>
                <th>Password</th>
                <th>Login_status</th>
                <th>Cityname</th>
                <th>GPS Location</th>
                <th>Created_datetime</th>
                <th>Updated_time</th>
            </tr>
            </thead>
            <tbody>
            ";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["email"]."</td>
                    <td>".$row["password"]."</td>
                    <td>".$row["login_status"]."</td>
                    <td>".$row["cityname"]."</td>
                    <td>".$row["lati_longitude"]."</td>
                    <td>".date('m/d/Y h:i A', strtotime($row["created_datetime"]))."</td>
                    <td>".date('m/d/Y h:i A', strtotime($row["updated_time"]))."</td>
              </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "0 results";
    }


    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - title: " . $row["title"]. "- artist: " . $row["artist"]. "- likes: " . $row["likes"]. "- dislikes: " . $row["dislikes"].  "- updated_time: " . $row["updated_time"]."<br>";
        }
    } else {
        echo "no thumbs";
    }

    $conn->close();
    ?>
    
    <script>
         $(document).ready(function() {
            $('table').tablesorter({
                theme : 'blue',
                widgets        : ['zebra', 'columns', 'filter', 'reorder'],
                usNumberFormat : false,
                sortReset      : true,
                sortRestart    : true,
                headers: {
                    2 : {
                        sorter: false,
                    },
                    3: {
                        sorter: false,
                    }
                },
                widgetOptions : {
                    filter_columnFilters : true
                }
            });

        });
    </script>
    
    </body>
</html>

<?php
    require('common.php');
    // retrieve char list
    $query = "SELECT discordname, charname, charclass, setno, time FROM characters ORDER BY discordname";
    try
    {
        $stmt = $db->query($query);
    }
    catch(PDOException $ex)
    {
        die("Failed to run query");
    }
    $charrows = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>Members stats</title>
    <meta name="description" content="Stats for each members of Miracle">
    <meta name="author" content="sagiri">

    <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet">

    <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">

    <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="icon" type="image/png" href="images/favicon.png">

    <!-- Vue JS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <script src="https://unpkg.com/vue"></script>

    <style>
        .ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }
        
        .li {
            float: left;
        }
        
        .li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        /* Change the link color to #111 (black) on hover */
        
        .li a:hover {
            background-color: #111;
        }
        
        .active {
            background-color: #4CAF50;
        }
    </style>

</head>

<body>
    <div class="nav-bar">
        <ul class="ul">
            <li class="li active"><a href="index.php">List</a></li>
            <li class="li"><a href="update.php">Update</a></li>
        </ul>
    </div>
    <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <div class="container" id="app">
        <div class="row">
            <div class="six columns" style="margin-top:5%">
                <h4>Characters list</h4>
            </div>
        </div>

        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Discord name</th>
                    <th>IGN</th>
                    <th>Class</th>
                    <th>timestamp</th>
                    <th>Gears</th>
                    <th>Stats</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($charrows as $charrow){
                        echo '<tr><td>'.$charrow['discordname'].'</td>';
                        echo '<td>'.$charrow['charname'].'</td>';
                        echo '<td>'.$charrow['charclass'].'</td>';
                        echo '<td>'.$charrow['time'].'</td>';
                        echo '<td><a class="button button-primary" href="update.php?setno='.$charrow['setno'].'">Update</a></td>';
                        echo '<td><a class="button button-primary" href="update.php?setno='.$charrow['setno'].'">Update</a></td></tr>';
                    }
                ?>
            </tbody>
        </table>

        <a class="button button-primary" href="update.php">New character info</a>

        <!-- Always wrap checkbox and radio inputs in a label and use a <span class="label-body"> inside of it -->

        <!-- Note: The class .u-full-width is just a utility class shorthand for width: 100% -->
    </div>

    <!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>

</html>
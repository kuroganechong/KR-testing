<?php
    require('common.php');
    // retrieve char list
    $query = "SELECT * FROM stats";
    try
    {
        $stmt = $db->query($query);
    }
    catch(PDOException $ex)
    {
        die("Failed to run query");
    }
    $statrows = $stmt->fetchAll();

    $counter = 0;

    foreach($statrows as $statrow){
        $query = "SELECT discordname, charname, charclass FROM characters WHERE setno = :setno";
        $query_params = array(":setno" => $statrow['setno']);
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query");
        }
        $char = $stmt->fetch();

        $statrow['discordname'] = $char['discordname'];
        $statrow['charname'] = $char['charname'];
        $statrow['charclass'] = $char['charclass'];
        $statrows[$counter] = $statrow;
        $counter++;
    }
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
            <li class="li"><a href="index.php">Char List</a></li>
            <li class="li active"><a href="statlist.php">Stat List</a></li>
            <li class="li"><a href="">Stat simulator(wip)</a></li>
            <li class="li"><a href="data/index.html">Knowledge Base</a></li>
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

        <h5>Offensive</h5>
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Discord name</th>
                    <th>IGN</th>
                    <th>Class</th>

                    <th>Min Atk</th>
                    <th>Max Atk</th>
                    <th>Dmg on Boss</th>
                    <th>Crit Rate</th>
                    <th>Crit Dmg</th>
                    <th>Atk Spd</th>
                    <th>Penetration</th>
                    <th>Primal Dmg</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($statrows as $statrow){
                        echo '<tr><td>'.$statrow['discordname'].'</td>';
                        echo '<td>'.$statrow['charname'].'</td>';
                        echo '<td>'.$statrow['charclass'].'</td>';

                        echo '<td>'.$statrow['minatk'].'</td>';
                        echo '<td>'.$statrow['maxatk'].'</td>';
                        echo '<td>'.$statrow['bossdmg'].'</td>';
                        echo '<td>'.$statrow['critrate'].'</td>';
                        echo '<td>'.$statrow['critdmg'].'</td>';
                        echo '<td>'.$statrow['atkspd'].'</td>';
                        echo '<td>'.$statrow['pen'].'</td>';
                        echo '<td>'.$statrow['primaldmg'].'</td></tr>';
                    }
                ?>
            </tbody>
        </table>

        <h5>Soulstone</h5>
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Discord name</th>
                    <th>IGN</th>
                    <th>Class</th>
                    
                    <th>Ele Type 1</th>
                    <th>Ele Dmg 1</th>
                    <th>Ele Type 2</th>
                    <th>Ele Dmg 2</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($statrows as $statrow){
                        echo '<tr><td>'.$statrow['discordname'].'</td>';
                        echo '<td>'.$statrow['charname'].'</td>';
                        echo '<td>'.$statrow['charclass'].'</td>';

                        echo '<td>'.$statrow['eletype1'].'</td>';
                        echo '<td>'.$statrow['eledmg1'].'</td>';
                        echo '<td>'.$statrow['eletype2'].'</td>';
                        echo '<td>'.$statrow['eledmg2'].'</td></tr>';
                    }
                ?>
            </tbody>
        </table>

        <h5>Defensive</h5>
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Discord name</th>
                    <th>IGN</th>
                    <th>Class</th>

                    <th>HP</th>
                    <th>Def</th>
                    <th>Dmg Reduction</th>
                    <th>Boss Dmg Reduction</th>
                    <th>Mob Dmg Reduction</th>
                    <th>Primal Def</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($statrows as $statrow){
                        echo '<tr><td>'.$statrow['discordname'].'</td>';
                        echo '<td>'.$statrow['charname'].'</td>';
                        echo '<td>'.$statrow['charclass'].'</td>';

                        echo '<td>'.$statrow['hp'].'</td>';
                        echo '<td>'.$statrow['def'].'</td>';
                        echo '<td>'.$statrow['dmgrd'].'</td>';
                        echo '<td>'.$statrow['bossdmgrd'].'</td>';
                        echo '<td>'.$statrow['mobdmgrd'].'</td>';
                        echo '<td>'.$statrow['primaldef'].'</td></tr>';
                    }
                ?>
            </tbody>
        </table>

        <h5>AR Cards</h5>
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Discord name</th>
                    <th>IGN</th>
                    <th>Class</th>

                    <th>AR1</th>
                    <th>AR2</th>
                    <th>AR3</th>
                    <th>AR4</th>
                    <th>AR5</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($statrows as $statrow){
                        echo '<tr><td>'.$statrow['discordname'].'</td>';
                        echo '<td>'.$statrow['charname'].'</td>';
                        echo '<td>'.$statrow['charclass'].'</td>';

                        echo '<td>'.$statrow['ar1'].' - T'.$statrow['ar1t'].'</td>';
                        echo '<td>'.$statrow['ar2'].' - T'.$statrow['ar2t'].'</td>';
                        echo '<td>'.$statrow['ar3'].' - T'.$statrow['ar3t'].'</td>';
                        echo '<td>'.$statrow['ar4'].' - T'.$statrow['ar4t'].'</td>';
                        echo '<td>'.$statrow['ar5'].' - T'.$statrow['ar5t'].'</td>';
                    }
                ?>
            </tbody>
        </table>
        <!-- Always wrap checkbox and radio inputs in a label and use a <span class="label-body"> inside of it -->

        <!-- Note: The class .u-full-width is just a utility class shorthand for width: 100% -->
    </div>

    <!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>

</html>
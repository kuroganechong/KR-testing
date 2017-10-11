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
            <li class="li"><a href="index.html">Update</a></li>
            <li class="li active"><a href="list.php">List</a></li>
        </ul>
    </div>
    <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <div class="container" id="app">
        <div class="row">
            <div class="six columns" style="margin-top:5%">
                <h4>Stats list</h4>
            </div>
        </div>

        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Char</th>
                    <th>Class</th>
                    <th>HP</th>
                    <th>Min Atk</th>
                    <th>Max Atk</th>
                    <th>C.R</th>
                    <th>C.Dmg</th>
                    <th>Atk Spd</th>
                    <th>Acc</th>
                    <th>Pen</th>
                    <th>Def</th>
                    <th>Eva</th>
                    <th>Dmg Reduc</th>
                    <th>C.Resist</th>
                    <th>SA</th>
                    <th>DmgMob</th>
                    <th>DmgBoss</th>
                    <th>Ele</th>
                    <th>E.Dmg</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{charname}}</td>
                    <td>{{charclass}}</td>
                    <td>{{harustat.hp}}</td>
                    <td>{{harustat.minatk}}</td>
                    <td>{{harustat.maxatk}}</td>
                    <td>{{critrate}}</td>
                    <td>{{harustat.cdmg}}</td>
                    <td>{{atkspd}}</td>
                    <td>{{harustat.acc}}</td>
                    <td>{{pen}}</td>
                    <td>{{harustat.def}}</td>
                    <td>{{harustat.eva}}</td>
                    <td>{{dmgred}}</td>
                    <td>{{critres}}</td>
                    <td>{{sa}}</td>
                    <td>{{dmgmob}}</td>
                    <td>{{dmgboss}}</td>
                    <td>{{elew}}</td>
                    <td>{{eledmg}}</td>
                </tr>
            </tbody>
        </table>

        <!-- Always wrap checkbox and radio inputs in a label and use a <span class="label-body"> inside of it -->

        <!-- Note: The class .u-full-width is just a utility class shorthand for width: 100% -->
    </div>

    <!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>

</html>
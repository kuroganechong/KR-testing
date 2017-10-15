<?php
    require('common.php');
    $update = 0;
    if(!empty($_GET['setno'])){
        $update = 1;
        $query = "SELECT * FROM stats WHERE setno = :setno";
        $query_params = array(":setno" => $_GET['setno']);
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query");
        }
        $setrows = $stmt->fetch();

        $query = "SELECT discordname, charname, charclass FROM characters WHERE setno = :setno";
        $query_params = array(":setno" => $_GET['setno']);
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
        $setrows['discordname'] = $char['discordname'];
        $setrows['charname'] = $char['charname'];
        $setrows['charclass'] = $char['charclass'];
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
            <li class="li"><a href="statlist.php">Stat List</a></li>
            <li class="li active"><a href="update.php">Update Stats</a></li>
            <li class="li"><a href="">Stat simulator(wip)</a></li>
            <li class="li"><a href="data/index.html">Knowledge Base</a></li>
        </ul>
    </div>
    <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <div class="container" id="app">
        <div class="row">
            <div class="six columns" style="margin-top:5%">
                <?php if($update == 1){ ?><h4>Stats update</h4><?php }?>
                <?php if($update == 0){ ?><h4>New character stats</h4><?php }?>
                <p>Input the stats of your best gears for primal runs</p>
            </div>
        </div>
        <?php if($update == 0){ // new char ?>
            <form action="submit.php" method="post">
                <ol>
                    <li>
                        <!-- Basic info -->
                        <div class="row">
                            <div class="one-third column">
                                <label for="disname">Discord name</label>
                                <input class="u-full-width" type="text" placeholder="Discord name" name="discordname">
                            </div>
                            <div class="one-third column">
                                <label for="charname">Character name</label>
                                <input class="u-full-width" type="text" placeholder="Name" name="charname">
                            </div>
                            <div class="one-third column">
                                <label for="charclass">Class</label>
                                <select class="u-full-width" name="charclass">
                                    <option value="Haru">Haru</option>
                                    <option value="Erwin">Erwin</option>
                                    <option value="Lily">Lily</option>
                                    <option value="Stella">Stella</option>
                                    <option value="Jin">Jin</option>
                                    <option value="Iris">Iris</option>
                                </select>
                            </div>
                        </div>
                    </li>
                    <li>
                        <!-- Stats info -->
                        <div class="row">
                            <div class="two columns">
                                <label for="minatk">Min Atk</label>
                                <input placeholder="value" type="number" class="u-full-width" name="minatk" id="minatk">
                            </div>
                            <div class="two columns">
                                <label for="maxatk">Max Atk</label>
                                <input placeholder="value" type="number" class="u-full-width" name="maxatk" id="maxatk">
                            </div>
                            <div class="two columns">
                                <label for="bossdmg">Dmg on Boss</label>
                                <input placeholder="value" type="number" class="u-full-width" name="bossdmg" id="bossdmg">
                            </div>
                            <div class="two columns">
                                <label for="critrate">Crit Rate</label>
                                <input placeholder="value" type="number" class="u-full-width" name="critrate" id="critrate">
                            </div>
                            <div class="two columns">
                                <label for="critdmg">Crit Dmg</label>
                                <input placeholder="value" type="number" class="u-full-width" name="critdmg" id="critdmg">
                            </div>
                            <div class="two columns">
                                <label for="atkspd">Atk Spd</label>
                                <input placeholder="value" type="number" class="u-full-width" name="atkspd" id="atkspd">
                            </div>
                            <div class="two columns">
                                <label for="pen">Penetration</label>
                                <input placeholder="value" type="number" class="u-full-width" name="pen" id="pen">
                            </div>
                            <div class="two columns">
                                <label for="primaldmg">Primal Bonus Dmg</label>
                                <input placeholder="value" type="number" class="u-full-width" name="primaldmg" id="primaldmg">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="two columns">
                                <label for="eletype1">Ele Type 1</label>
                                <select class="u-full-width" name="eletype1" id="eletype1">
                                    <option value="-">-</option>
                                    <option value="Healing">Healing</option>
                                    <option value="Toxic">Toxic</option>
                                    <option value="Hatred">Hatred</option>
                                    <option value="Serenity">Serenity</option>
                                    <option value="Evil">Evil</option>
                                    <option value="Brilliance">Brilliance</option>
                                </select>
                            </div>
                            <div class="two columns">
                                <label for="eledmg">Ele Dmg 1</label>
                                <input placeholder="value" type="number" class="u-full-width" name="eledmg1" id="eledmg1">
                            </div>
                            <div class="two columns">
                                <label for="eletype2">Ele Type 2</label>
                                <select class="u-full-width" name="eletype2" id="eletype2">
                                    <option value="-">-</option>
                                    <option value="Healing">Healing</option>
                                    <option value="Toxic">Toxic</option>
                                    <option value="Hatred">Hatred</option>
                                    <option value="Serenity">Serenity</option>
                                    <option value="Evil">Evil</option>
                                    <option value="Brilliance">Brilliance</option>
                                </select>
                            </div>
                            <div class="two columns">
                                <label for="eledmg2">Ele Dmg 2</label>
                                <input placeholder="value" type="number" class="u-full-width" name="eledmg2" id="eledmg2">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="two columns">
                                <label for="hp">HP</label>
                                <input placeholder="value" type="number" class="u-full-width" name="hp" id="hp">
                            </div>
                            <div class="two columns">
                                <label for="def">Def</label>
                                <input placeholder="value" type="number" class="u-full-width" name="def" id="def">
                            </div>
                            <div class="two columns">
                                <label for="dmgrd">Dmg Reduction</label>
                                <input placeholder="value" type="number" class="u-full-width" name="dmgrd" id="dmgrd">
                            </div>
                            <div class="two columns">
                                <label for="bossdmgrd">Boss Dmg Reduction</label>
                                <input placeholder="value" type="number" class="u-full-width" name="bossdmgrd" id="bossdmgrd">
                            </div>
                            <div class="two columns">
                                <label for="mobdmgrd">Mob Dmg Reduction</label>
                                <input placeholder="value" type="number" class="u-full-width" name="mobdmgrd" id="mobdmgrd">
                            </div>
                            <div class="two columns">
                                <label for="primaldef">Primal Bonus Def</label>
                                <input placeholder="value" type="number" class="u-full-width" name="primaldef" id="primaldef">
                            </div>
                        </div>
                    </li>
                </ol>

                <input class="button-primary" type="submit" value="Submit">
            </form>
        <?php }else{ //update char ?>
            <form action="submit.php" method="post">
                <ol>
                    <li>
                        <!-- Basic info -->
                        <div class="row">
                            <div class="one-third column">
                                <label for="disname">Discord name</label>
                                <input class="u-full-width" type="text" placeholder="Discord name" name="discordname" value="<?php echo $setrows['discordname']; ?>">
                            </div>
                            <div class="one-third column">
                                <label for="charname">Character name</label>
                                <input class="u-full-width" type="text" placeholder="Name" name="charname" value="<?php echo $setrows['charname']; ?>">
                            </div>
                            <div class="one-third column">
                                <label for="charclass">Class</label>
                                <select class="u-full-width" name="charclass">
                                    <option value="Haru" <?php if($setrows['charclass'] == 'Haru'){echo 'selected';} ?>>Haru</option>
                                    <option value="Erwin" <?php if($setrows['charclass'] == 'Erwin'){echo 'selected';} ?>>Erwin</option>
                                    <option value="Lily" <?php if($setrows['charclass'] == 'Lily'){echo 'selected';} ?>>Lily</option>
                                    <option value="Stella" <?php if($setrows['charclass'] == 'Stella'){echo 'selected';} ?>>Stella</option>
                                    <option value="Jin" <?php if($setrows['charclass'] == 'Jin'){echo 'selected';} ?>>Jin</option>
                                    <option value="Iris" <?php if($setrows['charclass'] == 'Iris'){echo 'selected';} ?>>Iris</option>
                                </select>
                            </div>
                        </div>
                    </li>
                    <li>
                        <!-- Stats info -->
                        <div class="row">
                            <div class="two columns">
                                <label for="minatk">Min Atk</label>
                                <input placeholder="value" type="number" class="u-full-width" name="minatk" id="minatk" value="<?php echo $setrows['minatk']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="maxatk">Max Atk</label>
                                <input placeholder="value" type="number" class="u-full-width" name="maxatk" id="maxatk" value="<?php echo $setrows['maxatk']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="bossdmg">Dmg on Boss</label>
                                <input placeholder="value" type="number" class="u-full-width" name="bossdmg" id="bossdmg" value="<?php echo $setrows['bossdmg']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="critrate">Crit Rate</label>
                                <input placeholder="value" type="number" class="u-full-width" name="critrate" id="critrate" value="<?php echo $setrows['critrate']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="critdmg">Crit Dmg</label>
                                <input placeholder="value" type="number" class="u-full-width" name="critdmg" id="critdmg" value="<?php echo $setrows['critdmg']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="atkspd">Atk Spd</label>
                                <input placeholder="value" type="number" class="u-full-width" name="atkspd" id="atkspd" value="<?php echo $setrows['atkspd']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="pen">Penetration</label>
                                <input placeholder="value" type="number" class="u-full-width" name="pen" id="pen" value="<?php echo $setrows['pen']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="primaldmg">Primal Bonus Dmg</label>
                                <input placeholder="value" type="number" class="u-full-width" name="primaldmg" id="primaldmg" value="<?php echo $setrows['primaldmg']; ?>">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="two columns">
                                <label for="eletype1">Ele Type 1</label>
                                <select class="u-full-width" name="eletype1" id="eletype1">
                                    <option value="-" <?php if($setrows['eletype1'] == '-'){echo 'selected';} ?>>-</option>
                                    <option value="Healing" <?php if($setrows['eletype1'] == 'Healing'){echo 'selected';} ?>>Healing</option>
                                    <option value="Toxic" <?php if($setrows['eletype1'] == 'Toxic'){echo 'selected';} ?>>Toxic</option>
                                    <option value="Hatred" <?php if($setrows['eletype1'] == 'Hatred'){echo 'selected';} ?>>Hatred</option>
                                    <option value="Serenity" <?php if($setrows['eletype1'] == 'Serenity'){echo 'selected';} ?>>Serenity</option>
                                    <option value="Evil" <?php if($setrows['eletype1'] == 'Evil'){echo 'selected';} ?>>Evil</option>
                                    <option value="Brilliance" <?php if($setrows['eletype1'] == 'Brilliance'){echo 'selected';} ?>>Brilliance</option>
                                </select>
                            </div>
                            <div class="two columns">
                                <label for="eledmg">Ele Dmg 1</label>
                                <input placeholder="value" type="number" class="u-full-width" name="eledmg1" id="eledmg1" value="<?php echo $setrows['eledmg1']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="eletype2">Ele Type 2</label>
                                <select class="u-full-width" name="eletype2" id="eletype2">
                                    <option value="-" <?php if($setrows['eletype2'] == '-'){echo 'selected';} ?>>-</option>
                                    <option value="Healing" <?php if($setrows['eletype2'] == 'Healing'){echo 'selected';} ?>>Healing</option>
                                    <option value="Toxic" <?php if($setrows['eletype2'] == 'Toxic'){echo 'selected';} ?>>Toxic</option>
                                    <option value="Hatred" <?php if($setrows['eletype2'] == 'Hatred'){echo 'selected';} ?>>Hatred</option>
                                    <option value="Serenity" <?php if($setrows['eletype2'] == 'Serenity'){echo 'selected';} ?>>Serenity</option>
                                    <option value="Evil" <?php if($setrows['eletype2'] == 'Evil'){echo 'selected';} ?>>Evil</option>
                                    <option value="Brilliance" <?php if($setrows['eletype2'] == 'Brilliance'){echo 'selected';} ?>>Brilliance</option>
                                </select>
                            </div>
                            <div class="two columns">
                                <label for="eledmg2">Ele Dmg 2</label>
                                <input placeholder="value" type="number" class="u-full-width" name="eledmg2" id="eledmg2" value="<?php echo $setrows['eledmg2']; ?>">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="two columns">
                                <label for="hp">HP</label>
                                <input placeholder="value" type="number" class="u-full-width" name="hp" id="hp" value="<?php echo $setrows['hp']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="def">Def</label>
                                <input placeholder="value" type="number" class="u-full-width" name="def" id="def" value="<?php echo $setrows['def']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="dmgrd">Dmg Reduction</label>
                                <input placeholder="value" type="number" class="u-full-width" name="dmgrd" id="dmgrd" value="<?php echo $setrows['dmgrd']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="bossdmgrd">Boss Dmg Reduction</label>
                                <input placeholder="value" type="number" class="u-full-width" name="bossdmgrd" id="bossdmgrd" value="<?php echo $setrows['bossdmgrd']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="mobdmgrd">Mob Dmg Reduction</label>
                                <input placeholder="value" type="number" class="u-full-width" name="mobdmgrd" id="mobdmgrd" value="<?php echo $setrows['mobdmgrd']; ?>">
                            </div>
                            <div class="two columns">
                                <label for="primaldef">Primal Bonus Def</label>
                                <input placeholder="value" type="number" class="u-full-width" name="primaldef" id="primaldef" value="<?php echo $setrows['primaldef']; ?>">
                            </div>
                        </div>
                    </li>
                </ol>

                <input class="button-primary" type="submit" value="Submit">
            </form>
        <?php } ?>
    </div>

    <!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>

</html>
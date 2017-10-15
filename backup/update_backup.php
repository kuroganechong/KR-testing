<?php
    require('common.php');
    $update = 0;
    if(!empty($_GET['setno'])){
        $update = 1;
        $query = "SELECT * FROM sets WHERE setno = :setno";
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
            <li class="li"><a href="index.php">List</a></li>
            <li class="li active"><a href="update.php">Update</a></li>
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
                                <input v-model="charname" class="u-full-width" type="text" placeholder="Name" name="charname">
                            </div>
                            <div class="one-third column">
                                <label for="charclass">Class</label>
                                <select v-model="charclass" class="u-full-width" name="charclass">
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
                        <!-- Gear info -->
                        <div class="row">
                            <div class="six columns">
                                <label for="weapon">Weapon</label>
                                <select style="width:50%" name="weapon">
                                    <option value="Devourer">Devourer</option>
                                    <option value="Aurite">Aurite</option>
                                    <option value="Others">Others</option>
                                </select>
                                <select style="width:15%" name="weapon_en">
                                    <option value="+0">+0</option>
                                    <option value="+1">+1</option>
                                    <option value="+2">+2</option>
                                    <option value="+3">+3</option>
                                    <option value="+4">+4</option>
                                    <option value="+5">+5</option>
                                    <option value="+6">+6</option>
                                    <option value="+7">+7</option>
                                    <option value="+8">+8</option>
                                    <option value="+9">+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="weapon_gd">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="weapon_1">
                                        <option v-for="item in weaponL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="weapon_1_val">
                                    <select style="width:70%" name="weapon_2">
                                        <option v-for="item in weaponL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="weapon_2_val">
                                    <select style="width:70%" name="weapon_3">
                                        <option v-for="item in weaponL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="weapon_3_val">
                                    <select style="width:70%" name="weapon_4">
                                        <option v-for="item in weaponL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="weapon_4_val">
                                </div>
                            </div>
                            <div class="six columns">
                                <label for="head">Head</label>
                                <select style="width:50%" name="head">
                                    <option value="Devourer">Devourer</option>
                                    <option value="Aurite">Aurite</option>
                                    <option value="Others">Others</option>
                                </select>
                                <select style="width:15%" name="head_en">
                                    <option value="+0">+0</option>
                                    <option value="+1">+1</option>
                                    <option value="+2">+2</option>
                                    <option value="+3">+3</option>
                                    <option value="+4">+4</option>
                                    <option value="+5">+5</option>
                                    <option value="+6">+6</option>
                                    <option value="+7">+7</option>
                                    <option value="+8">+8</option>
                                    <option value="+9">+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="head_gd">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="head_1">
                                        <option v-for="item in headL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="head_1_val">
                                    <select style="width:70%" name="head_2">
                                        <option v-for="item in headL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="head_2_val">
                                    <select style="width:70%" name="head_3">
                                        <option v-for="item in headL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="head_3_val">
                                    <select style="width:70%" name="head_4">
                                        <option v-for="item in headL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="head_4_val">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="shoulder">Shoulder</label>
                                <select style="width:50%" name="shoulder">
                                    <option value="Devourer">Devourer</option>
                                    <option value="Aurite">Aurite</option>
                                    <option value="Others">Others</option>
                                </select>
                                <select style="width:15%" name="shoulder_en">
                                    <option value="+0">+0</option>
                                    <option value="+1">+1</option>
                                    <option value="+2">+2</option>
                                    <option value="+3">+3</option>
                                    <option value="+4">+4</option>
                                    <option value="+5">+5</option>
                                    <option value="+6">+6</option>
                                    <option value="+7">+7</option>
                                    <option value="+8">+8</option>
                                    <option value="+9">+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="shoulder_gd">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="shoulder_1">
                                        <option v-for="item in shoulderL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="shoulder_1_val">
                                    <select style="width:70%" name="shoulder_2">
                                        <option v-for="item in shoulderL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="shoulder_2_val">
                                    <select style="width:70%" name="shoulder_3">
                                        <option v-for="item in shoulderL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="shoulder_3_val">
                                    <select style="width:70%" name="shoulder_4">
                                        <option v-for="item in shoulderL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="shoulder_4_val">
                                </div>
                            </div>
                            <div class="six columns">
                                <label for="body">Body</label>
                                <select style="width:50%" name="body">
                                    <option value="Devourer">Devourer</option>
                                    <option value="Aurite">Aurite</option>
                                    <option value="Others">Others</option>
                                </select>
                                <select style="width:15%" name="body_en">
                                    <option value="+0">+0</option>
                                    <option value="+1">+1</option>
                                    <option value="+2">+2</option>
                                    <option value="+3">+3</option>
                                    <option value="+4">+4</option>
                                    <option value="+5">+5</option>
                                    <option value="+6">+6</option>
                                    <option value="+7">+7</option>
                                    <option value="+8">+8</option>
                                    <option value="+9">+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="body_gd">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="body_1">
                                        <option v-for="item in bodyL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="body_1_val">
                                    <select style="width:70%" name="body_2">
                                        <option v-for="item in bodyL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="body_2_val">
                                    <select style="width:70%" name="body_3">
                                        <option v-for="item in bodyL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="body_3_val">
                                    <select style="width:70%" name="body_4">
                                        <option v-for="item in bodyL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="body_4_val">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="feet">Feet</label>
                                <select style="width:50%" name="feet">
                                    <option value="Devourer">Devourer</option>
                                    <option value="Aurite">Aurite</option>
                                    <option value="Others">Others</option>
                                </select>
                                <select style="width:15%" name="feet_en">
                                    <option value="+0">+0</option>
                                    <option value="+1">+1</option>
                                    <option value="+2">+2</option>
                                    <option value="+3">+3</option>
                                    <option value="+4">+4</option>
                                    <option value="+5">+5</option>
                                    <option value="+6">+6</option>
                                    <option value="+7">+7</option>
                                    <option value="+8">+8</option>
                                    <option value="+9">+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="feet_gd">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="feet_1">
                                        <option v-for="item in feetL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="feet_1_val">
                                    <select style="width:70%" name="feet_2">
                                        <option v-for="item in feetL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="feet_2_val">
                                    <select style="width:70%" name="feet_3">
                                        <option v-for="item in feetL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="feet_3_val">
                                    <select style="width:70%" name="feet_4">
                                        <option v-for="item in feetL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="feet_4_val">
                                </div>
                            </div>
                            <div class="six columns">
                                <label for="ear">Earrings</label>
                                <select style="width:100%" name="ear">
                                    <option value="Devourer">Devourer</option>
                                    <option value="Aurite">Aurite</option>
                                    <option value="Shion">Shion</option>
                                    <option value="Others">Others</option>
                                </select>
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="ear_1">
                                        <option v-for="item in earL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ear_1_val">
                                    <select style="width:70%" name="ear_2">
                                        <option v-for="item in earL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ear_2_val">
                                    <select style="width:70%" name="ear_3">
                                        <option v-for="item in earL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ear_3_val">
                                    <select style="width:70%" name="ear_4">
                                        <option v-for="item in earL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ear_4_val">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="pen">Pendant</label>
                                <select style="width:100%" name="pen">
                                    <option value="Devourer">Devourer</option>
                                    <option value="Aurite">Aurite</option>
                                    <option value="Shion">Shion</option>
                                    <option value="Others">Others</option>
                                </select>
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="pen_1">
                                        <option v-for="item in penL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="pen_1_val">
                                    <select style="width:70%" name="pen_2">
                                        <option v-for="item in penL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="pen_2_val">
                                    <select style="width:70%" name="pen_3">
                                        <option v-for="item in penL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="pen_3_val">
                                    <select style="width:70%" name="pen_4">
                                        <option v-for="item in penL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="pen_4_val">
                                </div>
                            </div>
                            <div class="six columns">
                                <label for="ring1">Ring 1</label>
                                <select style="width:100%" name="ring1">
                                    <option value="Devourer">Devourer Seed</option>
                                    <option value="Devourer2">Devourer Greed</option>
                                    <option value="Aurite">Aurite Relic</option>
                                    <option value="Aurite2">Aurite Seal</option>
                                    <option value="Shion">Shion</option>
                                    <option value="Others">Others</option>
                                </select>
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="ring1_1">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring1_1_val">
                                    <select style="width:70%" name="ring1_2">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring1_2_val">
                                    <select style="width:70%" name="ring1_3">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring1_3_val">
                                    <select style="width:70%" name="ring1_4">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring1_4_val">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="ring2">Ring 2</label>
                                <select style="width:100%" name="ring2">
                                    <option value="Devourer">Devourer Seed</option>
                                    <option value="Devourer2">Devourer Greed</option>
                                    <option value="Aurite">Aurite Relic</option>
                                    <option value="Aurite2">Aurite Seal</option>
                                    <option value="Shion">Shion</option>
                                    <option value="Others">Others</option>
                                </select>
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="ring2_1">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring2_1_val">
                                    <select style="width:70%" name="ring2_2">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring2_2_val">
                                    <select style="width:70%" name="ring2_3">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring2_3_val">
                                    <select style="width:70%" name="ring2_4">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring2_4_val">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <!-- SS info -->
                        <div class="row">
                            <div class="six columns">
                                <label>Soulstone</label>
                                <label for="elew1">Weapon</label>
                                <select v-model="elew" style="width:50%" name="elew1">
                                    <option value="-">-</option>
                                    <option value="Healing">Healing</option>
                                    <option value="Toxic">Toxic</option>
                                    <option value="Serenity">Serenity</option>
                                    <option value="Hatred">Hatred</option>
                                    <option value="Brilliance">Brilliance</option>
                                    <option value="Evil">Evil</option>
                                </select>
                                <select style="width:15%" name="elew1tier">
                                    <option value="-">-</option>
                                    <option value="T1">T1</option>
                                    <option value="T2">T2</option>
                                    <option value="T3">T3</option>
                                    <option value="T4">T4</option>
                                    <option value="T5">T5</option>
                                    <option value="T6">T6</option>
                                    <option value="T7">T7</option>
                                    <option value="T8">T8</option>
                                    <option value="T9">T9</option>
                                </select>

                                <select v-model="elew" style="width:50%" name="elew2">
                                    <option value="-">-</option>
                                    <option value="Healing">Healing</option>
                                    <option value="Toxic">Toxic</option>
                                    <option value="Serenity">Serenity</option>
                                    <option value="Hatred">Hatred</option>
                                    <option value="Brilliance">Brilliance</option>
                                    <option value="Evil">Evil</option>
                                </select>
                                <select style="width:15%" name="elew2tier">
                                    <option value="-">-</option>
                                    <option value="T1">T1</option>
                                    <option value="T2">T2</option>
                                    <option value="T3">T3</option>
                                    <option value="T4">T4</option>
                                    <option value="T5">T5</option>
                                    <option value="T6">T6</option>
                                    <option value="T7">T7</option>
                                    <option value="T8">T8</option>
                                    <option value="T9">T9</option>
                                </select>

                                <select style="width:70%" name="famw1">
                                    <option value="-">-</option>
                                    <option value="critdmg">Critical Damage</option>
                                </select>
                                <input placeholder="value" type="number" style="width:20%" name="famw1v">

                                <select style="width:70%" name="famw2">
                                    <option value="-">-</option>
                                    <option value="critdmg">Critical Damage</option>
                                </select>
                                <input placeholder="value" type="number" style="width:20%" name="famw2v">
                            </div>
                            <div class="six columns">
                                <label><br></label>
                                <label for="elew1">Armor</label>
                                <div v-for="i in lists">
                                    <select style="width:50%" v-bind:name="'elea'+i">
                                        <option value="-">-</option>
                                        <option value="Healing">Healing</option>
                                        <option value="Toxic">Toxic</option>
                                        <option value="Serenity">Serenity</option>
                                        <option value="Hatred">Hatred</option>
                                        <option value="Brilliance">Brilliance</option>
                                        <option value="Evil">Evil</option>
                                    </select>
                                    <select style="width:15%" v-bind:name="'elea'+i+'tier'">
                                        <option value="-">-</option>
                                        <option value="T1">T1</option>
                                        <option value="T2">T2</option>
                                        <option value="T3">T3</option>
                                        <option value="T4">T4</option>
                                        <option value="T5">T5</option>
                                        <option value="T6">T6</option>
                                        <option value="T7">T7</option>
                                        <option value="T8">T8</option>
                                        <option value="T9">T9</option>
                                    </select>
                                    <input placeholder="count" type="number" style="width:20%" v-bind:name="'elea'+i+'c'">
                                </div>

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
                                <input v-model="charname" class="u-full-width" type="text" placeholder="Name" name="charname" value="<?php echo $setrows['charname']; ?>">
                            </div>
                            <div class="one-third column">
                                <label for="charclass">Class</label>
                                <select v-model="charclass" class="u-full-width" name="charclass">
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
                        <!-- Gear info -->
                        <div class="row">
                            <div class="six columns">
                                <label for="weapon">Weapon</label>
                                <select style="width:50%" name="weapon">
                                    <option value="Devourer" <?php if($setrows['weapon'] == 'Devourer'){echo 'selected';} ?>>Devourer</option>
                                    <option value="Aurite" <?php if($setrows['weapon'] == 'Aurite'){echo 'selected';} ?>>Aurite</option>
                                    <option value="Others" <?php if($setrows['weapon'] == 'Others'){echo 'selected';} ?>>Others</option>
                                </select>
                                <select style="width:15%" name="weapon_en">
                                    <option value="+0" <?php if($setrows['weapon_en'] == '+0'){echo 'selected';} ?>>+0</option>
                                    <option value="+1" <?php if($setrows['weapon_en'] == '+1'){echo 'selected';} ?>>+1</option>
                                    <option value="+2" <?php if($setrows['weapon_en'] == '+2'){echo 'selected';} ?>>+2</option>
                                    <option value="+3" <?php if($setrows['weapon_en'] == '+3'){echo 'selected';} ?>>+3</option>
                                    <option value="+4" <?php if($setrows['weapon_en'] == '+4'){echo 'selected';} ?>>+4</option>
                                    <option value="+5" <?php if($setrows['weapon_en'] == '+5'){echo 'selected';} ?>>+5</option>
                                    <option value="+6" <?php if($setrows['weapon_en'] == '+6'){echo 'selected';} ?>>+6</option>
                                    <option value="+7" <?php if($setrows['weapon_en'] == '+7'){echo 'selected';} ?>>+7</option>
                                    <option value="+8" <?php if($setrows['weapon_en'] == '+8'){echo 'selected';} ?>>+8</option>
                                    <option value="+9" <?php if($setrows['weapon_en'] == '+9'){echo 'selected';} ?>>+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="weapon_gd" value="<?php echo $setrows['weapon_gd']; ?>">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="weapon_1" v-model="weapon_1">
                                        <option v-for="item in weaponL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="weapon_1_val" value="<?php echo $setrows['weapon_1_val']; ?>">
                                    <select style="width:70%" name="weapon_2" v-model="weapon_2">
                                        <option v-for="item in weaponL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="weapon_2_val" value="<?php echo $setrows['weapon_2_val']; ?>">
                                    <select style="width:70%" name="weapon_3" v-model="weapon_3">
                                        <option v-for="item in weaponL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="weapon_3_val" value="<?php echo $setrows['weapon_3_val']; ?>">
                                    <select style="width:70%" name="weapon_4" v-model="weapon_4">
                                        <option v-for="item in weaponL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="weapon_4_val" value="<?php echo $setrows['weapon_4_val']; ?>">
                                </div>
                            </div>
                            <div class="six columns">
                                <label for="head">Head</label>
                                <select style="width:50%" name="head">
                                    <option value="Devourer" <?php if($setrows['head'] == 'Devourer'){echo 'selected';} ?>>Devourer</option>
                                    <option value="Aurite" <?php if($setrows['head'] == 'Aurite'){echo 'selected';} ?>>Aurite</option>
                                    <option value="Others" <?php if($setrows['head'] == 'Others'){echo 'selected';} ?>>Others</option>
                                </select>
                                <select style="width:15%" name="head_en">
                                    <option value="+0" <?php if($setrows['head_en'] == '+0'){echo 'selected';} ?>>+0</option>
                                    <option value="+1" <?php if($setrows['head_en'] == '+1'){echo 'selected';} ?>>+1</option>
                                    <option value="+2" <?php if($setrows['head_en'] == '+2'){echo 'selected';} ?>>+2</option>
                                    <option value="+3" <?php if($setrows['head_en'] == '+3'){echo 'selected';} ?>>+3</option>
                                    <option value="+4" <?php if($setrows['head_en'] == '+4'){echo 'selected';} ?>>+4</option>
                                    <option value="+5" <?php if($setrows['head_en'] == '+5'){echo 'selected';} ?>>+5</option>
                                    <option value="+6" <?php if($setrows['head_en'] == '+6'){echo 'selected';} ?>>+6</option>
                                    <option value="+7" <?php if($setrows['head_en'] == '+7'){echo 'selected';} ?>>+7</option>
                                    <option value="+8" <?php if($setrows['head_en'] == '+8'){echo 'selected';} ?>>+8</option>
                                    <option value="+9" <?php if($setrows['head_en'] == '+9'){echo 'selected';} ?>>+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="head_gd" value="<?php echo $setrows['head_gd']; ?>">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="head_1" v-model="head_1">
                                        <option v-for="item in headL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="head_1_val" value="<?php echo $setrows['head_1_val']; ?>">
                                    <select style="width:70%" name="head_2" v-model="head_2">
                                        <option v-for="item in headL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="head_2_val" value="<?php echo $setrows['head_2_val']; ?>">
                                    <select style="width:70%" name="head_3" v-model="head_3">
                                        <option v-for="item in headL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="head_3_val" value="<?php echo $setrows['head_3_val']; ?>">
                                    <select style="width:70%" name="head_4" v-model="head_4">
                                        <option v-for="item in headL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="head_4_val" value="<?php echo $setrows['head_4_val']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="shoulder">Shoulder</label>
                                <select style="width:50%" name="shoulder">
                                    <option value="Devourer" <?php if($setrows['shoulder'] == 'Devourer'){echo 'selected';} ?>>Devourer</option>
                                    <option value="Aurite" <?php if($setrows['shoulder'] == 'Aurite'){echo 'selected';} ?>>Aurite</option>
                                    <option value="Others" <?php if($setrows['shoulder'] == 'Others'){echo 'selected';} ?>>Others</option>
                                </select>
                                <select style="width:15%" name="shoulder_en">
                                    <option value="+0" <?php if($setrows['shoulder_en'] == '+0'){echo 'selected';} ?>>+0</option>
                                    <option value="+1" <?php if($setrows['shoulder_en'] == '+1'){echo 'selected';} ?>>+1</option>
                                    <option value="+2" <?php if($setrows['shoulder_en'] == '+2'){echo 'selected';} ?>>+2</option>
                                    <option value="+3" <?php if($setrows['shoulder_en'] == '+3'){echo 'selected';} ?>>+3</option>
                                    <option value="+4" <?php if($setrows['shoulder_en'] == '+4'){echo 'selected';} ?>>+4</option>
                                    <option value="+5" <?php if($setrows['shoulder_en'] == '+5'){echo 'selected';} ?>>+5</option>
                                    <option value="+6" <?php if($setrows['shoulder_en'] == '+6'){echo 'selected';} ?>>+6</option>
                                    <option value="+7" <?php if($setrows['shoulder_en'] == '+7'){echo 'selected';} ?>>+7</option>
                                    <option value="+8" <?php if($setrows['shoulder_en'] == '+8'){echo 'selected';} ?>>+8</option>
                                    <option value="+9" <?php if($setrows['shoulder_en'] == '+9'){echo 'selected';} ?>>+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="shoulder_gd" value="<?php echo $setrows['shoulder_gd']; ?>">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="shoulder_1" v-model="shoulder_1">
                                        <option v-for="item in shoulderL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="shoulder_1_val" value="<?php echo $setrows['shoulder_1_val']; ?>">
                                    <select style="width:70%" name="shoulder_2" v-model="shoulder_2">
                                        <option v-for="item in shoulderL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="shoulder_2_val" value="<?php echo $setrows['shoulder_2_val']; ?>">
                                    <select style="width:70%" name="shoulder_3" v-model="shoulder_3">
                                        <option v-for="item in shoulderL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="shoulder_3_val" value="<?php echo $setrows['shoulder_3_val']; ?>">
                                    <select style="width:70%" name="shoulder_4" v-model="shoulder_4">
                                        <option v-for="item in shoulderL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="shoulder_4_val" value="<?php echo $setrows['shoulder_4_val']; ?>">
                                </div>
                            </div>
                            <div class="six columns">
                                <label for="body">Body</label>
                                <select style="width:50%" name="body">
                                    <option value="Devourer" <?php if($setrows['body'] == 'Devourer'){echo 'selected';} ?>>Devourer</option>
                                    <option value="Aurite" <?php if($setrows['body'] == 'Aurite'){echo 'selected';} ?>>Aurite</option>
                                    <option value="Others" <?php if($setrows['body'] == 'Others'){echo 'selected';} ?>>Others</option>
                                </select>
                                <select style="width:15%" name="body_en">
                                    <option value="+0" <?php if($setrows['body_en'] == '+0'){echo 'selected';} ?>>+0</option>
                                    <option value="+1" <?php if($setrows['body_en'] == '+1'){echo 'selected';} ?>>+1</option>
                                    <option value="+2" <?php if($setrows['body_en'] == '+2'){echo 'selected';} ?>>+2</option>
                                    <option value="+3" <?php if($setrows['body_en'] == '+3'){echo 'selected';} ?>>+3</option>
                                    <option value="+4" <?php if($setrows['body_en'] == '+4'){echo 'selected';} ?>>+4</option>
                                    <option value="+5" <?php if($setrows['body_en'] == '+5'){echo 'selected';} ?>>+5</option>
                                    <option value="+6" <?php if($setrows['body_en'] == '+6'){echo 'selected';} ?>>+6</option>
                                    <option value="+7" <?php if($setrows['body_en'] == '+7'){echo 'selected';} ?>>+7</option>
                                    <option value="+8" <?php if($setrows['body_en'] == '+8'){echo 'selected';} ?>>+8</option>
                                    <option value="+9" <?php if($setrows['body_en'] == '+9'){echo 'selected';} ?>>+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="body_gd" value="<?php echo $setrows['body_gd']; ?>">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="body_1" v-model="body_1">
                                        <option v-for="item in bodyL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="body_1_val" value="<?php echo $setrows['body_1_val']; ?>">
                                    <select style="width:70%" name="body_2" v-model="body_2">
                                        <option v-for="item in bodyL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="body_2_val" value="<?php echo $setrows['body_2_val']; ?>">
                                    <select style="width:70%" name="body_3" v-model="body_3">
                                        <option v-for="item in bodyL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="body_3_val" value="<?php echo $setrows['body_3_val']; ?>">
                                    <select style="width:70%" name="body_4" v-model="body_4">
                                        <option v-for="item in bodyL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="body_4_val" value="<?php echo $setrows['body_4_val']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="feet">Feet</label>
                                <select style="width:50%" name="feet">
                                    <option value="Devourer" <?php if($setrows['feet'] == 'Devourer'){echo 'selected';} ?>>Devourer</option>
                                    <option value="Aurite" <?php if($setrows['feet'] == 'Aurite'){echo 'selected';} ?>>Aurite</option>
                                    <option value="Others" <?php if($setrows['feet'] == 'Others'){echo 'selected';} ?>>Others</option>
                                </select>
                                <select style="width:15%" name="feet_en">
                                    <option value="+0" <?php if($setrows['feet_en'] == '+0'){echo 'selected';} ?>>+0</option>
                                    <option value="+1" <?php if($setrows['feet_en'] == '+1'){echo 'selected';} ?>>+1</option>
                                    <option value="+2" <?php if($setrows['feet_en'] == '+2'){echo 'selected';} ?>>+2</option>
                                    <option value="+3" <?php if($setrows['feet_en'] == '+3'){echo 'selected';} ?>>+3</option>
                                    <option value="+4" <?php if($setrows['feet_en'] == '+4'){echo 'selected';} ?>>+4</option>
                                    <option value="+5" <?php if($setrows['feet_en'] == '+5'){echo 'selected';} ?>>+5</option>
                                    <option value="+6" <?php if($setrows['feet_en'] == '+6'){echo 'selected';} ?>>+6</option>
                                    <option value="+7" <?php if($setrows['feet_en'] == '+7'){echo 'selected';} ?>>+7</option>
                                    <option value="+8" <?php if($setrows['feet_en'] == '+8'){echo 'selected';} ?>>+8</option>
                                    <option value="+9" <?php if($setrows['feet_en'] == '+9'){echo 'selected';} ?>>+9</option>
                                </select>
                                <input placeholder="0-100%" min="0" max="100" type="number" style="width:30%" name="feet_gd" value="<?php echo $setrows['feet_gd']; ?>">
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="feet_1" v-model="feet_1">
                                        <option v-for="item in feetL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="feet_1_val" value="<?php echo $setrows['feet_1_val']; ?>">
                                    <select style="width:70%" name="feet_2" v-model="feet_2">
                                        <option v-for="item in feetL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="feet_2_val" value="<?php echo $setrows['feet_2_val']; ?>">
                                    <select style="width:70%" name="feet_3" v-model="feet_3">
                                        <option v-for="item in feetL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="feet_3_val" value="<?php echo $setrows['feet_3_val']; ?>">
                                    <select style="width:70%" name="feet_4" v-model="feet_4">
                                        <option v-for="item in feetL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="feet_4_val" value="<?php echo $setrows['feet_4_val']; ?>">
                                </div>
                            </div>
                            <div class="six columns">
                                <label for="ear">Earrings</label>
                                <select style="width:100%" name="ear">
                                    <option value="Devourer" <?php if($setrows['ear'] == 'Devourer'){echo 'selected';} ?>>Devourer</option>
                                    <option value="Aurite" <?php if($setrows['ear'] == 'Aurite'){echo 'selected';} ?>>Aurite</option>
                                    <option value="Shion" <?php if($setrows['ear'] == 'Shion'){echo 'selected';} ?>>Shion</option>
                                    <option value="Others" <?php if($setrows['ear'] == 'Others'){echo 'selected';} ?>>Others</option>
                                </select>
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="ear_1" v-model="ear_1">
                                        <option v-for="item in earL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ear_1_val" value="<?php echo $setrows['ear_1_val']; ?>">
                                    <select style="width:70%" name="ear_2" v-model="ear_2">
                                        <option v-for="item in earL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ear_2_val" value="<?php echo $setrows['ear_2_val']; ?>">
                                    <select style="width:70%" name="ear_3" v-model="ear_3">
                                        <option v-for="item in earL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ear_3_val" value="<?php echo $setrows['ear_3_val']; ?>">
                                    <select style="width:70%" name="ear_4" v-model="ear_4">
                                        <option v-for="item in earL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ear_4_val" value="<?php echo $setrows['ear_4_val']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="pen">Pendant</label>
                                <select style="width:100%" name="pen">
                                    <option value="Devourer" <?php if($setrows['pen'] == 'Devourer'){echo 'selected';} ?>>Devourer</option>
                                    <option value="Aurite" <?php if($setrows['pen'] == 'Aurite'){echo 'selected';} ?>>Aurite</option>
                                    <option value="Shion" <?php if($setrows['pen'] == 'Shion'){echo 'selected';} ?>>Shion</option>
                                    <option value="Others" <?php if($setrows['pen'] == 'Others'){echo 'selected';} ?>>Others</option>
                                </select>
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="pen_1" v-model="pen_1">
                                        <option v-for="item in penL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="pen_1_val" value="<?php echo $setrows['pen_1_val']; ?>">
                                    <select style="width:70%" name="pen_2" v-model="pen_2">
                                        <option v-for="item in penL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="pen_2_val" value="<?php echo $setrows['pen_2_val']; ?>">
                                    <select style="width:70%" name="pen_3" v-model="pen_3">
                                        <option v-for="item in penL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="pen_3_val" value="<?php echo $setrows['pen_3_val']; ?>">
                                    <select style="width:70%" name="pen_4" v-model="pen_4">
                                        <option v-for="item in penL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="pen_4_val" value="<?php echo $setrows['pen_4_val']; ?>">
                                </div>
                            </div>
                            <div class="six columns">
                                <label for="ring1">Ring 1</label>
                                <select style="width:100%" name="ring1">
                                    <option value="Devourer" <?php if($setrows['ring1'] == 'Devourer'){echo 'selected';} ?>>Devourer Seed</option>
                                    <option value="Devourer2" <?php if($setrows['ring1'] == 'Devourer2'){echo 'selected';} ?>>Devourer Greed</option>
                                    <option value="Aurite" <?php if($setrows['ring1'] == 'Aurite'){echo 'selected';} ?>>Aurite Relic</option>
                                    <option value="Aurite2" <?php if($setrows['ring1'] == 'Aurite2'){echo 'selected';} ?>>Aurite Seal</option>
                                    <option value="Shion" <?php if($setrows['ring1'] == 'Shion'){echo 'selected';} ?>>Shion</option>
                                    <option value="Others" <?php if($setrows['ring1'] == 'Others'){echo 'selected';} ?>>Others</option>
                                </select>
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="ring1_1" v-model="ring1_1">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring1_1_val" value="<?php echo $setrows['ring1_1_val']; ?>">
                                    <select style="width:70%" name="ring1_2" v-model="ring1_2">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring1_2_val" value="<?php echo $setrows['ring1_2_val']; ?>">
                                    <select style="width:70%" name="ring1_3" v-model="ring1_3">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring1_3_val" value="<?php echo $setrows['ring1_3_val']; ?>">
                                    <select style="width:70%" name="ring1_4" v-model="ring1_4">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring1_4_val" value="<?php echo $setrows['ring1_4_val']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="ring2">Ring 2</label>
                                <select style="width:100%" name="ring2">
                                    <option value="Devourer" <?php if($setrows['ring2'] == 'Devourer'){echo 'selected';} ?>>Devourer Seed</option>
                                    <option value="Devourer2" <?php if($setrows['ring2'] == 'Devourer2'){echo 'selected';} ?>>Devourer Greed</option>
                                    <option value="Aurite" <?php if($setrows['ring2'] == 'Aurite'){echo 'selected';} ?>>Aurite Relic</option>
                                    <option value="Aurite2" <?php if($setrows['ring2'] == 'Aurite2'){echo 'selected';} ?>>Aurite Seal</option>
                                    <option value="Shion" <?php if($setrows['ring2'] == 'Shion'){echo 'selected';} ?>>Shion</option>
                                    <option value="Others" <?php if($setrows['ring2'] == 'Others'){echo 'selected';} ?>>Others</option>
                                </select>
                                <div>
                                    <label>Substats</label>
                                    <select style="width:70%" name="ring2_1" v-model="ring1_1">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring2_1_val" value="<?php echo $setrows['ring2_1_val']; ?>">
                                    <select style="width:70%" name="ring2_2" v-model="ring2_2">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring2_2_val" value="<?php echo $setrows['ring2_2_val']; ?>">
                                    <select style="width:70%" name="ring2_3" v-model="ring2_3">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring2_3_val" value="<?php echo $setrows['ring2_3_val']; ?>">
                                    <select style="width:70%" name="ring2_4" v-model="ring2_4">
                                        <option v-for="item in ringL">{{ item }}</option>
                                    </select>
                                    <input placeholder="value" type="number" style="width:20%" name="ring2_4_val" value="<?php echo $setrows['ring2_4_val']; ?>">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <!-- SS info -->
                        <div class="row">
                            <div class="six columns">
                                <label>Soulstone</label>
                                <label for="elew1">Weapon</label>
                                <select v-model="elew" style="width:50%" name="elew1">
                                    <option value="-">-</option>
                                    <option value="Healing" <?php if($setrows['elew1'] == 'Healing'){echo 'selected';} ?>>Healing</option>
                                    <option value="Toxic" <?php if($setrows['elew1'] == 'Toxic'){echo 'selected';} ?>>Toxic</option>
                                    <option value="Serenity" <?php if($setrows['elew1'] == 'Serenity'){echo 'selected';} ?>>Serenity</option>
                                    <option value="Hatred" <?php if($setrows['elew1'] == 'Hatred'){echo 'selected';} ?>>Hatred</option>
                                    <option value="Brilliance" <?php if($setrows['elew1'] == 'Brilliance'){echo 'selected';} ?>>Brilliance</option>
                                    <option value="Evil" <?php if($setrows['elew1'] == 'Evil'){echo 'selected';} ?>>Evil</option>
                                </select>
                                <select style="width:15%" name="elew1tier">
                                    <option value="-">-</option>
                                    <option value="T1" <?php if($setrows['elew1tier'] == 'T1'){echo 'selected';} ?>>T1</option>
                                    <option value="T2" <?php if($setrows['elew1tier'] == 'T2'){echo 'selected';} ?>>T2</option>
                                    <option value="T3" <?php if($setrows['elew1tier'] == 'T3'){echo 'selected';} ?>>T3</option>
                                    <option value="T4" <?php if($setrows['elew1tier'] == 'T4'){echo 'selected';} ?>>T4</option>
                                    <option value="T5" <?php if($setrows['elew1tier'] == 'T5'){echo 'selected';} ?>>T5</option>
                                    <option value="T6" <?php if($setrows['elew1tier'] == 'T6'){echo 'selected';} ?>>T6</option>
                                    <option value="T7" <?php if($setrows['elew1tier'] == 'T7'){echo 'selected';} ?>>T7</option>
                                    <option value="T8" <?php if($setrows['elew1tier'] == 'T8'){echo 'selected';} ?>>T8</option>
                                    <option value="T9" <?php if($setrows['elew1tier'] == 'T9'){echo 'selected';} ?>>T9</option>
                                </select>

                                <select v-model="elew" style="width:50%" name="elew2">
                                    <option value="-">-</option>
                                    <option value="Healing" <?php if($setrows['elew2'] == 'Healing'){echo 'selected';} ?>>Healing</option>
                                    <option value="Toxic" <?php if($setrows['elew2'] == 'Toxic'){echo 'selected';} ?>>Toxic</option>
                                    <option value="Serenity" <?php if($setrows['elew2'] == 'Serenity'){echo 'selected';} ?>>Serenity</option>
                                    <option value="Hatred" <?php if($setrows['elew2'] == 'Hatred'){echo 'selected';} ?>>Hatred</option>
                                    <option value="Brilliance" <?php if($setrows['elew2'] == 'Brilliance'){echo 'selected';} ?>>Brilliance</option>
                                    <option value="Evil" <?php if($setrows['elew2'] == 'Evil'){echo 'selected';} ?>>Evil</option>
                                </select>
                                <select style="width:15%" name="elew2tier">
                                    <option value="-">-</option>
                                    <option value="T1" <?php if($setrows['elew2tier'] == 'T1'){echo 'selected';} ?>>T1</option>
                                    <option value="T2" <?php if($setrows['elew2tier'] == 'T2'){echo 'selected';} ?>>T2</option>
                                    <option value="T3" <?php if($setrows['elew2tier'] == 'T3'){echo 'selected';} ?>>T3</option>
                                    <option value="T4" <?php if($setrows['elew2tier'] == 'T4'){echo 'selected';} ?>>T4</option>
                                    <option value="T5" <?php if($setrows['elew2tier'] == 'T5'){echo 'selected';} ?>>T5</option>
                                    <option value="T6" <?php if($setrows['elew2tier'] == 'T6'){echo 'selected';} ?>>T6</option>
                                    <option value="T7" <?php if($setrows['elew2tier'] == 'T7'){echo 'selected';} ?>>T7</option>
                                    <option value="T8" <?php if($setrows['elew2tier'] == 'T8'){echo 'selected';} ?>>T8</option>
                                    <option value="T9" <?php if($setrows['elew2tier'] == 'T9'){echo 'selected';} ?>>T9</option>
                                </select>

                                <select style="width:70%" name="famw1">
                                    <option value="-">-</option>
                                    <option value="critdmg" <?php if($setrows['famw1'] == 'critdmg'){echo 'selected';} ?>>Critical Damage</option>
                                </select>
                                <input placeholder="value" type="number" style="width:20%" name="famw1v" value="<?php echo $setrows['famw1v']; ?>">

                                <select style="width:70%" name="famw2">
                                    <option value="-">-</option>
                                    <option value="critdmg" <?php if($setrows['famw2'] == 'critdmg'){echo 'selected';} ?>>Critical Damage</option>
                                </select>
                                <input placeholder="value" type="number" style="width:20%" name="famw2v" value="<?php echo $setrows['famw2v']; ?>">
                            </div>
                            <div class="six columns">
                                <label><br></label>
                                <label for="elea1">Armor</label>
                                <?php for($i=1;$i<9;$i++){$stringc = 'elea'.$i.'c';$string = 'elea'.$i;$stringtier = 'elea'.$i.'tier'; ?>
                                    <select style="width:50%" name="elea<?php echo $i; ?>">
                                        <option value="-">-</option>
                                        <option value="Healing" <?php if($setrows[$string] == 'Others'){echo 'selected';} ?>>Healing</option>
                                        <option value="Toxic" <?php if($setrows[$string] == 'Others'){echo 'selected';} ?>>Toxic</option>
                                        <option value="Serenity" <?php if($setrows[$string] == 'Others'){echo 'selected';} ?>>Serenity</option>
                                        <option value="Hatred" <?php if($setrows[$string] == 'Others'){echo 'selected';} ?>>Hatred</option>
                                        <option value="Brilliance" <?php if($setrows[$string] == 'Others'){echo 'selected';} ?>>Brilliance</option>
                                        <option value="Evil" <?php if($setrows[$string] == 'Others'){echo 'selected';} ?>>Evil</option>
                                    </select>
                                    <select style="width:15%" name="elea<?php echo $i; ?>tier">
                                        <option value="-">-</option>
                                        <option value="T1" <?php if($setrows[$stringtier] == 'Others'){echo 'selected';} ?>>T1</option>
                                        <option value="T2" <?php if($setrows[$stringtier] == 'Others'){echo 'selected';} ?>>T2</option>
                                        <option value="T3" <?php if($setrows[$stringtier] == 'Others'){echo 'selected';} ?>>T3</option>
                                        <option value="T4" <?php if($setrows[$stringtier] == 'Others'){echo 'selected';} ?>>T4</option>
                                        <option value="T5" <?php if($setrows[$stringtier] == 'Others'){echo 'selected';} ?>>T5</option>
                                        <option value="T6" <?php if($setrows[$stringtier] == 'Others'){echo 'selected';} ?>>T6</option>
                                        <option value="T7" <?php if($setrows[$stringtier] == 'Others'){echo 'selected';} ?>>T7</option>
                                        <option value="T8" <?php if($setrows[$stringtier] == 'Others'){echo 'selected';} ?>>T8</option>
                                        <option value="T9" <?php if($setrows[$stringtier] == 'Others'){echo 'selected';} ?>>T9</option>
                                    </select>
                                    <input placeholder="count" type="number" style="width:20%" name="elea<?php echo $i; ?>c" 
                                    value="<?php echo $setrows[$stringc]; ?>">
                                <?php } ?>
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
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                charclass: '<?php if($update == 0){ echo 'Haru'; }else{ echo $setrows['charclass']; } ?>',
                charname: '<?php if($update == 0){ echo ''; }else{ echo $setrows['charname']; } ?>',
                lists: [1, 2, 3, 4, 5, 6, 7, 8],
                critrate: 0,
                atkspd: 100,
                pen: 0,
                dmgred: 0,
                critres: 0,
                sa: 0,
                dmgmob: 0,
                dmgboss: 0,
                elew: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['elew1']; } ?>',
                eledmg: 0,
                weapon_1: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['weapon_1']; } ?>',
                weapon_2: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['weapon_2']; } ?>',
                weapon_3: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['weapon_3']; } ?>',
                weapon_4: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['weapon_4']; } ?>',
                head_1: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['head_1']; } ?>',
                head_2: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['head_2']; } ?>',
                head_3: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['head_3']; } ?>',
                head_4: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['head_4']; } ?>',
                shoulder_1: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['shoulder_1']; } ?>',
                shoulder_2: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['shoulder_2']; } ?>',
                shoulder_3: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['shoulder_3']; } ?>',
                shoulder_4: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['shoulder_4']; } ?>',
                body_1: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['body_1']; } ?>',
                body_2: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['body_2']; } ?>',
                body_3: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['body_3']; } ?>',
                body_4: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['body_4']; } ?>',
                feet_1: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['feet_1']; } ?>',
                feet_2: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['feet_2']; } ?>',
                feet_3: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['feet_3']; } ?>',
                feet_4: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['feet_4']; } ?>',
                ear_1: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ear_1']; } ?>',
                ear_2: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ear_2']; } ?>',
                ear_3: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ear_3']; } ?>',
                ear_4: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ear_4']; } ?>',
                pen_1: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['pen_1']; } ?>',
                pen_2: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['pen_2']; } ?>',
                pen_3: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['pen_3']; } ?>',
                pen_4: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['pen_4']; } ?>',
                ring1_1: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ring1_1']; } ?>',
                ring1_2: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ring1_2']; } ?>',
                ring1_3: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ring1_3']; } ?>',
                ring1_4: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ring1_4']; } ?>',
                ring2_1: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ring2_1']; } ?>',
                ring2_2: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ring2_2']; } ?>',
                ring2_3: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ring2_3']; } ?>',
                ring2_4: '<?php if($update == 0){ echo '-'; }else{ echo $setrows['ring2_4']; } ?>',
                weaponL: ["-", "Accuracy",
                    "Attack",
                    "Attack Speed",
                    "Critical Damage",
                    "Critical Rate",
                    "Damage on Boss",
                    "Damage on Mobs",
                    "Penetration",
                    "SA Break",
                    "Soul Vapor Gain"
                ],
                headL: ["-", "Accuracy",
                    "Attack",
                    "CD Reduction",
                    "Critical Damage",
                    "Critical Rate*",
                    "Defense",
                    "Evaded Attack Damage",
                    "Evasion",
                    "EXP Gain",
                    "HP"
                ],
                shoulderL: ["-", "Accuracy",
                    "Attack",
                    "Attack Speed*",
                    "CD Reduction",
                    "Critical Damage",
                    "Defense",
                    "Evaded Attack Damage",
                    "Evasion",
                    "EXP Gain",
                    "HP"
                ],
                bodyL: ["-", "Accuracy",
                    "Attack",
                    "CD Reduction",
                    "Critical Damage",
                    "Defense",
                    "Evaded Attack Damage",
                    "Evasion",
                    "EXP Gain",
                    "HP",
                    "HP%*"
                ],
                feetL: ["-", "Accuracy",
                    "Attack",
                    "CD Reduction",
                    "Critical Damage",
                    "Defense",
                    "Evaded Attack Damage",
                    "Evasion",
                    "EXP Gain",
                    "HP",
                    "Move Speed*"
                ],
                earL: ["-", "Accuracy",
                    "Attack",
                    "Attack Speed",
                    "Critical Damage",
                    "Critical Rate",
                    "Damage Reduction from Boss",
                    "Defense",
                    "Evasion",
                    "EXP Gain",
                    "Max Stamina",
                    "Move Speed",
                    "On kill HP",
                    "SA Break",
                    "Soul Vapor Gain"
                ],
                penL: ["-", "Accuracy",
                    "Attack",
                    "Attack Speed",
                    "CD Reduction",
                    "Critical Damage",
                    "Critical Resistance",
                    "Damage Reduction",
                    "Damage Reduction from Boss",
                    "Defense",
                    "Evasion",
                    "EXP Gain",
                    "Max Stamina",
                    "On kill HP",
                    "SA Break"
                ],
                ringL: ["-", "Accuracy",
                    "Attack",
                    "Critical Damage",
                    "Critical Rate",
                    "Critical Resistance",
                    "Damage Reduction from Boss",
                    "Damage Reduction from Mob",
                    "Defense",
                    "Evasion"
                ],
                harustat: {
                    hp: 22750,
                    minatk: 1008,
                    maxatk: 1260,
                    cdmg: 1008,
                    acc: 972,
                    def: 345,
                    eva: 34,
                    samelvldef: 11.15
                },
                erwinstat: {
                    hp: 20000,
                    minatk: 1008,
                    maxatk: 1260,
                    cdmg: 1008,
                    acc: 1012,
                    def: 275,
                    eva: 37,
                    samelvldef: 9.09
                },
                lilystat: {
                    hp: 17350,
                    minatk: 1108,
                    maxatk: 1386,
                    cdmg: 1108,
                    acc: 886,
                    def: 240,
                    eva: 44,
                    samelvldef: 8.03
                },
                stellastat: {
                    hp: 17300,
                    minatk: 1108,
                    maxatk: 1386,
                    cdmg: 1108,
                    acc: 972,
                    def: 275,
                    eva: 37,
                    samelvldef: 9.09
                },
                jinstat: {
                    hp: 25450,
                    minatk: 907,
                    maxatk: 1134,
                    cdmg: 907,
                    acc: 920,
                    def: 515,
                    eva: 31,
                    samelvldef: 15.77
                },
                irisstat: {
                    hp: 14600,
                    minatk: 1209,
                    maxatk: 1512,
                    cdmg: 1209,
                    acc: 955,
                    def: 345,
                    eva: 31,
                    samelvldef: 11.15
                }
            }
        })
    </script>
</body>

</html>
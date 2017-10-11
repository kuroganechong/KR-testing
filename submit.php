<?php
    require('common.php');
    if(!empty($_POST))
    {
        // sanitize input
        function sanitize($in){
            $in = trim($in);
            $in = filter_var($in, FILTER_SANITIZE_STRING);
            return $in;
        }
        $array = [];
        foreach($_POST as $key => $value){
            $value = sanitize($value);
            $array[$key] = $value;
        }
        $_POST = $array;

        // check if discord name/charname pair exists
        $query = "SELECT discordname, charname, setno FROM characters";
        try
        {
            $stmt = $db->query($query);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query".$i);
        }
        $rows = $stmt->fetchAll();
        $nodupe = 1;
        foreach($rows as $row){
            if($row['discordname'] == $_POST['discordname'] && $row['charname'] == $_POST['charname']){
                $setno = $row['setno'];
                $nodupe = 0;
                break;
            }else{
                $nodupe = 1;
            }
        }

        if($nodupe == 1){
            $setno = mt_rand();
            // creating character list
            $query = "
                INSERT INTO characters (
                    discordname,
                    charname,
                    charclass,
                    setno,
                    edit
                ) VALUES (
                    :discordname,
                    :charname,
                    :charclass,
                    :setno,
                    :edit
                )
            ";
            $query_params = array(
                ':discordname' => $_POST['discordname'],
                ':charname' => $_POST['charname'],
                ':charclass' => $_POST['charclass'],
                ':setno' => $setno,
                ':edit' => 1
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die($ex);
            }

            // creating gear list
            $query = "
                INSERT INTO sets (
                    setno,
                    weapon,
                    weapon_en,
                    weapon_gd,
                    weapon_1,
                    weapon_1_val,
                    weapon_2,
                    weapon_2_val,
                    weapon_3,
                    weapon_3_val,
                    weapon_4,
                    weapon_4_val,
                    head,
                    head_en,
                    head_gd,
                    head_1,
                    head_1_val,
                    head_2,
                    head_2_val,
                    head_3,
                    head_3_val,
                    head_4,
                    head_4_val,
                    shoulder,
                    shoulder_en,
                    shoulder_gd,
                    shoulder_1,
                    shoulder_1_val,
                    shoulder_2,
                    shoulder_2_val,
                    shoulder_3,
                    shoulder_3_val,
                    shoulder_4,
                    shoulder_4_val,
                    body,
                    body_en,
                    body_gd,
                    body_1,
                    body_1_val,
                    body_2,
                    body_2_val,
                    body_3,
                    body_3_val,
                    body_4,
                    body_4_val,
                    feet,
                    feet_en,
                    feet_gd,
                    feet_1,
                    feet_1_val,
                    feet_2,
                    feet_2_val,
                    feet_3,
                    feet_3_val,
                    feet_4,
                    feet_4_val,
                    ear,
                    ear_1,
                    ear_1_val,
                    ear_2,
                    ear_2_val,
                    ear_3,
                    ear_3_val,
                    ear_4,
                    ear_4_val,
                    pen,
                    pen_1,
                    pen_1_val,
                    pen_2,
                    pen_2_val,
                    pen_3,
                    pen_3_val,
                    pen_4,
                    pen_4_val,
                    ring1,
                    ring1_1,
                    ring1_1_val,
                    ring1_2,
                    ring1_2_val,
                    ring1_3,
                    ring1_3_val,
                    ring1_4,
                    ring1_4_val,
                    ring2,
                    ring2_1,
                    ring2_1_val,
                    ring2_2,
                    ring2_2_val,
                    ring2_3,
                    ring2_3_val,
                    ring2_4,
                    ring2_4_val,
                    elew1,
                    elew1tier,
                    elew2,
                    elew2tier,
                    famw1,
                    famw1v,
                    famw2,
                    famw2v,
                    elea1,
                    elea1tier,
                    elea1c,
                    elea2,
                    elea2tier,
                    elea2c,
                    elea3,
                    elea3tier,
                    elea3c,
                    elea4,
                    elea4tier,
                    elea4c,
                    elea5,
                    elea5tier,
                    elea5c,
                    elea6,
                    elea6tier,
                    elea6c,
                    elea7,
                    elea7tier,
                    elea7c,
                    elea8,
                    elea8tier,
                    elea8c
                ) VALUES (
                    :setno,
                    :weapon,
                    :weapon_en,
                    :weapon_gd,
                    :weapon_1,
                    :weapon_1_val,
                    :weapon_2,
                    :weapon_2_val,
                    :weapon_3,
                    :weapon_3_val,
                    :weapon_4,
                    :weapon_4_val,
                    :head,
                    :head_en,
                    :head_gd,
                    :head_1,
                    :head_1_val,
                    :head_2,
                    :head_2_val,
                    :head_3,
                    :head_3_val,
                    :head_4,
                    :head_4_val,
                    :shoulder,
                    :shoulder_en,
                    :shoulder_gd,
                    :shoulder_1,
                    :shoulder_1_val,
                    :shoulder_2,
                    :shoulder_2_val,
                    :shoulder_3,
                    :shoulder_3_val,
                    :shoulder_4,
                    :shoulder_4_val,
                    :body,
                    :body_en,
                    :body_gd,
                    :body_1,
                    :body_1_val,
                    :body_2,
                    :body_2_val,
                    :body_3,
                    :body_3_val,
                    :body_4,
                    :body_4_val,
                    :feet,
                    :feet_en,
                    :feet_gd,
                    :feet_1,
                    :feet_1_val,
                    :feet_2,
                    :feet_2_val,
                    :feet_3,
                    :feet_3_val,
                    :feet_4,
                    :feet_4_val,
                    :ear,
                    :ear_1,
                    :ear_1_val,
                    :ear_2,
                    :ear_2_val,
                    :ear_3,
                    :ear_3_val,
                    :ear_4,
                    :ear_4_val,
                    :pen,
                    :pen_1,
                    :pen_1_val,
                    :pen_2,
                    :pen_2_val,
                    :pen_3,
                    :pen_3_val,
                    :pen_4,
                    :pen_4_val,
                    :ring1,
                    :ring1_1,
                    :ring1_1_val,
                    :ring1_2,
                    :ring1_2_val,
                    :ring1_3,
                    :ring1_3_val,
                    :ring1_4,
                    :ring1_4_val,
                    :ring2,
                    :ring2_1,
                    :ring2_1_val,
                    :ring2_2,
                    :ring2_2_val,
                    :ring2_3,
                    :ring2_3_val,
                    :ring2_4,
                    :ring2_4_val,
                    :elew1,
                    :elew1tier,
                    :elew2,
                    :elew2tier,
                    :famw1,
                    :famw1v,
                    :famw2,
                    :famw2v,
                    :elea1,
                    :elea1tier,
                    :elea1c,
                    :elea2,
                    :elea2tier,
                    :elea2c,
                    :elea3,
                    :elea3tier,
                    :elea3c,
                    :elea4,
                    :elea4tier,
                    :elea4c,
                    :elea5,
                    :elea5tier,
                    :elea5c,
                    :elea6,
                    :elea6tier,
                    :elea6c,
                    :elea7,
                    :elea7tier,
                    :elea7c,
                    :elea8,
                    :elea8tier,
                    :elea8c
                )
            ";
            $query_params = array(
                ':setno' => $setno,
                ':weapon' => $_POST['weapon'],
                ':weapon_en' => $_POST['weapon_en'],
                ':weapon_gd' => $_POST['weapon_gd'],
                ':weapon_1' => $_POST['weapon_1'],
                ':weapon_1_val' => $_POST['weapon_1_val'],
                ':weapon_2' => $_POST['weapon_2'],
                ':weapon_2_val' => $_POST['weapon_2_val'],
                ':weapon_3' => $_POST['weapon_3'],
                ':weapon_3_val' => $_POST['weapon_3_val'],
                ':weapon_4' => $_POST['weapon_4'],
                ':weapon_4_val' => $_POST['weapon_4_val'],
                ':head' => $_POST['head'],
                ':head_en' => $_POST['head_en'],
                ':head_gd' => $_POST['head_gd'],
                ':head_1' => $_POST['head_1'],
                ':head_1_val' => $_POST['head_1_val'],
                ':head_2' => $_POST['head_2'],
                ':head_2_val' => $_POST['head_2_val'],
                ':head_3' => $_POST['head_3'],
                ':head_3_val' => $_POST['head_3_val'],
                ':head_4' => $_POST['head_4'],
                ':head_4_val' => $_POST['head_4_val'],
                ':shoulder' => $_POST['shoulder'],
                ':shoulder_en' => $_POST['shoulder_en'],
                ':shoulder_gd' => $_POST['shoulder_gd'],
                ':shoulder_1' => $_POST['shoulder_1'],
                ':shoulder_1_val' => $_POST['shoulder_1_val'],
                ':shoulder_2' => $_POST['shoulder_2'],
                ':shoulder_2_val' => $_POST['shoulder_2_val'],
                ':shoulder_3' => $_POST['shoulder_3'],
                ':shoulder_3_val' => $_POST['shoulder_3_val'],
                ':shoulder_4' => $_POST['shoulder_4'],
                ':shoulder_4_val' => $_POST['shoulder_4_val'],
                ':body' => $_POST['body'],
                ':body_en' => $_POST['body_en'],
                ':body_gd' => $_POST['body_gd'],
                ':body_1' => $_POST['body_1'],
                ':body_1_val' => $_POST['body_1_val'],
                ':body_2' => $_POST['body_2'],
                ':body_2_val' => $_POST['body_2_val'],
                ':body_3' => $_POST['body_3'],
                ':body_3_val' => $_POST['body_3_val'],
                ':body_4' => $_POST['body_4'],
                ':body_4_val' => $_POST['body_4_val'],
                ':feet' => $_POST['feet'],
                ':feet_en' => $_POST['feet_en'],
                ':feet_gd' => $_POST['feet_gd'],
                ':feet_1' => $_POST['feet_1'],
                ':feet_1_val' => $_POST['feet_1_val'],
                ':feet_2' => $_POST['feet_2'],
                ':feet_2_val' => $_POST['feet_2_val'],
                ':feet_3' => $_POST['feet_3'],
                ':feet_3_val' => $_POST['feet_3_val'],
                ':feet_4' => $_POST['feet_4'],
                ':feet_4_val' => $_POST['feet_4_val'],
                ':ear' => $_POST['ear'],
                ':ear_1' => $_POST['ear_1'],
                ':ear_1_val' => $_POST['ear_1_val'],
                ':ear_2' => $_POST['ear_2'],
                ':ear_2_val' => $_POST['ear_2_val'],
                ':ear_3' => $_POST['ear_3'],
                ':ear_3_val' => $_POST['ear_3_val'],
                ':ear_4' => $_POST['ear_4'],
                ':ear_4_val' => $_POST['ear_4_val'],
                ':pen' => $_POST['pen'],
                ':pen_1' => $_POST['pen_1'],
                ':pen_1_val' => $_POST['pen_1_val'],
                ':pen_2' => $_POST['pen_2'],
                ':pen_2_val' => $_POST['pen_2_val'],
                ':pen_3' => $_POST['pen_3'],
                ':pen_3_val' => $_POST['pen_3_val'],
                ':pen_4' => $_POST['pen_4'],
                ':pen_4_val' => $_POST['pen_4_val'],
                ':ring1' => $_POST['ring1'],
                ':ring1_1' => $_POST['ring1_1'],
                ':ring1_1_val' => $_POST['ring1_1_val'],
                ':ring1_2' => $_POST['ring1_2'],
                ':ring1_2_val' => $_POST['ring1_2_val'],
                ':ring1_3' => $_POST['ring1_3'],
                ':ring1_3_val' => $_POST['ring1_3_val'],
                ':ring1_4' => $_POST['ring1_4'],
                ':ring1_4_val' => $_POST['ring1_4_val'],
                ':ring2' => $_POST['ring2'],
                ':ring2_1' => $_POST['ring2_1'],
                ':ring2_1_val' => $_POST['ring2_1_val'],
                ':ring2_2' => $_POST['ring2_2'],
                ':ring2_2_val' => $_POST['ring2_2_val'],
                ':ring2_3' => $_POST['ring2_3'],
                ':ring2_3_val' => $_POST['ring2_3_val'],
                ':ring2_4' => $_POST['ring2_4'],
                ':ring2_4_val' => $_POST['ring2_4_val'],
                ':elea1' => $_POST['elea1'],
                ':elea1tier' => $_POST['elea1tier'],
                ':elea1c' => $_POST['elea1c'],
                ':pen_2' => $_POST['pen_2'],
                ':pen_2_val' => $_POST['pen_2_val'],
                ':pen_3' => $_POST['pen_3'],
                ':pen_3_val' => $_POST['pen_3_val'],
                ':pen_4' => $_POST['pen_4'],
                ':pen_4_val' => $_POST['pen_4_val'],
                ':ring1' => $_POST['ring1'],
                ':ring1_1' => $_POST['ring1_1'],
                ':ring1_1_val' => $_POST['ring1_1_val'],
                ':ring1_2' => $_POST['ring1_2'],
                ':ring1_2_val' => $_POST['ring1_2_val'],
                ':ring1_3' => $_POST['ring1_3'],
                ':ring1_3_val' => $_POST['ring1_3_val'],
                ':ring1_4' => $_POST['ring1_4'],
                ':ring1_4_val' => $_POST['ring1_4_val'],
                ':ring2' => $_POST['ring2'],
                ':ring2_1' => $_POST['ring2_1'],
                ':ring2_1_val' => $_POST['ring2_1_val'],
                ':ring2_2' => $_POST['ring2_2'],
                ':ring2_2_val' => $_POST['ring2_2_val'],
                ':ring2_3' => $_POST['ring2_3'],
                ':ring2_3_val' => $_POST['ring2_3_val'],
                ':ring2_4' => $_POST['ring2_4'],
                ':ring2_4_val' => $_POST['ring2_4_val'],
                ':elew1' => $_POST['elew1'],
                ':elew1tier' => $_POST['elew1tier'],
                ':elew2' => $_POST['elew2'],
                ':elew2tier' => $_POST['elew2tier'],
                ':famw1' => $_POST['famw1'],
                ':famw1v' => $_POST['famw1v'],
                ':famw2' => $_POST['famw2'],
                ':famw2v' => $_POST['famw2v'],
                ':elea1' => $_POST['elea1'],
                ':elea1tier' => $_POST['elea1tier'],
                ':elea1c' => $_POST['elea1c'],
                ':elea2' => $_POST['elea2'],
                ':elea2tier' => $_POST['elea2tier'],
                ':elea2c' => $_POST['elea2c'],
                ':elea3' => $_POST['elea3'],
                ':elea3tier' => $_POST['elea3tier'],
                ':elea3c' => $_POST['elea3c'],
                ':elea4' => $_POST['elea4'],
                ':elea4tier' => $_POST['elea4tier'],
                ':elea4c' => $_POST['elea4c'],
                ':elea5' => $_POST['elea5'],
                ':elea5tier' => $_POST['elea5tier'],
                ':elea5c' => $_POST['elea5c'],
                ':elea6' => $_POST['elea6'],
                ':elea6tier' => $_POST['elea6tier'],
                ':elea6c' => $_POST['elea6c'],
                ':elea7' => $_POST['elea7'],
                ':elea7tier' => $_POST['elea7tier'],
                ':elea7c' => $_POST['elea7c'],
                ':elea8' => $_POST['elea8'],
                ':elea8tier' => $_POST['elea8tier'],
                ':elea8c' => $_POST['elea8c']
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die($ex);
            }
            echo '<script>alert("Data recorded!");window.location.href="index.php";</script>';
            die();
        } else{
            // update edit times
            $query = "SELECT edit FROM characters WHERE setno = :setno";
            $query_params = array(":setno" => $setno);
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die("Failed to run query");
            }
            $edit = $stmt->fetch();
            $edit['edit'] = $edit['edit'] +1;
            $query = "
                UPDATE characters SET edit = :edit WHERE setno = :setno
            ";
            $query_params = array(
                ':edit' => $edit['edit'],
                ':setno' => $setno
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die($ex);
            }
            // creating gear list
            $query = "
                UPDATE sets SET
                    weapon = :weapon,
                    weapon_en = :weapon_en,
                    weapon_gd = :weapon_gd,
                    weapon_1 = :weapon_1,
                    weapon_1_val = :weapon_1_val,
                    weapon_2 = :weapon_2,
                    weapon_2_val = :weapon_2_val,
                    weapon_3 = :weapon_3,
                    weapon_3_val = :weapon_3_val,
                    weapon_4 = :weapon_4,
                    weapon_4_val = :weapon_4_val,
                    head = :head,
                    head_en = :head_en,
                    head_gd = :head_gd,
                    head_1 = :head_1,
                    head_1_val = :head_1_val,
                    head_2 = :head_2,
                    head_2_val = :head_2_val,
                    head_3 = :head_3,
                    head_3_val = :head_3_val,
                    head_4 = :head_4,
                    head_4_val = :head_4_val,
                    shoulder = :shoulder,
                    shoulder_en = :shoulder_en,
                    shoulder_gd = :shoulder_gd,
                    shoulder_1 = :shoulder_1,
                    shoulder_1_val = :shoulder_1_val,
                    shoulder_2 = :shoulder_2,
                    shoulder_2_val = :shoulder_2_val,
                    shoulder_3 = :shoulder_3,
                    shoulder_3_val = :shoulder_3_val,
                    shoulder_4 = :shoulder_4,
                    shoulder_4_val = :shoulder_4_val,
                    body = :body,
                    body_en = :body_en,
                    body_gd = :body_gd,
                    body_1 = :body_1,
                    body_1_val = :body_1_val,
                    body_2 = :body_2,
                    body_2_val = :body_2_val,
                    body_3 = :body_3,
                    body_3_val = :body_3_val,
                    body_4 = :body_4,
                    body_4_val = :body_4_val,
                    feet = :feet,
                    feet_en = :feet_en,
                    feet_gd = :feet_gd,
                    feet_1 = :feet_1,
                    feet_1_val = :feet_1_val,
                    feet_2 = :feet_2,
                    feet_2_val = :feet_2_val,
                    feet_3 = :feet_3,
                    feet_3_val = :feet_3_val,
                    feet_4 = :feet_4,
                    feet_4_val = :feet_4_val,
                    ear = :ear,
                    ear_1 = :ear_1,
                    ear_1_val = :ear_1_val,
                    ear_2 = :ear_2,
                    ear_2_val = :ear_2_val,
                    ear_3 = :ear_3,
                    ear_3_val = :ear_3_val,
                    ear_4 = :ear_4,
                    ear_4_val = :ear_4_val,
                    pen = :pen,
                    pen_1 = :pen_1,
                    pen_1_val = :pen_1_val,
                    pen_2 = :pen_2,
                    pen_2_val = :pen_2_val,
                    pen_3 = :pen_3,
                    pen_3_val = :pen_3_val,
                    pen_4 = :pen_4,
                    pen_4_val = :pen_4_val,
                    ring1 = :ring1,
                    ring1_1 = :ring1_1,
                    ring1_1_val = :ring1_1_val,
                    ring1_2 = :ring1_2,
                    ring1_2_val = :ring1_2_val,
                    ring1_3 = :ring1_3,
                    ring1_3_val = :ring1_3_val,
                    ring1_4 = :ring1_4,
                    ring1_4_val = :ring1_4_val,
                    ring2 = :ring2,
                    ring2_1 = :ring2_1,
                    ring2_1_val = :ring2_1_val,
                    ring2_2 = :ring2_2,
                    ring2_2_val = :ring2_2_val,
                    ring2_3 = :ring2_3,
                    ring2_3_val = :ring2_3_val,
                    ring2_4 = :ring2_4,
                    ring2_4_val = :ring2_4_val,
                    elew1 = :elew1,
                    elew1tier = :elew1tier,
                    elew2 = :elew2,
                    elew2tier = :elew2tier,
                    famw1 = :famw1,
                    famw1v = :famw1v,
                    famw2 = :famw2,
                    famw2v = :famw2v,
                    elea1 = :elea1,
                    elea1tier = :elea1tier,
                    elea1c = :elea1c,
                    elea2 = :elea2,
                    elea2tier = :elea2tier,
                    elea2c = :elea2c,
                    elea3 = :elea3,
                    elea3tier = :elea3tier,
                    elea3c = :elea3c,
                    elea4 = :elea4,
                    elea4tier = :elea4tier,
                    elea4c = :elea4c,
                    elea5 = :elea5,
                    elea5tier = :elea5tier,
                    elea5c = :elea5c,
                    elea6 = :elea6,
                    elea6tier = :elea6tier,
                    elea6c = :elea6c,
                    elea7 = :elea7,
                    elea7tier = :elea7tier,
                    elea7c = :elea7c,
                    elea8 = :elea8,
                    elea8tier = :elea8tier,
                    elea8c = :elea8c
                WHERE setno = :setno
            ";
            $query_params = array(
                ':setno' => $setno,
                ':weapon' => $_POST['weapon'],
                ':weapon_en' => $_POST['weapon_en'],
                ':weapon_gd' => $_POST['weapon_gd'],
                ':weapon_1' => $_POST['weapon_1'],
                ':weapon_1_val' => $_POST['weapon_1_val'],
                ':weapon_2' => $_POST['weapon_2'],
                ':weapon_2_val' => $_POST['weapon_2_val'],
                ':weapon_3' => $_POST['weapon_3'],
                ':weapon_3_val' => $_POST['weapon_3_val'],
                ':weapon_4' => $_POST['weapon_4'],
                ':weapon_4_val' => $_POST['weapon_4_val'],
                ':head' => $_POST['head'],
                ':head_en' => $_POST['head_en'],
                ':head_gd' => $_POST['head_gd'],
                ':head_1' => $_POST['head_1'],
                ':head_1_val' => $_POST['head_1_val'],
                ':head_2' => $_POST['head_2'],
                ':head_2_val' => $_POST['head_2_val'],
                ':head_3' => $_POST['head_3'],
                ':head_3_val' => $_POST['head_3_val'],
                ':head_4' => $_POST['head_4'],
                ':head_4_val' => $_POST['head_4_val'],
                ':shoulder' => $_POST['shoulder'],
                ':shoulder_en' => $_POST['shoulder_en'],
                ':shoulder_gd' => $_POST['shoulder_gd'],
                ':shoulder_1' => $_POST['shoulder_1'],
                ':shoulder_1_val' => $_POST['shoulder_1_val'],
                ':shoulder_2' => $_POST['shoulder_2'],
                ':shoulder_2_val' => $_POST['shoulder_2_val'],
                ':shoulder_3' => $_POST['shoulder_3'],
                ':shoulder_3_val' => $_POST['shoulder_3_val'],
                ':shoulder_4' => $_POST['shoulder_4'],
                ':shoulder_4_val' => $_POST['shoulder_4_val'],
                ':body' => $_POST['body'],
                ':body_en' => $_POST['body_en'],
                ':body_gd' => $_POST['body_gd'],
                ':body_1' => $_POST['body_1'],
                ':body_1_val' => $_POST['body_1_val'],
                ':body_2' => $_POST['body_2'],
                ':body_2_val' => $_POST['body_2_val'],
                ':body_3' => $_POST['body_3'],
                ':body_3_val' => $_POST['body_3_val'],
                ':body_4' => $_POST['body_4'],
                ':body_4_val' => $_POST['body_4_val'],
                ':feet' => $_POST['feet'],
                ':feet_en' => $_POST['feet_en'],
                ':feet_gd' => $_POST['feet_gd'],
                ':feet_1' => $_POST['feet_1'],
                ':feet_1_val' => $_POST['feet_1_val'],
                ':feet_2' => $_POST['feet_2'],
                ':feet_2_val' => $_POST['feet_2_val'],
                ':feet_3' => $_POST['feet_3'],
                ':feet_3_val' => $_POST['feet_3_val'],
                ':feet_4' => $_POST['feet_4'],
                ':feet_4_val' => $_POST['feet_4_val'],
                ':ear' => $_POST['ear'],
                ':ear_1' => $_POST['ear_1'],
                ':ear_1_val' => $_POST['ear_1_val'],
                ':ear_2' => $_POST['ear_2'],
                ':ear_2_val' => $_POST['ear_2_val'],
                ':ear_3' => $_POST['ear_3'],
                ':ear_3_val' => $_POST['ear_3_val'],
                ':ear_4' => $_POST['ear_4'],
                ':ear_4_val' => $_POST['ear_4_val'],
                ':pen' => $_POST['pen'],
                ':pen_1' => $_POST['pen_1'],
                ':pen_1_val' => $_POST['pen_1_val'],
                ':pen_2' => $_POST['pen_2'],
                ':pen_2_val' => $_POST['pen_2_val'],
                ':pen_3' => $_POST['pen_3'],
                ':pen_3_val' => $_POST['pen_3_val'],
                ':pen_4' => $_POST['pen_4'],
                ':pen_4_val' => $_POST['pen_4_val'],
                ':ring1' => $_POST['ring1'],
                ':ring1_1' => $_POST['ring1_1'],
                ':ring1_1_val' => $_POST['ring1_1_val'],
                ':ring1_2' => $_POST['ring1_2'],
                ':ring1_2_val' => $_POST['ring1_2_val'],
                ':ring1_3' => $_POST['ring1_3'],
                ':ring1_3_val' => $_POST['ring1_3_val'],
                ':ring1_4' => $_POST['ring1_4'],
                ':ring1_4_val' => $_POST['ring1_4_val'],
                ':ring2' => $_POST['ring2'],
                ':ring2_1' => $_POST['ring2_1'],
                ':ring2_1_val' => $_POST['ring2_1_val'],
                ':ring2_2' => $_POST['ring2_2'],
                ':ring2_2_val' => $_POST['ring2_2_val'],
                ':ring2_3' => $_POST['ring2_3'],
                ':ring2_3_val' => $_POST['ring2_3_val'],
                ':ring2_4' => $_POST['ring2_4'],
                ':ring2_4_val' => $_POST['ring2_4_val'],
                ':elew1' => $_POST['elew1'],
                ':elew1tier' => $_POST['elew1tier'],
                ':elew2' => $_POST['elew2'],
                ':elew2tier' => $_POST['elew2tier'],
                ':famw1' => $_POST['famw1'],
                ':famw1v' => $_POST['famw1v'],
                ':famw2' => $_POST['famw2'],
                ':famw2v' => $_POST['famw2v'],
                ':elea1' => $_POST['elea1'],
                ':elea1tier' => $_POST['elea1tier'],
                ':elea1c' => $_POST['elea1c'],
                ':elea2' => $_POST['elea2'],
                ':elea2tier' => $_POST['elea2tier'],
                ':elea2c' => $_POST['elea2c'],
                ':elea3' => $_POST['elea3'],
                ':elea3tier' => $_POST['elea3tier'],
                ':elea3c' => $_POST['elea3c'],
                ':elea4' => $_POST['elea4'],
                ':elea4tier' => $_POST['elea4tier'],
                ':elea4c' => $_POST['elea4c'],
                ':elea5' => $_POST['elea5'],
                ':elea5tier' => $_POST['elea5tier'],
                ':elea5c' => $_POST['elea5c'],
                ':elea6' => $_POST['elea6'],
                ':elea6tier' => $_POST['elea6tier'],
                ':elea6c' => $_POST['elea6c'],
                ':elea7' => $_POST['elea7'],
                ':elea7tier' => $_POST['elea7tier'],
                ':elea7c' => $_POST['elea7c'],
                ':elea8' => $_POST['elea8'],
                ':elea8tier' => $_POST['elea8tier'],
                ':elea8c' => $_POST['elea8c']
            );
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                die($ex);
            }
            echo '<script>alert("Data updated!");window.location.href="index.php";</script>';
            die();
        }
    }
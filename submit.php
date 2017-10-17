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

        if($_POST['discordname'] == '' || $_POST['charname'] == ''){
            die('Empty name!');
        }

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

            // creating stats list
            $query = "
                INSERT INTO stats (
                    setno,
                    minatk,
                    maxatk,
                    bossdmg,
                    critrate,
                    critdmg,
                    atkspd,
                    pen,
                    primaldmg,
                    eletype1,
                    eledmg1,
                    eletype2,
                    eledmg2,
                    hp,
                    def,
                    dmgrd,
                    bossdmgrd,
                    mobdmgrd,
                    primaldef,
                    ar1,
                    ar1t,
                    ar2,
                    ar2t,
                    ar3,
                    ar3t,
                    ar4,
                    ar4t,
                    ar5,
                    ar5t
                ) VALUES (
                    :setno,
                    :minatk,
                    :maxatk,
                    :bossdmg,
                    :critrate,
                    :critdmg,
                    :atkspd,
                    :pen,
                    :primaldmg,
                    :eletype1,
                    :eledmg1,
                    :eletype2,
                    :eledmg2,
                    :hp,
                    :def,
                    :dmgrd,
                    :bossdmgrd,
                    :mobdmgrd,
                    :primaldef,
                    :ar1,
                    :ar1t,
                    :ar2,
                    :ar2t,
                    :ar3,
                    :ar3t,
                    :ar4,
                    :ar4t,
                    :ar5,
                    :ar5t
                )
            ";
            $query_params = array(
                ':setno' => $setno,
                ':minatk' => $_POST['minatk'],
                ':maxatk' => $_POST['maxatk'],
                ':bossdmg' => $_POST['bossdmg'],
                ':critrate' => $_POST['critrate'],
                ':critdmg' => $_POST['critdmg'],
                ':atkspd' => $_POST['atkspd'],
                ':pen' => $_POST['pen'],
                ':primaldmg' => $_POST['primaldmg'],
                ':eletype1' => $_POST['eletype1'],
                ':eledmg1' => $_POST['eledmg1'],
                ':eletype2' => $_POST['eletype2'],
                ':eledmg2' => $_POST['eledmg2'],
                ':hp' => $_POST['hp'],
                ':def' => $_POST['def'],
                ':dmgrd' => $_POST['dmgrd'],
                ':bossdmgrd' => $_POST['bossdmgrd'],
                ':mobdmgrd' => $_POST['mobdmgrd'],
                ':primaldef' => $_POST['primaldef'],
                ':ar1' => $_POST['ar1'],
                ':ar1t' => $_POST['ar1t'],
                ':ar2' => $_POST['ar2'],
                ':ar2t' => $_POST['ar2t'],
                ':ar3' => $_POST['ar3'],
                ':ar3t' => $_POST['ar3t'],
                ':ar4' => $_POST['ar4'],
                ':ar4t' => $_POST['ar4t'],
                ':ar5' => $_POST['ar5'],
                ':ar5t' => $_POST['ar5t']
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

            // updating stats list
            $query = "
                UPDATE stats SET
                    minatk = :minatk,
                    maxatk = :maxatk,
                    bossdmg = :bossdmg,
                    critrate = :critrate,
                    critdmg = :critdmg,
                    atkspd = :atkspd,
                    pen = :pen,
                    primaldmg = :primaldmg,
                    eletype1 = :eletype1,
                    eledmg1 = :eledmg1,
                    eletype2 = :eletype2,
                    eledmg2 = :eledmg2,
                    hp = :hp,
                    def = :def,
                    dmgrd = :dmgrd,
                    bossdmgrd = :bossdmgrd,
                    mobdmgrd = :mobdmgrd,
                    primaldef = :primaldef,
                    ar1 = :ar1,
                    ar1t = :ar1t,
                    ar2 = :ar2,
                    ar2t = :ar2t,
                    ar3 = :ar3,
                    ar3t = :ar3t,
                    ar4 = :ar4,
                    ar4t = :ar4t,
                    ar5 = :ar5,
                    ar5t = :ar5t
                WHERE setno = :setno
            ";
            $query_params = array(
                ':setno' => $setno,
                ':minatk' => $_POST['minatk'],
                ':maxatk' => $_POST['maxatk'],
                ':bossdmg' => $_POST['bossdmg'],
                ':critrate' => $_POST['critrate'],
                ':critdmg' => $_POST['critdmg'],
                ':atkspd' => $_POST['atkspd'],
                ':pen' => $_POST['pen'],
                ':primaldmg' => $_POST['primaldmg'],
                ':eletype1' => $_POST['eletype1'],
                ':eledmg1' => $_POST['eledmg1'],
                ':eletype2' => $_POST['eletype2'],
                ':eledmg2' => $_POST['eledmg2'],
                ':hp' => $_POST['hp'],
                ':def' => $_POST['def'],
                ':dmgrd' => $_POST['dmgrd'],
                ':bossdmgrd' => $_POST['bossdmgrd'],
                ':mobdmgrd' => $_POST['mobdmgrd'],
                ':primaldef' => $_POST['primaldef'],
                ':ar1' => $_POST['ar1'],
                ':ar1t' => $_POST['ar1t'],
                ':ar2' => $_POST['ar2'],
                ':ar2t' => $_POST['ar2t'],
                ':ar3' => $_POST['ar3'],
                ':ar3t' => $_POST['ar3t'],
                ':ar4' => $_POST['ar4'],
                ':ar4t' => $_POST['ar4t'],
                ':ar5' => $_POST['ar5'],
                ':ar5t' => $_POST['ar5t']
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
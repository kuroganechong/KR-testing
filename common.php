<?php
    // Connection information for MySQL database 
    $username = "id3210907_miracle"; 
    $password = "miracle"; 
    $host = "localhost"; 
    $dbname = "id3210907_miracle"; 
    // Telling the MySQL server that we want to communicate with it using UTF-8 
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4');
    
    // Capturing errors
    try 
    { 
        $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password, $options); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to connect to the database");
    } 
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     
    // Removing magic quotes
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 
    
    // Content is encoded using UTF-8
    header('Content-Type: text/html; charset=utf-8'); 

    //set timezone
    date_default_timezone_set('Asia/Singapore');
    
    ini_set('session.gc_maxlifetime', 1800);
    // Initializes a session.
    session_start(); 
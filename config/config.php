<?php


try{

    //host
    define('HOST', 'localhost');
    
    //dbname
    define('DBNAME','coffee-blend');
    
    //user
    define('USER', 'root');
    
    //password
    define('PASSWORD', '');
    
    $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . '', USER, PASSWORD);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo $e->getMessage();
}
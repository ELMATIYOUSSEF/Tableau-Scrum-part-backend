<?php
    
    //CONNECT TO MYSQL DATABASE USING MYSQLI
    $_SERVER ='localhost';
    $_Root ='root';
    $_Password='';
    $_DataBase ='TableBord';

    //database connection 
    $connection = mysqli_connect($_SERVER,$_Root,$_Password,$_DataBase);
    if(!$connection)
    {
        die("NOT connecte" . mysqli_connect_error());
    }
    else
    {
        echo 'connection successfully';
    }
?>
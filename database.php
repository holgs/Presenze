<?php
//Connect to mySQL
    $server = "localhost";
    $username = "adiuva01";
    $password = "adiuva01";
    $db = "ad-iuva";
    $con = mysqli_connect($server,$username,$password,$db);
    if(mysqli_connect_errno()){
        echo 'Errore di Connessione:'.mysqli_connect_error();
    }
?>
<?php
function dbconnect(){
    $dbIP = '25.18.108.160';
    $dbuser = 'test';
    $dbpass = 'password';
    $dbname = 'test';

    $mydb = mysqli_connect($dbIP, $dbuser, $dbpass, $dbname);



    if (!$mydb){

        echo "Failed to connect to Test_Database\n";
    }
    else{

        echo "Connected to Test_Database: ";

        return $mydb;
    }
}

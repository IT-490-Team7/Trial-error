<?php
function dbconnect(){
    $dbIP = '25.14.30.215';
    $dbuser = 'test';
    $dbpass = 'it490123';
    $dbname = 'test_database';

    $mydb = mysqli_connect($dbIP, $dbuser, $dbpass, $dbname);



    if (!$mydb){

        echo "Failed to connect to Test_Database\n";
    }
    else{

        //echo "Connected to Test_Database: ";

        return $mydb;
    }
}

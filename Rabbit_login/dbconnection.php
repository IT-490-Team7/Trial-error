<?php
$con = mysqli_connect("25.14.30.215", "test", "it490123", "test_database");

//check if database is not connected error display
if (!$con){
    exit('Failed to connect to Database: ' . mysqli_connect_error());
}
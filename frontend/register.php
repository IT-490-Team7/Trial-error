<?php
session_start();
require_once '../Rabbitmq/rabbitMQLib.inc';
include ('../Rabbitmq/rabbitClient.php');

$regName = $_POST['name'];
$regEmail = $_POST['email'];
$regPassword = $_POST['password'];
$regCPass = $_POST['cpassword'];

if (empty($regName)){
    echo "<h2>Name field is left empty</h2><br>";
    exit(header("Refresh: 2; url=register2.html"));
}elseif (empty($regEmail)){
    echo "<h2>Email field is left empty</h2><br>";
    exit(header("Refresh: 2; url=register2.html"));
}elseif (empty($regPassword)){
    echo "<h2>Password field is left empty</h2><br>";
    exit(header("Refresh: 2; url=register2.html"));
}elseif ($regPassword != $regCPass){
    echo "<h2>Password do not match</h2>";
    exit(header("Refresh: 2; url=register2.html"));
}else{

    $passhash = password_hash($regPassword, PASSWORD_DEFAULT);

    $response = registration($regName, $regEmail, $passhash);
    if ($response == true){

        echo "<h1>Thank You For Registering!</h1>";
        echo "<a href='LoginPage.php'>Login</a>";

    }elseif ($response == false){

        echo "<h1>Sorry your email provided could not be register, try again</h1>";
        echo "<a href='register2.html'>Register</a>";
    }
}


<?php
session_start();
require_once '/home/om/PhpstormProjects/hopeitworks/Rabbitmq/rabbitMQLib.inc';
include ('/home/om/PhpstormProjects/hopeitworks/Rabbitmq/rabbitClient.php');

$email = $_POST['email'];
$password = $_POST['password'];


$loginUser = login($email,$password);

if ($loginUser == true){

    $_SESSION['email'] = $email;
    echo "<h3>Login Successfully, Welcome</h3>".$_SESSION['$email'];
    header("Refresh: 2; url=welcome.php");

}elseif ($loginUser == false){

    echo"<h2>Failed to Login, Click Login to return to Login Page</h2>";
    echo "<a href='LoginPage.html'>Login</a>";

}
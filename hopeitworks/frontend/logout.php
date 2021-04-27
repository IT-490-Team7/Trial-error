<?php
session_start();
require_once '/home/om/PhpstormProjects/hopeitworks/Rabbitmq/rabbitMQLib.inc';
include ('/home/om/PhpstormProjects/hopeitworks/Rabbitmq/rabbitClient.php');
include ('/home/om/PhpstormProjects/hopeitworks/FrontPage/');

if (LogOut($_SESSION['email'])){

    unset($_SESSION['email']);

    echo "<h3>Logging Out from your account Thank You</h3>". $_SESSION['email'];
    header("Refresh: 2; HomePage.html");

}

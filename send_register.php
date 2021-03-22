<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include ('functions.php');

//Check if name is entered
if(empty($_POST['name'])){
    echo "Forgot to enter your Name";
    exit(header("Refresh: 2; url=new.php"));    //redirect to register page
}
//Check if email is entered
if(empty($_POST['email'])){
    echo "Forgot to enter your Email";
    exit(header("Refresh: 2; url=new.php"));    //redirect to register page
}
//check if email exists
elseif (email_exist($_POST['email'])){
    echo "Email already exists";
    exit(header("Refresh: 2; url=new.php"));    //redirect to register page
}
//check if empty password
elseif (empty($_POST['password'])){
    echo "Forgot to enter your Password";
    exit(header("Refresh: 2; url=new.php"));    //redirect to register page
}
elseif ($_POST['password'] != $_POST['cpassword']){
    echo "Password does not match";
    exit(header("Refresh: 2; url=new.php"));    //redirect to register page
}

//check if password length is at least 6 characters
elseif (!check_pass_length($_POST['password'])){
    echo 'Password must have 6 characters or more';
    exit(header("Refresh: 2; url=new.php"));    //redirect to register page
}
else {
    $passhash = password_hash($_POST['password'], PASSWORD_DEFAULT);    //Hashing password

    $content = array(
        "name" => $_POST['name'],
        "email" => $_POST['email'],
        "pass" => $passhash,
        "type" => $_POST['register']
    );
}
$msgJson = json_encode($content);

//connecting to rabbitmq
$connection = new AMQPStreamConnection('25.14.30.215', 5672, 'admin', 'admin');
$channel = $connection->channel();
//declaring queue named hello
$channel->queue_declare('email', false, false, false, false);

$msg = new AMQPMessage($msgJson, array('delivery_mode' => 2 ));
//publishing message from the register form to rabbitmq
$channel->basic_publish($msg, '', 'email');

echo "Sent to RabbitMQ: ";

header("location: login.html?msg=User ".  $_POST['name'] . " is registered");



$channel->close();
$connection->close();

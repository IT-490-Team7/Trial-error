<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include ('functions.php');
include "account.php";

$db = mysqli_connect($dbIP, $dbLogin, $dbPass, $dbName);

if (empty($_POST['name'])){
    echo "Forgot to enter your Name<br>";
    exit(header("Refresh: 2; url=register.html"));

}elseif (empty($_POST['email'])){
    echo "Forgot to enter your Email<br>";
    exit(header("Refresh: 2; url=register.html"));


}elseif (email_exist($_POST['email'])){
    echo "Email already exist try a different email<br>";
    exit(header("Refresh: 2; url=register.html"));
}elseif (empty($_POST['password'])){
    echo "Forgot to enter your Password<br>";
    exit(header("Refresh: 2; url=register.html"));

}elseif (!check_pass_length($_POST['password'])){
    echo "Password must have 6 characters or more<br>";
    exit(header("Refresh: 2; url=register.html"));

}else{

    $passhash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $content = array(
        "name" => $_POST['name'],
        "email" => $_POST['email'],
        "pass" => $passhash,
        "type" => $_POST['submit']
    );

    $msgJson = json_encode($content);


    $connection = new AMQPStreamConnection('25.14.30.215', 5672, 'admin', 'admin');
    $channel = $connection->channel();
    $channel->queue_declare('hello', false, false, false, false);

    $msg = new AMQPMessage($msgJson, array('delivery_mode' =>2 ));

    $channel->basic_publish($msg, '', 'hello');
    
    echo "Sent to RabbitMQ: ";
    
    header("Refresh: 4; url=login.php");

}

$channel->close();
$connection->close();

?>


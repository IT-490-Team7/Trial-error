<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include ('functions.php');

if (empty($_POST['name'])){
    echo "Forgot to enter your Name";
    exit(header("Refresh: 2; url=register.html"));

}
if(empty($_POST['email'])){
    echo "Forgot to enter your Email";
    exit(header("Refresh: 2; url=register.html"));
}
if(empty($_POST['password'])){
    echo "Forgot to enter your Password";
    exit(header("Refresh: 2; url=register.html"));
}

if (!check_pass_length($_POST['password'])){
    echo 'Password must have 6 characters or more';
    exit(header("Refresh: 2; url=register.html"));
}

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

header("location: login.php");

echo "<br>";
echo "Sent to RabbitMQ: ";
echo $msg->body;
echo "<br>";

$channel->close();
$connection->close();


//echo "DB Login Confirmation: ";
//echo $_SESSION['name'].", Your registration is complete!";
?>

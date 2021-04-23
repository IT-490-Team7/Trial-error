<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include ("../BackEnd/function.php");


$regName = $_POST['name'];
$regEmail = $_POST['email'];
$regPassword = $_POST['password'];
//$regCPass = $_POST['cpassword'];

if (checkmail($regEmail)){

    echo "<h1>Sorry your email provided could not be register, try again</h1>";
    echo "\n";
    echo "<a href='register2.html'>Register</a>";

}else{
    $passhash = password_hash($regPassword, PASSWORD_DEFAULT);

    $content = array(
        "name" => $regName,
        "email" => $regEmail,
        "pass" => $passhash,
        "type" => $_POST['submit']
    );
    $msgJson = json_encode($content);

    $connection = AMQPStreamConnection::create_connection([['host'=>'25.14.30.215', 'port'=>'5672', 'user'=>'admin', 'password'=>'admin','vhost'=>'/'],
        ['host'=>'25.14.30.215', 'port'=>'5676', 'user'=>'admin', 'password'=>'admin','vhost'=>'/'],
        ['host'=>'25.14.30.215', 'port'=>'5677', 'user'=>'admin', 'password'=>'admin','vhost'=>'/'],
        ['host'=>'25.14.30.215', 'port'=>'5678', 'user'=>'admin', 'password'=>'admin','vhost'=>'/']], ['keepalive' => false,'heartbeat' => 5]);

    $channel = $connection->channel();
    $channel->queue_declare('hello', false, false, false, false);

    $msg = new AMQPMessage($msgJson, array('delivery_mode' =>2 ));

    $channel->basic_publish($msg, '', 'hello');

    //echo "<br>";
    //echo "<h1>Thank You For Registering!</h1>";
    //echo $msg->body;
    //echo "<br>";
    //echo "<a href='LoginPage.html'>Login</a>";

}

echo "<h1>Thank You For Registering!</h1>";
echo "<br>";
echo "<a href='LoginPage.html'>Login</a>";

$channel->close();
$connection->close();

/*
$passhash = password_hash($regPassword, PASSWORD_DEFAULT);

$content = array(
    "name" => $regName,
    "email" => $regEmail,
    "pass" => $passhash,
    "type" => $_POST['submit']
);
$msgJson = json_encode($content);

$connection = AMQPStreamConnection::create_connection([['host'=>'25.14.30.215', 'port'=>'5672', 'user'=>'admin', 'password'=>'admin','vhost'=>'/'],
    ['host'=>'127.0.0.6', 'port'=>'5676', 'user'=>'admin', 'password'=>'admin','vhost'=>'/'],
    ['host'=>'127.0.0.7', 'port'=>'5677', 'user'=>'admin', 'password'=>'admin','vhost'=>'/'],
    ['host'=>'127.0.0.8', 'port'=>'5678', 'user'=>'admin', 'password'=>'admin','vhost'=>'/']], ['keepalive' => false,'heartbeat' => 5]);
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage($msgJson, array('delivery_mode' =>2 ));

$channel->basic_publish($msg, '', 'hello');

    //echo "<br>";
echo "<h1>Thank You For Registering!</h1>";
    //echo $msg->body;
    //echo "<br>";
echo "<a href='LoginPage.html'>Login</a>";




$channel->close();
$connection->close();

*/


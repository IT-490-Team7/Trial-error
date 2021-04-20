<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include ("function.php");

$regEmail = $_POST['email'];
$regPassword = $_POST['password'];

$login = dologin($regEmail, $regPassword);


if ($login == true)
{

$connection = AMQPStreamConnection::create_connection([['host' => '25.14.30.215', 'port' => '5672', 'user' => 'admin', 'password' => 'admin', 'vhost' => '/'],
    ['host' => '127.0.0.6', 'port' => '5676', 'user' => 'admin', 'password' => 'admin', 'vhost' => '/'],
    ['host' => '127.0.0.7', 'port' => '5677', 'user' => 'admin', 'password' => 'admin', 'vhost' => '/'],
    ['host' => '127.0.0.8', 'port' => '5678', 'user' => 'admin', 'password' => 'admin', 'vhost' => '/']], ['keepalive' => false, 'heartbeat' => 5]);

$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);

$content = array(
    "email" => $_POST['email'],
    "pass" => $_POST['password'],
    "type" => $_POST['submit']);
$msgJson = json_encode($content);

$msg = new AMQPMessage($msgJson, array('delivery_mode' => 2));

$channel->basic_publish($msg, '', 'hello');


//echo "Logged In\n";
//echo "<a href='LoginPage.html'>Login</a>";

}else{
    echo"<h2>Failed to Login, Click Login to return to Login Page</h2>";
    echo "<a href='LoginPage.html'>Login</a>";
}
$channel->close();
$connection->close();

/*
$content = array(
    "email" => $regEmail,
    "pass" => $regPassword,
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
*/
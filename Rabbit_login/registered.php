<?php
session_start();

include 'signUp.php';
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('25.14.30.215', 5672, 'admin', 'admin');
$channel = $connection->channel();
$channel->queue_declare('email', false, false, false, false);

$msg = new AMQPMessage($_POST['email']);
$channel->basic_publish($msg, '', 'email');
echo "<br>";
echo "Sent to RabbitMQ: ";
echo $msg->body;
echo "<br>";
$channel->close();
$connection->close();
?>
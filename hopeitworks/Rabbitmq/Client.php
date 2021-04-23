<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = AMQPStreamConnection::create_connection([['host' => '25.14.30.215', 'port' => '5672', 'user' => 'admin', 'password' => 'admin', 'vhost' => '/'],
                                        ['host' => '127.0.0.2', 'port' => '5675', 'user' => 'admin', 'password' => 'admin', 'vhost' => '/']]);
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');
echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();

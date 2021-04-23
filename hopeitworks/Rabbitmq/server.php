<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Connection\AMQPConnection;

$connection = AMQPStreamConnection::create_connection([['host' => '25.14.30.215', 'port' => '5672', 'user' => 'admin', 'password' => 'admin', 'vhost' => '/'],
                                        ['host' => '127.0.0.2', 'port' => '5675', 'user' => 'admin', 'password' => 'admin', 'vhost' => '/']
]);

    $channel = $connection->channel();

    $channel->queue_declare('hello', false, false, false, false);

    echo " [*] Waiting for messages. To exit press CTRL+C\n";
    $callback = function ($msg) {
        echo ' [x] Received ', $msg->body, "\n";
    };

    $channel->basic_consume('hello', '', false, true, false, false, $callback);

    while ($channel->is_open()) {
        $channel->wait();
    }
    $channel->close();
    $connection->close();


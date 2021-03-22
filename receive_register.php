<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
error_reporting(E_ALL ^ E_NOTICE);
$connection = new AMQPStreamConnection('25.14.30.215', 5672, 'admin', 'admin');

$channel = $connection->channel();
$channel->queue_declare('email', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$process = function ($msg) {

    $con = mysqli_connect('25.18.108.160', 'test', 'password', 'test');
    if (!$con) {
        die("Connection failed" . mysqli_connect_error());
    }

    echo ' [x] Message Received ', $msg->body, "\n";


    $aMsg = $msg->body;
    $newMsg = "[{$aMsg}]";
    $data = json_decode($newMsg, true);

    $name = $data[0]["name"];
    $email = $data[0]["email"];
    $pass = $data[0]["pass"];
    $type = $data[0]["type"];

    switch ($type){
        case "Register";
            echo 'name: ',$name, "\n";
            echo 'email: ',$email, "\n";
            echo 'pass: ',$pass, "\n";
            echo 'type: ',$type, "\n";

            $sql = "INSERT INTO users (name, email, password) VALUES ('$name','$email','$pass')";
            ($t = mysqli_query( $con, $sql )) or die(mysqli_error($con));
            echo 'name: ',$name, " was registered successfully ", "\n";
            break;

        case "login";
            echo 'email: ',$email, "\n";
            echo "Login Successfully", "\n";
            break;
    }
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_consume('email', '', false, false, false, false, $process);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>
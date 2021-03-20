<?php
/*
 Run "getuser.php" in terminal for receiving*/

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
error_reporting (E_ALL ^ E_NOTICE);

$connection = new AMQPStreamConnection('25.14.30.215', 5672, 'admin', 'admin');

$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$process = function($msg){

    $connect_db = mysqli_connect('25.18.108.160', 'test', 'password', 'test');
    mysqli_select_db($connect_db, 'test') or die("Could not open the db 'users'");

    echo ' [x] Message Received ', $msg->body, "\n";


    $aMsg = $msg->body;

    $newMsg = "[{$aMsg}]";

    //decode json
    $data = json_decode($newMsg, true);

    $name = $data[0]["name"];
    $email = $data[0]["email"];
    $pass = $data[0]["pass"];
    $type = $data[0]["type"];

    //echo 'name: ',$name, "\n";
    //echo 'email: ',$email, "\n";
    //echo 'pass: ',$pass, "\n";
    //echo 'type: ',$type, "\n";

    switch ($type){
        case "Register";
        echo 'name: ',$name, "\n";
        echo 'email: ',$email, "\n";
        echo 'pass: ',$pass, "\n";
        echo 'type: ',$type, "\n";

        $sql = "INSERT INTO users (name, email, password) VALUES ('$name','$email','$pass')";
        ($t = mysqli_query( $connect_db, $sql )) or die(mysqli_error($connect_db));
        echo 'name: ',$name, " was registered successfully ", "\n";
        break;

        case "Login";
        echo 'email: ',$email, "\n";
        echo "Login Successfully", "\n";
        break;
    }


    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_consume('hello', '', false, false, false, false, $process);

while($channel->callbacks) {
    $channel->wait();
}

$channel->close();
$connection->close();
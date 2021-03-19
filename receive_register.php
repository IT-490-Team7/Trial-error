<?php

/*
 Run "getuser.php" in terminal for receiving*/

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

//include ('registered.php');


$connection = new AMQPStreamConnection('25.121.51.246', 5672, 'admin', 'admin');

$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$process = function ($msg) {

    $con = mysqli_connect('localhost', 'test', 'test', 'test');
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

    if ($type = "Register") {
        //Insert account into users table
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name','$email','$pass')";
        ($t = mysqli_query($con, $sql)) or die(mysqli_error($con));
        echo " * User was registered", "\n";
    }
    elseif ($type = "login") {
        //Compare login input & compare with database | authenticate
        $s = "SELECT * FROM users WHERE email='$email' AND password='$pass' " ;
        ( $t = mysqli_query($con, $s) ) or die ( mysqli_error( $con ) );

        $num = mysqli_num_rows($t) ;

        if ( $num > 0 ) {
            echo " * User was Logged in", "\n";
            return true ;
        }
        else {
            return false ;
        }
    }
    else {
        exit();
    }

    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_consume('hello', '', false, false, false, false, $process);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>
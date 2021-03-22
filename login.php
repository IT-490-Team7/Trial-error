<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include ("functions.php");
include ("../db/config.php");

$con = mysqli_connect('25.18.108.160', 'test', 'password', 'test');
if (!$con) {
    die("Connection failed" . mysqli_connect_error());
}

$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email)){
    echo "Email field cannot be empty";
}elseif (empty($password)){
    echo "Password field cannot be empty";
}
else{

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_assoc($result)) {

            if (password_verify($password, $row['password'])) {

                $content = array(
                    "email" => $email,
                    "type" => $_POST['login']
                );

                $msgJson = json_encode($content);

                $connection = new AMQPStreamConnection('25.14.30.215', 5672, 'admin', 'admin');
                $channel = $connection->channel();
                $channel->queue_declare('email', false, false, false, false);

                $msg = new AMQPMessage($msgJson, array('delivery_mode' =>2 ));

                $channel->basic_publish($msg, '', 'email');

                echo "Successfully Login Redirecting to Welcome Page";
                header("Refresh: 1; url=welcome.php");
            }

            else {

                echo "Email or Password is invalid";
                header("Refresh: 1; url=login.html");
            }
        }

    }else{

        echo "Email not found in database";
        header("Refresh: 2; url=new.php");
    }


}
$channel->close();
$connection->close();
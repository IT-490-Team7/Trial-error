<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
error_reporting (E_ALL ^ E_NOTICE);
include("dbconnect.php");

function doReg($name, $email, $password){

    $connect = dbconnect();

    if ($connect->errno != 0){

        echo "Failed to connect to database";
        exit(0);

    }
    else{
        //check if user email exist in database
        $email_query = mysqli_query($connect,"SELECT * FROM users WHERE email='$email'");
        $num = mysqli_num_rows($email_query);

        if ($num == 1){
            //Email already exists
            echo ": An Email exist in the database and could not create an account\n";
            return false;
        }else{

            //Email doesn't already exist in a database, proceed...
            $reg_query = "INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')";
            ($result = mysqli_query( $connect, $reg_query )) or die(mysqli_error($connect));

            echo " New account was created...\n";
            return true;
        }

    }
}//end function
function dologin($email, $password){

    $connect = dbconnect();

    if ($connect->errno != 0){
        echo "Failed to connect to database";
        exit(0);
    }else{
        //check login
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) == 1){

            while ($row = mysqli_fetch_assoc($result)){

                if (password_verify($password, $row['password'])){

                    echo "Checking Database...\n";
                    echo "Credentials found and Successfully Login!\n\n";

                    return true;
                }else{

                    echo "Login failed, credentials do not match\n";
                    return  false;
                }

            }
        }
    }
}//end function



$connection = AMQPStreamConnection::create_connection([['host'=>'25.14.30.215', 'port'=>'5672', 'user'=>'admin', 'password'=>'admin','vhost'=>'/'],
    ['host'=>'127.0.0.6', 'port'=>'5676', 'user'=>'admin', 'password'=>'admin','vhost'=>'/'],
    ['host'=>'127.0.0.7', 'port'=>'5677', 'user'=>'admin', 'password'=>'admin','vhost'=>'/'],
    ['host'=>'127.0.0.8', 'port'=>'5678', 'user'=>'admin', 'password'=>'admin','vhost'=>'/']], ['keepalive' => false,'heartbeat' => 5]);

$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
echo "[*]Connected to RabbitMQ\n";
$process = function($msg){

    echo "\n",'[x] Message Received ', $msg->body, "\n";
    $aMsg = $msg->body;
    $newMsg = "[{$aMsg}]";

    //decode json
    $data = json_decode($newMsg, true);

    $name = $data[0]["name"];
    $email = $data[0]["email"];
    $pass = $data[0]["pass"];
    $type = $data[0]["type"];

    switch ($type)
    {
        case "Register":
            return doReg($name, $email, $pass);
            break;
        case "Login":
            return dologin($name,$pass) . "Logged In";
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
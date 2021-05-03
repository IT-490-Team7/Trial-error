<?php
require_once('hopeitworks/Rabbitmq/path.inc');
require_once('hopeitworks/Rabbitmq/get_host_info.inc');
require_once('hopeitworks/Rabbitmq/rabbitMQLib.inc');
require_once('dbconnect.php');
include ('functions.php');

function newUser($name, $email, $password){

    $connect = dbconnect();

    $query_reg = "INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')";

    ($result = mysqli_query( $connect, $query_reg )) or die(mysqli_error($connect));

    if(!$result){

        echo "failed to execute the register query:".PHP_EOL;
        exit(0);

    }
    else{

        //echo "new user registered";
        return true;

    }

}

function requestProcessor($request)
{
    echo "received request".PHP_EOL;
    var_dump($request);
    if(!isset($request['type']))
    {
        return "ERROR: unsupported message type";
    }
    switch ($request['type'])
    {
        case "Register":
          return newUser($request['name'],$request['email'],$request['password']);
    }

    //echo $msg;
    //return $msg;
    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
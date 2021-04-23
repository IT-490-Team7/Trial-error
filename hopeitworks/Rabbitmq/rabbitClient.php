<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function registration($name, $email, $password){
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
    if (isset($argv[1]))
    {
        $msg = $argv[1];
    }
    else
    {
        $msg = "register";
    }

    $request = array();
    $request['type'] = "Register";
    $request['name'] = $name;
    $request['email'] = $email;
    $request['password'] = $password;
    $request['message'] = $msg;
    $response = $client->send_request($request);
//$response = $client->publish($request);

    echo " client received response: ".PHP_EOL;
    return $response;
    echo "\n\n";

    //echo $argv[0]." END".PHP_EOL;

}//end function

function login($email, $password){
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

    if (isset($argv[1]))
    {
        $msg = $argv[1];
    }
    else
    {
        $msg = " Login";
    }
    $request = array();
    $request['type'] = "Login";
    $request['email'] = $email;
    $request['password'] = $password;
    $request['message'] = $email.$msg;
    $response = $client->send_request($request);

    echo "Client received response: ".PHP_EOL."\n";
    return $response;
    echo "\n\n";
}//end function

function LogOut($email){
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
    if (isset($argv[1]))
    {
        $msg = $argv[1];
    }
    else
    {
        $msg = " Logging Out";
    }
    $request = array();
    $request['type'] = "LogOut";
    $request['email'] = $email;
    $request['message'] = $email .$msg;
    $response = $client->send_request($request);
    echo "Client received response: ".PHP_EOL."\n";
    return $response;
    echo "\n\n";
}//end function
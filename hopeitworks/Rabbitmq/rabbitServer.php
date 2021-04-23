<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include ('/home/om/PhpstormProjects/hopeitworks/backend/dbconnect.php');

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

function dologout($email){

    echo  $email. " has LogOut\n";
    return true;
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
            return doReg($request['name'], $request['email'], $request['password']);
            break;
        case "Login":
            return dologin($request['email'], $request['password']);
            break;
        case "LogOut":
            return dologout($request['email']);
            break;
    }


    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "RabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "RabbitMQServer END".PHP_EOL;
exit();

?>
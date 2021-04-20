<?php
include ("dbconnect.php");

function checkmail($email){
    $db = dbconnect();
    $email_query = mysqli_query($db,"SELECT * FROM users WHERE email='$email'");
    $num = mysqli_num_rows($email_query);

    if ($num == 1){
        //Email already exists
        echo "An Email exist in the database and could not create an account\n";
        echo "<a href='register2.html'>Register</a>";
        return false;

    }


}
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

                    //echo "Checking Database...\n";
                    echo "Successfully Login!\n\n";
                    header("Refresh: 2; url=welcome.php");

                    return true;
                }else{

                    echo "Login failed, credentials do not match\n";
                    return  false;
                }

            }
        }
    }
}//end function


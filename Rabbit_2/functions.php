<?php
///function for safe insertion into the database without errors
function escape($string){
    global $db;

    return mysqli_real_escape_string($string);

}


///this function checks if email exists in the database return true or false
function email_exist($email){
    global $db;

    $sql_email = "SELECT * FROM users WHERE email = '$email'";

    $sql_query = mysqli_query($db, $sql_email);

    $sql_rows =  mysqli_num_rows($sql_query);

    if ($sql_rows == 1){

        return true;

    }else{

        return false;
    }
}

//This function checks for the length of the password it must be 6 or more return true or false
function check_pass_length($password){
    global $db;

    if (strlen($password) >= 6){

        return true;

    }else{

        return  false;
    }

}

function registerUser($name, $email, $password){
    global $db;

    $name     = escape($name);
    $email    = escape($email);
    $password = escape($password);


    if (email_exist($email)){

        return false;

    }elseif (!check_pass_length($password)){

        return false;

    }else{

        $password = password_hash($password, PASSWORD_DEFAULT);

        $insert_user = "INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')";

        mysqli_query($db, $insert_user);

        return true;
        echo "User registered";
    }

}

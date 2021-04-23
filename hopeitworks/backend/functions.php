<?php
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

function check_pass_length($password){

    if (strlen($password) >= 6){

        return true;

    }else{

        return  false;
    }

}
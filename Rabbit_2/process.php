<?php
$user_email = $_POST['email'];
$user_pass = $_POST['password'];


$connect_db = mysqli_connect('25.14.30.215', 'test', 'it490123', 'test_database');

if(!$connect_db){
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$user_email = stripcslashes($user_email);
$user_pass = stripcslashes($user_pass);

$user_email = mysqli_real_escape_string($connect_db,$user_email);
$user_pass = mysqli_real_escape_string($connect_db,$user_pass);


//$sql = mysqli_query($connect_db,"SELECT * FROM users WHERE email ='$user_email' and password = '$user_pass'");

//query the table user from test_database
//$row = mysqli_fetch_array($sql);

if(!empty($user_email) && !empty($user_pass)) {

    $query = "SELECT * FROM users WHERE email = '$user_email'";
    $result = mysqli_query($connect_db, $query);

    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_assoc($result)) {

            if (password_verify($user_pass, $row['password'])) {
                //$_SESSION['id'] = $row['id'];
                //$_SESSION['fullname'] = $row['fullname'];

                echo "Successfully Login Redirecting to Welcome Page";
                header('Refresh: 3; URL= welcome.php');

            } else {

                echo "Email or Password is invalid";
            }
        }
    }else{
        echo "No user found on this email: " .$user_email;

    }
} else{
    echo "Email and Password is required";
}


/*
if ($row['email'] == $user_email && $row['password'] == md5($user_pass)){
    header('location:welcome.php');
}else{
    header("location:login.php?error=failed login" );
}
*/
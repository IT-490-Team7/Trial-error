<!DOCTYPE html>
<html lang="en">
<body>
<div class="wrapper">
    <form method="POST">
        <div>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Email" />
        </div>
        <div>
            <label for="pass">Password</label><br>
            <input type="password" id="pass" name="password" placeholder="Password"/>
        </div>
        <div>
            <label for="cpass">Confirm Password</label><br>
            <input type="password" id="cpasss" name="cpassword" placeholder="Confirm Password"/>
        </div>
        <div>
            <input class="submit" type="submit" name="register" value="Register"/>
            <button><a href="login.php">Login</a></button>
        </div>

    </form>
</div>
</body>
</html>


<?php

if($_POST["register"]){
    require '../db/config.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    if(empty($_POST["email"])){
        echo"Please enter email";
    }

    if(empty($_POST["cpassword"])){
        echo"Please Confirm password";
    }
    else{
        $cpassword = $_POST["cpassword"];
        if($password !== $cpassword){
           echo"Password does not match";
        }
        elseif(!empty($email) && !empty($password) && !empty($cpassword)) {

            $sql = "INSERT INTO Users (email,password) VALUES ('$email','$hash')";
            $result = $con->query($sql);

            echo "You are Registered successfully " . $email;
        }
        else{
            echo "<br>";
            echo "Fill the form properly";
        }
    }

}

?>

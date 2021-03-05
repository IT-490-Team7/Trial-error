<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
<form method="post">
    <div>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" placeholder="Email"/>
    </div>
    <div>
        <label for="pass">Password</label><br>
        <input type="password" id="pass" name="password" placeholder="Password"/>
    </div>
    <div>
        <input class="submit" type="submit" name="login" value="Login"/>
    </div>
</form>
</body>

</html>
<?php
$error = '';
//if (isset($_POST['email']) && isset($_POST['password'])) {
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
    require_once '../db/config.php';

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    // Data sanitization to prevent SQL injection
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Error message if the input field is left blank
    if (empty($email)) {
        $error .= '<p> "Please enter email!"</p>';
        echo"Email required  ";
    }
    if (empty($password)) {
        $error .= '<p> "Please enter password!"</p>';
        echo"password required";
    }
    if(empty($error)){
        if($query = $con->prepare("Select * From Users where email = ?")){
            $query->bind_param('s',$email);
            $query->execute();
            $row = $query->fetch();
            if($row){
                if (password_verify($password, $row['password'])){
                    echo"you are logged in";
                    header("location:welcome.php");
                    exit;
                }
                else{
                    echo"wrong password";
                    $error .= '<p>Wrong password</p>';
                }
            }
            else{
                echo"no email found";
                $error .= '<p>No email found</p>';
            }
        }
        $query->close();
    }
    mysqli_close($con);

    // Checking for the errors
    /*if (count($errors) == 0) {
        if ($con){
            print "Connected<br><br>";
        }
        // Password matching
        $password = md5($password);

        $query = "SELECT * FROM users WHERE email= '$email' AND password='$password'";
        $results = mysqli_query($con, $query);
        echo"hello";
        // $results = 1 means that one user with the
        // entered username exists
        if (mysqli_num_rows($results) > 0) {

            // Storing username in session variable
            echo"you are logged in";

            // Page on which the user is sent
            // to after logging in
            header('location: index.php');
        }
        else {

            // If the username and password doesn't match
            array_push($errors, "Username or password incorrect");
            echo"not loggedin";
        }
    }*/
}
/*
require_once '../db/config.php';
$con = mysqli_connect('localhost','test','test','test');
$email = $_POST['email'];
$password = $_POST['password'];

$sql = mysqli_query($con, "Select * from users where email='$email' and password='$password'");
$row = mysqli_fetch_array($sql);

if($row['email'] == $email && $row['password'] == $password){
    header("location:welcome.php");
}
else{
    header("location:login.php?error=failed");
}*/

?>

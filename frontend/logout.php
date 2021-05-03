<?php
session_start();
session_unset();
session_destroy();
echo "You have been logged out";
header("Refresh: 2; home.php");
/*
if (LogOut($_SESSION['email'])){

    unset($_SESSION['email']);

    echo "<h3>Logging Out from your account Thank You</h3>". $_SESSION['email'];

}
*/
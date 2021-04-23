<!DOCTYPE html>
<html>
<style>
    body {
        background-color: white;

    }
</style>
<body>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <div class="w3-container w3-cyan">
        <h1>Welcome to the Homepage</h1>
    </div>

<?php
session_start();
echo "<b>Hello " .$_SESSION['email']."</b>";
?>
    <a href="logout.php">LogOut</a>
</body>
</html>


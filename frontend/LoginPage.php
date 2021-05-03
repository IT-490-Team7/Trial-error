<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="Loginstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="topnav">
    <a href="about.html">About</a>
    <a href="register2.html">Register</a>
    <a class="active" href="home.php">Home</a>
    <div class="login">
        <h1>Login</h1>
        <form action="login.php" method="post">

            <label for="email">
                <i class="fas fa-envelope"></i>
            </label>
            <input type="email" name="email" placeholder="Email" id="email" required>

            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Password" id="password" required>

            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</div>
</body>
</html>
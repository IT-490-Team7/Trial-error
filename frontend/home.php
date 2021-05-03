<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewpoint" content="with=device-width, initial-scale=1.0">
    <title>Book Heaven</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
</head>
<body>
<section class="header">
    <nav>
        <a href="home.php"><img src="bookempire.png" alt=""><a/>
            <div class="nav-links" id="navlinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <?php
                    session_start();
                    if(!isset($_SESSION['email'])){?>
                        <li><a href="LoginPage.php">Login</a></li>
                    <?php } ?>
                    <?php
                    if(isset($_SESSION['email'])){?>
                        <li><a href="book.php">Search</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php } ?>
                    <li><a href="about.html">About</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
    </nav>
    <div class="text-box">
        <h1>Welcome to Book Heaven</h1>
        <p>Need help to find a certain Book look no further<br>Our service will help you find that Book!!</p>
        <?php
        if(!isset($_SESSION['email'])){ ?>
        <a href="../frontend/register2.html" class="hero-btn">Join Now</a>
        <?php }
        else{ ?>
        <a href="../frontend/book.php" class="hero-btn">Search</a>
        <?php }
        ?>
    </div>
</section>


<!------JavaScript for smartphone devices------->
<script>
    var navLinks = document.getElementById("navlinks")

    function showMenu(){
        navLinks.style.right = "0"
    }
    function hideMenu(){
        navLinks.style.right = "-200px"
    }
</script>

</body>
</html>
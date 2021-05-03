<?php include_once("../backend/dbconnect.php");
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:LoginPage.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset=utf-8>
    <title>Book Finder</title>
    <link rel=stylesheet href=https://cdn.jsdelivr.net/npm/dna.js@1.7/dist/dna.css>
    <style>
        body {
            font-family: system-ui;
            margin: 10px;
            min-height: 100vh;
            width: 100%;
            background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)), url("book-empire.jpg");
            background-size: contain;
            position: relative;
            background-color: #435165;
        }

        .topnav {
            overflow: hidden;
            padding: 14px 16px;
        }

        .topnav a {
            float: right;
            display: flex;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        input {
            font-size: 1.2rem;
            background-color: lightgrey;
        }

        .book {
            display: block;
            align-items: center;
            max-width: 400px;
            color: navajowhite;
            background-color: transparent;
            padding: 0 40%;
            margin-top: 5%;
        }

        .book img {
            width: 250px;
            margin-right: 10px;
        }

        .book h2 {
            float: end;
            color: indianred;
        }
    </style>
</head>
<body>
    <div class="topnav">
        <a href="#">Contact</a>
        <a href="about.html">About</a>
        <a class="active" href="home.php">Home</a>
        <br><br><br>
        <main>
            <h1 style="text-align: center; color: cornflowerblue">Book Heaven</h1>
            <label style="display: block; text-align: center">
                Search:
                <input placeholder="Enter Book name" autofocus>
                <button data-click=findBooks>Search</button>
            </label>
            <section class=books>
                <div id=book class=dna-template style="float: left;">
                    <img src=~~volumeInfo.imageLinks.thumbnail~~ alt=cover>
                    <div style="float: left; display: block">
                        <h2>~~volumeInfo.title~~</h2>
                        <p>Publisher:</p>
                        <p>~~volumeInfo.publisher~~</p>
                        <i>Price: $</i>
                        <i>~~saleInfo.listPrice.amount~~</i>
                    </div>
                </div>
            </section>
        </main>

        <script src=https://cdn.jsdelivr.net/npm/jquery@3.5/dist/jquery.min.js></script>
        <script src=https://cdn.jsdelivr.net/npm/dna.js@1.7/dist/dna.min.js></script>
        <script src=https://cdn.jsdelivr.net/npm/fetch-json@2.4/dist/fetch-json.min.js></script>
        <script>
            function findBooks() {
                var terms = $('input').val();
                var url = 'https://www.googleapis.com/books/v1/volumes?q=' + terms;

                function handleResults(data) {
                    dna.clone('book', data.items, {empty: true, fade: true});
                }

                $.getJSON(url, handleResults);
            }
        </script>
    </div>
</body>
</html>
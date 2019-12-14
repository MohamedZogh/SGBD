<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="Style/style.css">
</head>
<body>
<img id="goutte-login" src="../images/goutte.png">
<img id="plaine-login" src="../images/plaine.png">

<div class="login-box">
    <img src="../images/avatar.png" class="avatar">
    <h1>Login Here</h1>
    <form>
        <p>Username</p>
        <input type="text" id="pseudo" name="pseudo" placeholder="Enter Username">
        <p>Password</p>
        <input type="password" id="password" name="password" placeholder="Enter Password">
        <input type="button" name="submit" value="Login" onclick="login()">
        <a href="index.php?guest=a">Visiteur</a>
    </form>
</div>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="js/users.js" ></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

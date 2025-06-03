<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>...:::Logowanie:::...</title>
    </head>
    <body>
    <form method="POST" action="projekt_apteczka_login.php">
    <input type="email" name="email" placeholder="E-mail"><br> 
    <input type="password" name="password" placeholder="Hasło"><br> 
    <input type="submit" name="submit" value="Wyślij "><br> 
</form>
<a href="./projekt_apteczka_rejestracja.php">...:::Rejestracja:::...</a><br>
</body> 
</html>
<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>...:::Wyloguj:::...</title>
    </head>
    <body>
<?php
session_unset();
session_destroy();
if (isset($_SESSION["current_user"]))
{
    echo "Uzytkownik jest zalogowany: ".$_SESSION["current_user"]; 
} 
else
{
    echo "Uzytkownik nie jest zalogowany";
}
?>

<a href="./projekt_apteczka_logowanie.php">...:::Zaloguj:::...</a><br>
    </body>
</html>
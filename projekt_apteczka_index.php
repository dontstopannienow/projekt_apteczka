
<?php
//Ten plik: Sprawdzi, czy użytkownik jest zalogowany.Powita użytkownika. Pokaże proste menu (linki do kolejnych podstron).

session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: projekt_apteczka_logowanie.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panel użytkownika</title>
</head>
<body>
    <h2>Witaj w Apteczce Domowej 2025!</h2>
    <p>Zalogowano jako użytkownik o ID: <strong><?php echo $_SESSION["current_user"]; ?></strong></p>

    <h3>Co chcesz zrobić?</h3>
    <ul>
        <li><a href="projekt_apteczka_dodaj_lek.php">Dodaj lek</a></li>
        <li><a href="projekt_apteczka_lista_lekow.php">Zobacz zawartość apteczki</a></li>
        <li><a href="projekt_apteczka_utylizacja.php">Leki do utylizacji</a></li>
        <li><a href="projekt_apteczka_historia.php">Historia przyjmowania leków</a></li>
        <li><a href="projekt_apteczka_wyloguj.php">Wyloguj się</a></li>
    </ul>
</body>
</html>
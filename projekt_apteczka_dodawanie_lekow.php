<?php
//Sprawdzenie logowania. Formularz do dodania leku (nazwa, ilość, cena, data ważności). Wstawianie leku do bazy.
session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: projekt_apteczka_logowanie.php");
    exit();
}

// Połączenie z bazą danych
$servername = "mysql.agh.edu.pl";
$dbusername = ""; // twój login
$dbpassword = ""; // twoje hasło
$dbname = "";     // twoja baza

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}

// Obsługa formularza
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa = mysqli_real_escape_string($conn, $_POST["nazwa"]);
    $ilosc = intval($_POST["ilosc"]);
    $cena = floatval($_POST["cena"]);
    $waznosc = $_POST["waznosc"];
    $user_id = $_SESSION["current_user"];

    $sql = "INSERT INTO leki (user_id, nazwa, ilosc, cena, waznosc) 
            VALUES ('$user_id', '$nazwa', '$ilosc', '$cena', '$waznosc')";

    if (mysqli_query($conn, $sql)) {
        echo "<p>Lek dodany pomyślnie!</p>";
    } else {
        echo "<p>Błąd: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dodaj lek</title>
</head>
<body>
    <h2>Dodaj nowy lek</h2>
    <form method="post">
        <label for="nazwa">Nazwa leku:</label><br>
        <input type="text" name="nazwa" required><br><br>

        <label for="ilosc">Ilość:</label><br>
        <input type="number" name="ilosc" min="1" required><br><br>

        <label for="cena">Cena (PLN):</label><br>
        <input type="number" name="cena" step="0.01" required><br><br>

        <label for="waznosc">Data ważności:</label><br>
        <input type="date" name="waznosc" required><br><br>

        <input type="submit" value="Dodaj lek">
    </form>

    <br>
    <a href="projekt_apteczka_index.php">← Powrót do panelu</a>
</body>
</html>
<?php
//Sprawdza, czy użytkownik jest zalogowany.Pobiera z bazy dane o lekach dodanych przez tego użytkownika. Wyświetla je w tabeli z informacją, czy któryś lek jest przeterminowany.
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

$user_id = $_SESSION["current_user"];

$query = "SELECT * FROM leki WHERE user_id = '$user_id' ORDER BY waznosc ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista leków</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
        .expired {
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <h2>Twoje leki</h2>

    <table>
        <thead>
            <tr>
                <th>Nazwa</th>
                <th>Ilość</th>
                <th>Cena</th>
                <th>Data ważności</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $today = date("Y-m-d");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $expired = ($row["waznosc"] < $today);
                echo "<tr class='" . ($expired ? "expired" : "") . "'>";
                echo "<td>" . htmlspecialchars($row["nazwa"]) . "</td>";
                echo "<td>" . intval($row["ilosc"]) . "</td>";
                echo "<td>" . number_format($row["cena"], 2) . " zł</td>";
                echo "<td>" . $row["waznosc"] . "</td>";
                echo "<td>" . ($expired ? "Przeterminowany!" : "OK") . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Brak leków w apteczce.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <br>
    <a href="projekt_apteczka_dodaj_lek.php">+ Dodaj nowy lek</a><br>
    <a href="projekt_apteczka_index.php">← Powrót do panelu</a>
</body>
</html>
<?php
//Pokazuje tabelę leków z przyciskiem „Utylizuj”. Obsługuje żądanie usunięcia rekordu na podstawie ID.
session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: projekt_apteczka_logowanie.php");
    exit();
}

// Połączenie z bazą danych
$servername = "mysql.agh.edu.pl";
$dbusername = ""; // login
$dbpassword = ""; // hasło
$dbname = "";     // baza

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}

$user_id = $_SESSION["current_user"];

// Obsługa utylizacji (usunięcia) leku
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["lek_id"])) {
    $lek_id = intval($_POST["lek_id"]);
    $delete_query = "DELETE FROM leki WHERE id = '$lek_id' AND user_id = '$user_id'";
    mysqli_query($conn, $delete_query);
}

// Pobieranie leków użytkownika
$query = "SELECT * FROM leki WHERE user_id = '$user_id' ORDER BY waznosc ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Utylizacja leków</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
        form {
            margin: 0;
        }
    </style>
</head>
<body>
    <h2>Utylizacja leków</h2>

    <table>
        <thead>
            <tr>
                <th>Nazwa</th>
                <th>Ilość</th>
                <th>Data ważności</th>
                <th>Utylizacja</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["nazwa"]) . "</td>";
                    echo "<td>" . intval($row["ilosc"]) . "</td>";
                    echo "<td>" . $row["waznosc"] . "</td>";
                    echo "<td>
                        <form method='post'>
                            <input type='hidden' name='lek_id' value='" . $row["id"] . "'>
                            <button type='submit'>Utylizuj</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Brak leków do utylizacji.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="projekt_apteczka_index.php">← Powrót do panelu</a>
</body>
</html>
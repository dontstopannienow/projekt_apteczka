<?php
//pozwala dodać rekord (formularz: kto, jaki lek, kiedy), pokazuje historię w tabeli.
session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: projekt_apteczka_logowanie.php");
    exit();
}

$servername = "mysql.agh.edu.pl";
$dbusername = ""; // twój login
$dbpassword = ""; // twoje hasło
$dbname = "";     // twoja baza

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}

$user_id = $_SESSION["current_user"];

// Dodawanie do historii
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["osoba"], $_POST["lek_id"], $_POST["data_przyjecia"])) {
    $osoba = mysqli_real_escape_string($conn, $_POST["osoba"]);
    $lek_id = intval($_POST["lek_id"]);
    $data_przyjecia = $_POST["data_przyjecia"];

    $insert = "INSERT INTO historia (user_id, osoba, lek_id, data_przyjecia)
               VALUES ('$user_id', '$osoba', '$lek_id', '$data_przyjecia')";
    mysqli_query($conn, $insert);
}

// Pobieranie leków użytkownika do formularza
$leki_query = "SELECT id, nazwa FROM leki WHERE user_id = '$user_id'";
$leki_result = mysqli_query($conn, $leki_query);

// Pobieranie historii
$historia_query = "SELECT h.*, l.nazwa 
                   FROM historia h 
                   JOIN leki l ON h.lek_id = l.id 
                   WHERE h.user_id = '$user_id'
                   ORDER BY data_przyjecia DESC";
$historia_result = mysqli_query($conn, $historia_query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Historia przyjmowania leków</title>
</head>
<body>
    <h2>Dodaj przyjęcie leku</h2>
    <form method="post">
        Imię osoby: <input type="text" name="osoba" required><br><br>
        Nazwa leku:
        <select name="lek_id" required>
            <?php
            while ($lek = mysqli_fetch_assoc($leki_result)) {
                echo "<option value='" . $lek["id"] . "'>" . htmlspecialchars($lek["nazwa"]) . "</option>";
            }
            ?>
        </select><br><br>
        Data przyjęcia: <input type="date" name="data_przyjecia" required><br><br>
        <button type="submit">Zapisz</button>
    </form>

    <h2>Historia</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Osoba</th>
            <th>Lek</th>
            <th>Data przyjęcia</th>
        </tr>
        <?php
        if (mysqli_num_rows($historia_result) > 0) {
            while ($row = mysqli_fetch_assoc($historia_result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["osoba"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nazwa"]) . "</td>";
                echo "<td>" . $row["data_przyjecia"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Brak historii.</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="projekt_apteczka_index.php">← Powrót do panelu</a>
</body>
</html>
<?php

include '../conf/dbconn.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["name"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $email = $_POST["email"];
    $date = $_POST["date"];

    if (empty($email) || empty($username)) {
        echo "Vul zowel e-mail als gebruikersnaam in.";
    } elseif (empty($password) || empty($password2)) {
        echo "Vul zowel wachtwoord als wachtwoord herhalen in.";
    } elseif ($password != $password2) {
        echo "Wachtwoorden komen niet overeen.";
    } elseif (empty($date)) {
        echo "Vul een geboortedatum in.";
    } elseif (strlen($username) > 15) {
        echo "Gebruikersnaam mag maximaal 15 karakters bevatten.";
    } elseif (strlen($password) > 255) {
        echo "Wachtwoord mag maximaal 255 karakters bevatten.";
    } elseif (strlen($email) > 50) {
        echo "E-mail mag maximaal 50 karakters bevatten.";
    } else {
        $birthdate = new DateTime($date);
        $today = new DateTime();
        $age = $today->diff($birthdate)->y;

        if ($age < 18) {
            echo "Registratie mislukt. Je moet minstens 18 jaar oud zijn.";
        } else {
            $checkQuery = "SELECT * FROM login WHERE email=? OR naam=?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param('ss', $email, $username);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $row = $checkResult->fetch_assoc();
                if ($row['email'] == $email) {
                    echo "Registratie mislukt. Deze e-mail is al in gebruik.";
                } elseif ($row['naam'] == $username) {
                    echo "Registratie mislukt. Deze gebruikersnaam is al in gebruik.";
                }
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insertQuery = "INSERT INTO login (naam, wachtwoord, email, geboortedatum) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param('ssss', $username, $hashed_password, $email, $date);

                if ($stmt->execute()) {
                    header("Location: login.php");
                    exit();
                } else {
                    echo "Fout bij registratie: " . $stmt->error;
                }

                $stmt->close();
            }
            $checkStmt->close();
        }
    }

    $conn->close();
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account aanmaken! | Pixel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/register.css">
</head>
<body>
    <main>
        <a href="../index.html">
            <h1 class="logo">Pixel</h1>
        </a>

        <div class="register">
            <h1>Maak een account aan!</h1>
            <form method="post">
                <div class="flds">
                    <div class="fld">
                        <label for="name">Naam</label>
                        <input type="text" name="name" required>
                    </div>

                    <div class="fld">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="fld">
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="fld">
                        <label for="password2">Wachtwoord herhalen</label>
                        <input type="password" name="password2" required>
                    </div>

                    <div class="fld">
                        <label for="date">Geboortedatum</label>
                        <input type="date" name="date" id="date" required>
                    </div>
                </div>

                <button type="submit">Registreren</button>
            </form>
        </div>
    
        <div class="links">
        <p>Terug naar: <a href="login.php">Inloggen</a></p>
        <a href="../index.html">Home</a>
        </div>
    </main>
</body>
</html>

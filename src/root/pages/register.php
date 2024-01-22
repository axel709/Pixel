<?php

include '../conf/dbconn.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO login (naam, wachtwoord, email) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $hashed_password, $email);

    if ($stmt->execute()) {
        echo "Registratie succesvol!";
    } else {
        echo "Fout bij registratie: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Pixel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="register">
    <h2>Registratie</h2>
        <form method="post">
            <label for="name">Naam</label>
            <input type="text" name="name" required>
            <label for="password">Wachtwoord</label>
            <input type="password" name="password" required>
            <label for="email">E-mail</label>
            <input type="email" name="email" required>
            <button type="submit">Registreren</button>
        </form>
    
        <div class="links">
            <p><a href="login.php" class="inlog">Inloggen</a></p>
            <p><a href="index.php" class="website">Terug naar Website</a></p>
        </div>
    </div>
</body>
</html>

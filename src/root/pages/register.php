<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost','root','','foto-upload');

if ($conn->connect_error) {
    die("Fout bij de verbinding met de database: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $sql = "INSERT INTO login (naam, wachtwoord, email) VALUES ('$username', '$password', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Registratie succesvol!";
    } else {
        echo "Fout bij registratie: " . $conn->error;
    }
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
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="fld">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" required>
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

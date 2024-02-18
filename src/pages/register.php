<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'root', '', 'foto-upload');

if ($conn->connect_error) {
    die("Fout bij de verbinding met de database: " . $conn->connect_error);
}

function userExists($conn, $username, $email) {
    $sql = "SELECT * FROM login WHERE naam = '$username' OR email = '$email'";
    $result = $conn->query($sql);
    return $result->num_rows > 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["name"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeat_password"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];

    $today = new DateTime();
    $birthdate = new DateTime($dob);
    $age = $birthdate->diff($today)->y;

    if ($age < 18) {
        echo "Je moet minimaal 18 jaar oud zijn om een account te kunnen maken!";
    } elseif ($password != $repeatPassword) {
        echo "Wachtwoorden komen niet overeen!";
    } elseif (strlen($password) < 8) {
        echo "Wachtwoord moet minimaal 8 tekens lang zijn!";
    } elseif (userExists($conn, $username, $email)) {
        echo "Deze gebruikersnaam of e-mail is al in gebruik!";
    } else {
        $sql = "INSERT INTO login (naam, wachtwoord, email, dob) VALUES ('$username', '$password', '$email', '$dob')";

        if ($conn->query($sql) === TRUE) {
            header('Location: login.php');
        } else {
            echo "Fout bij registratie: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Pixel</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="register">
        <h2>Registratie</h2>
        <form method="post">
            <label for="name">Naam</label>
            <input type="text" name="name" required>
            <label for="email">E-mail</label>
            <input type="email" name="email" required>
            <label for="dob">Geboortedatum</label>
            <input type="date" name="dob" id="dob" required>
            <label for="password">Wachtwoord</label>
            <input type="password" name="password" id="password" required>
            <label for="repeat_password">Herhaal Wachtwoord</label>
            <input type="password" name="repeat_password" id="repeat_password" required>
            <button type="submit">Registreren</button>
        </form>
        
        <div class="links">
            <p><a href="login.php" class="inlog">Inloggen</a></p>
            <p><a href="../index.html" class="website">Terug naar Website</a></p>
        </div>
    </div>

    <script>
        const password = document.getElementById("password");
        const repeatPassword = document.getElementById("repeat_password");

        function validatePassword() {
            if (password.value !== repeatPassword.value) {
                repeatPassword.setCustomValidity("Wachtwoorden komen niet overeen!");
            } else {
                repeatPassword.setCustomValidity("");
            }
        }

        password.addEventListener("input", validatePassword);
        repeatPassword.addEventListener("input", validatePassword);
    </script>
</body>
</html>
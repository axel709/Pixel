<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'root', '', 'foto-upload');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_email_or_username = $_POST['email_or_username'];
    $input_password = $_POST['password'];

    $query = "SELECT * FROM login WHERE (email='$input_email_or_username' OR name='$input_email_or_username') AND wachtwoord='$input_password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];

        if ($row['email'] == "admin@gmail.com") { //login gelukt als admin
            $_SESSION['email'] = $row['email'];
            header("Location: admin.php");
        } else if ($row['email'] == $input_email_or_username || $row['name'] == $input_email_or_username) { //login gelukt als user
            $_SESSION['email'] = $row['email'];
            header("Location: ./pages/feed.php");
        } else {
            echo "Login failed. Please check your username or email and password.";
        }
    } else {
        echo "Login failed. Please check your username or email and password.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload je avonturen! - Pixel Foto Upload</title>
    <link rel="shortcut icon" href="./img/pixel-logo.png">
    <link rel="stylesheet" href="style/css/pages/home.css">
    <link rel="stylesheet" href="style/css/style.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="links">
                <img src="./img/pixel-logo.png" width="50">
            </div>
            <div class="main">
                <h1>Log in om uw foto's te zien!</h1>
                <form method="post">
                    <div class="fld-con">
                        <div class="fld">
                            <label for="email_or_username">Email of Gebruikersnaam</label>
                            <input type="text" name="email_or_username" required>
                        </div>
                        <div class="fld">
                            <label for="password">Wachtwoord</label>
                            <input type="password" name="password" required>
                        </div>
                    </div>
                    <button type="submit">Inloggen</button>
                </form>

                <p>Geen account? <a href="./pages/register.php">Registreer nu!</a></p>
            </div>
        </div>
        <div class="con-img">
            <img src="./img/pixel-logo.png" alt="logo pixel" width="500">
        </div>
    </header>
</body>

</html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'root', '', 'foto-upload');

$err = "";

if ($conn->connect_error) {
    die("Fout bij de verbinding met de database: " . $conn->connect_error);
}

function userExists($conn, $username, $email) {
    $sql = "SELECT * FROM login WHERE name = '$username' OR email = '$email'";
    $result = $conn->query($sql);
    return $result->num_rows > 0;
}

function createUserFolder($username) {
    $folderPath = __DIR__ . '/../foto upload/uploads/' . $username; 
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
        header("Location: ./feed.php");
    }
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
        $err = "Je moet minimaal 18 jaar oud zijn om een account te kunnen maken!";
    } elseif ($password != $repeatPassword) {
        $err = "Wachtwoorden komen niet overeen!";
    } elseif (strlen($password) < 8) {
        $err = "Wachtwoord moet minimaal 8 tekens lang zijn!";
    } elseif (userExists($conn, $username, $email)) {
        $err = "Deze gebruikersnaam of e-mail is al in gebruik!";
    } else {
        $sql = "INSERT INTO login (name, wachtwoord, email, dob) VALUES ('$username', '$password', '$email', '$dob')";

        if ($conn->query($sql) === TRUE) {
            header("Location: ./feed.php");
            createUserFolder($username);
        } else {
            $err = "Fout bij registratie: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maak een account aan - Pixel</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style/css/pages/register.css">
    <link rel="stylesheet" href="../style/css/style.css">
    <link rel="shortcut icon" href="../img/Pixel-logo.png">
</head>
<body>
    <header>
        <div class="container">
            <div class="links">
                <img src="../img/pixel-logo.png" width="50">
            </div>
            <div class="main">
                <h1>Maak een account aan!</h1>
                <form method="post">
                    <div class="fld-con">
                        <div class="fld">
                            <label for="name">Naam</label>
                            <input type="text" name="name" required placeholder="Pieter Jan">
                        </div>
                        <div class="fld">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" required placeholder="naam@domain.com" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$">
                        </div>
                        <div class="fld">
                            <label for="dob">Geboortedatum</label>
                            <input type="date" name="dob" id="dob" required>
                        </div>
                        <div class="fld">
                            <label for="password">Wachtwoord</label>
                            <input type="password" name="password" id="password" required>
                        </div>
                        <div class="fld">
                            <label for="repeat_password">Herhaal Wachtwoord</label>
                            <input type="password" name="repeat_password" id="repeat_password" required>
                        </div>
                    </div>
                    <button type="submit">Registreer</button>
                    <?php if(!empty($err)){ ?>
                        <p class="error"><?php echo $err?></p>
                    <?php } ?>
                </form>
                <p>Heeft u al een account? <a href="../index.php">Log in!</a></p>
            </div>
        </div>
        <div class="con-img">
            <img src="../img/pixel-logo.png" alt="logo pixel" width="500">
        </div>
    </header>

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
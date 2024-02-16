<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost','root','','foto-upload');
 
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_email = $_POST['email'];
    $input_password = $_POST['password'];
 
    $query = "SELECT * FROM login WHERE email='$input_email' AND wachtwoord='$input_password'";
    $result = $conn->query($query);
 
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];
    
        if ($row['email'] == "admin@gmail.com") {
            $_SESSION['email'] = $row['email'];
            header("Location: admin.php");
        } else if ($row['email'] == $input_email) {
            $_SESSION['email'] = $row['email'];
            header("Location: ../index.php");
        } else {
            echo "Login failed. Please check your username and password.";
        }
    } else {
        echo "Login failed. Please check your username and password.";
    }
}
 
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pixel</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="login">
        <h2>Inloggen</h2>
        <form method="post">
            <label for="email">Email</label>
            <input type="text" name="email" required>
            <label for="password">Wachtwoord</label>
            <input type="password" name="password" required>
            <button type="submit">Inloggen</button>
        </form>

        <div class="links">
            <p>Nog geen account? <a href="./register.php">Registreren</a></p>
            <a href="../index.html">Terug naar Website</a>
        </div>
    </div>
</body>
</html>

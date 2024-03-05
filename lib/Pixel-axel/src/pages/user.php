<?php
@include '../db/dbconn.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$gebruikersnaam = $_SESSION['name'];
$email = $_SESSION["email"];

/*if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}*/

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['directoryName'])) {
    $dirName = trim($_POST['directoryName']);
    $userDir = __DIR__ . "/../foto upload/uploads/" . $gebruikersnaam . "/" . $dirName;

    if (!file_exists($userDir)) {
        mkdir($userDir, 0777, true);
        $_SESSION['message'] = "Directory '$dirName' successfully created.";
    } else {
        $_SESSION['message'] = "Directory already exists.";
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); 
}

$currentDir = isset($_GET['dir']) ? $_GET['dir'] : '';
$userBaseDir = __DIR__ . "/../foto upload/uploads/" . $gebruikersnaam;
if (!empty($currentDir)) {
    $userBaseDir .= '/' . $currentDir;
}

function scanUserDirectories($baseDir) {
    $directories = [];
    $scanResults = scandir($baseDir);
    foreach ($scanResults as $result) {
        if ($result === '.' or $result === '..') continue;
        if (is_dir($baseDir . '/' . $result)) {
            $directories[] = $result;
        }
    }
    return $directories;
}

$userDirectories = scanUserDirectories($userBaseDir);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page | Pixel</title>
</head>
<body>
    <nav>
        <a href="feed.php">feed</a>
        <a href="foto-upload.php">Foto uploaden</a>
        <a href="user.php">User pagina</a>
        <a href="../index.php">Log in</a>
    </nav>
    <div class="profile-container">
        <h2>Welkom op je profielpagina</h2>
        <p>Hier zijn je accountgegevens:</p>
        <ul>
            <li><strong>Gebruikersnaam:</strong> <?php echo $gebruikersnaam; ?></li>
            <li><strong>Email:</strong> <?php echo $email; ?></li>
        </ul>
        <form action="" method="post">
            <label for="directoryName">Mapnaam:</label>
            <input type="text" id="directoryName" name="directoryName" required>
            <button type="submit">Maak Map</button>
        </form>
        <p><?php echo $message; ?></p>
        <div>
            <h3>Jouw mappen:</h3>
            <ul>
                <?php foreach ($userDirectories as $directory): ?>
                    <li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?dir=' . urlencode($currentDir . '/' . $directory)); ?>"><?php echo htmlspecialchars($directory); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="logout.php">Uitloggen</a>
        <a href="index.php">Terug naar Website</a>
    </div>
</body>
</html>

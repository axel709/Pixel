<?php
@include '../db/dbconn.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$gebruikersnaam = $_SESSION['name'];
$email = $_SESSION["email"];

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

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
    <link rel="stylesheet" href="../style/css/style.css">
    <link rel="stylesheet" href="../style/css/pages/user.css">
</head>
<body>
    <nav>
        <div class="wrapper con-nav">
            <div class="logo">
                <img src="../img/pixel-logo.png" width="50">
                <h1>Pixel</h1>
            </div>
            <div class="links">
                <a href="feed.php">Feed</a>
                <a href="user.php">Profiel</a>
                <a href="uitlog.php">Uitloggen</a>
                <span class="button"><a href="foto-upload.php">Upload Foto</a></span>
            </div>
        </div>
    </nav>
    <main>
        <div class="wrapper con-main">
            <div class="item side-bar">
                <div>
                    <img src="../img/account-circle.svg" alt="User picture">
                    <div class="info-user">
                        <p>Gebruikersnaam: <span><?php echo $gebruikersnaam; ?></span></p>
                        <p>Email: <span><?php echo $email;?></span></p>
                    </div>
                </div>
                <a href="uitlog.php" class="button">Uitloggen</a>
            </div>
            <div class="item input-fld">
                <h1>Maak een nieuwe map aan</h1>
                <form class="search" action="" method="post">
                    <input type="text" id="directoryName" name="directoryName" required maxlength="30">
                    <button class="button" type="submit">Voeg Toe</button>
                </form>
            </div>
            <div class="item mappen">
                <h1>Uw Mappen</h1>
                <div class="con-folders">
                    <?php foreach ($userDirectories as $directory): ?>
                        <div class="card">
                            <img src="../img/folder.png" alt="folder" width="100">
                            <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?dir=' . urlencode($currentDir . '/' . $directory)); ?>"><?php echo htmlspecialchars($directory); ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
<!-- <p><?php //echo $message; ?></p> -->
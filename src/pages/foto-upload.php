<?php

include_once '../db/upload.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel - Voeg een foto toe!</title>
    <link rel="stylesheet" href="../style/css/style.css">
    <link rel="stylesheet" href="../style/css/pages/upload.css">
    <link rel="shortcut icon" href="../img/pixel-logo.png">
    <script src="../scripts/nav.js" defer></script>
</head>
<body>
    <nav class="closed">
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
            <div class="mobile-nav closed-mobile" onclick="hamburger()">
                <div class="hamburger"></div>
            </div>
        </div>
        <div id="mobile" class="mobile-links" style="display: none;">
            <div class="wrapper con-mobile">
                <a href="feed.php">Feed</a>
                <a href="user.php">Profiel</a>
                <a href="uitlog.php">Uitloggen</a>
                <span class="button"><a href="foto-upload.php">Upload Foto</a></span>
            </div>
        </div>
    </nav>
    <main>
        <div class="wrapper con-main">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="img-upload">
                    <label for="file">Maximale grootte bestand: 20MB</label>
                    <label for="file">Maximale resolutie: 500x500</label>
                    <input type="file" name="file" class="button" required>
                </div>
                <div class="fld">
                    <p>Titel: </p>
                    <input type="text" name="description" placeholder="Geef uw foto een titel" required>
                </div>
                <input class="button upload" type="submit" name="submit" value="Upload">
            </form>
            <?php if(!empty($statusMsg)){ ?>
                <p class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></p>
            <?php }?>
        </div>
    </main>
</body>
</html>
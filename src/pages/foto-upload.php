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
    <title>Upload</title>
    <link rel="stylesheet" href="../style/css/style.css">
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
    <div class="container">
        <div class="upfrm">
            <?php if(!empty($statusMsg)){ ?>
                <p class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></p>
            <?php }
            ?>
            <form method="post" enctype="multipart/form-data">
                <label>Select Image File to Upload:</label>
                <input type="file" name="file">
                <label>Titel:</label>
                <input type="text" name="description">
                <input type="submit" name="submit" value="Upload">
            </form>
        </div>
    </div>
</body>
</html>
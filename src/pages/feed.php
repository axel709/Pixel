<?php

include_once '../conf/dbconn.php';
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
    <title>Pixel - Actuele Foto's</title>
    <link rel="stylesheet" href="../style/css/style.css">
    <link rel="stylesheet" href="../style/css/pages/feed.css">
    <link rel="shortcut icon" href="../img/Pixel-logo.png">
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
            <?php
                $query = $db->query("SELECT * FROM images, login ORDER BY uploaded_on DESC");

                if ($query->num_rows > 0) {
                    while ($row = $query->fetch_assoc()) {
                        $imageURL = '../foto upload/uploads/' . $row["file_name"];
                        ?>
                        <div class="card">
                            <div class="title-card">
                                <img src="../img/account-circle.svg" width="50">
                                <p><?php echo $row['name']?></p>
                            </div>
                            <div class="img-card">
                                <div class="img" style="background-image: url('<?php echo $imageURL;?>');"></div>
                            </div>
                            <div class="card-body">
                                <p class="image-description">Titel: <?php echo $row["beschrijving"]; ?></p>
                                <p>Gepost op: <?php echo $row["uploaded_on"] ?></p>
                            </div>
                        </div>
            <?php
                    }
                }else{
            ?>
                    <p>Geen berichten gevonden!</p>
            <?php
                }
            ?>
        </div>
    </main> 
</body>
</html>
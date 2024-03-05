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
    <title>Feed</title>
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
    <h1>Feed Pagina</h1>
    <?php
        $query = $db->query("SELECT * FROM images, login ORDER BY uploaded_on DESC");

        if ($query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $imageURL = '../foto upload/uploads/' . $row["file_name"];
                ?>
                <div class="image-container">
                    <p><?php echo $row['name']?></p>
                    <img src="<?php echo $imageURL; ?>" width="200" />
                    <p>Gepost op: <?php echo $row["uploaded_on"] ?></p>
                    <p class="image-description">description: <?php echo $row["beschrijving"]; ?></p>
                    <?Php
                        $bestandsnaamZonderExtensie = pathinfo($row['file_name'], PATHINFO_FILENAME);
                    ?>
                    <p><?php echo $bestandsnaamZonderExtensie ?></p>
                </div>
                <?php
            }
        }else{
            ?>
            <p>No image(s) found...</p>
            <?php
        }
    ?>
</body>
</html>
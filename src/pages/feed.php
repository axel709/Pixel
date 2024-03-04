<?php
include_once '../conf/dbconn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
</head>
<body>
    <nav>
        <a href="feed.php">feed</a>
        <a href="foto-upload.php">Foto uploaden</a>
        <a href="user.php">User pagina</a>
        <a href="../index.php">Log in</a>
    </nav>
    <h1>Feed Pagina</h1>
    <?php
        $query = $db->query("SELECT * FROM images ORDER BY uploaded_on DESC");

        if ($query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $imageURL = '../db/uploads/' . $row["file_name"];
                ?>
                <div class="image-container">
                    <img src="<?php echo $imageURL; ?>" width="200" />
                    <p>Gepost op: <?php echo $row["uploaded_on"] ?></p>
                    <p class="image-description">description: <?php echo $row["beschrijving"]; ?></p>
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
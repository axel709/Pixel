<?php
include_once '../db/upload.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="feed.php">feed</a>
        <a href="foto-upload.php">Foto uploaden</a>
        <a href="user.php">User pagina</a>
        <a href="../index.php">Log in</a>
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
                <label>Image Description:</label>
                <textarea name="description"></textarea>
                <input type="submit" name="submit" value="Upload">
            </form>
        </div>
    </div>
</body>
</html>
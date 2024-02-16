<?php
include_once 'upload.php';
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
    <div class="container">
        <div class="upfrm">
            <?php if(!empty($statusMsg)){ ?>
                <p class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></p>
            <?php }
            ?>
            <form method="post" enctype="multipart/form-data">
                <label>Select Image File to Upload:</label>
                <input type="file" name="file">

                <input type="submit" name="submit" value="Upload">
            </form>
        </div>

        <div class="gallery">
            <div class="gcon">
                <h2>Uploaded Images</h2>
                <?php
                include_once 'dbConfig.php';

                // Get images from the database
                $query = $db->query("SELECT * FROM images ORDER BY uploaded_on DESC");

                if ($query->num_rows > 0) {
                    while ($row = $query->fetch_assoc()) {
                        $imageURL = 'uploads/' . $row["file_name"];
                        ?>
                        <img src="<?php echo $imageURL; ?>" alt="" />
                        <?php

                    }
                }else{
                    ?>
                    <p>No image(s) found...</p>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php


$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "foto-upload";

// Create mysqli connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check for mysqli connection error
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

try {
    // Create PDO connection
    $conn2 = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Process the image file
    $img_data = file_get_contents($image['tmp_name']);
    $img_mime = mime_content_type($image['tmp_name']);

    // Insert data into the database using mysqli
    $sql = "INSERT INTO `fotos` (beschrijving, foto1) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters for mysqli
    $stmt->bind_param("ss", $description, $img_data);

    // Execute mysqli statement
    $stmt->execute();
    $stmt->close();

    // Check the number of affected rows
    if ($conn->affected_rows > 0) {
        $title = "Uploaden succesvol";
        ?>
        <h1><?php echo $title; ?></h1>
        <p>Je post is succesvol geupload.</p>
        <p><a href="../dashboard.php">Terug naar dashboard</a></p>
        <script>
            // wait for 2 seconds and then redirect to dashboard.php
            setTimeout(function() {
                window.location.href = "../dashboard.php";
            }, 2000);
        </script>
        <?php
    } else {
        $title = "Uploaden mislukt";
        ?>
        <h1><?php echo $title; ?></h1>
        <p>Er is iets misgegaan bij het uploaden van je post.</p>
        <p><a href="../dashboard.php">Terug naar dashboard</a></p>

        <p>MySQL fout: <?php echo $conn->error; ?></p>
        <p>Query: <?php echo $sql; ?></p>
        
        <?php
    }
}
?>

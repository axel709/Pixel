<?php 
// Include the database configuration file 
include_once '../conf/dbconn.php'; 
 
$statusMsg = ''; 
 
// File upload directory 
$targetDir = "../foto upload/uploads/"; 

if(isset($_POST["submit"])){ 
    if(!empty($_FILES["file"]["name"])){ 
        $fileName = basename($_FILES["file"]["name"]); 
        $fileName =  $fileName;        
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
        
        // Get description from POST data
        $beschrijving = $_POST["description"];
     
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            // Upload file to server 
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                // Insert image file name and description into database 
                $insert = $db->query("INSERT INTO images (file_name, uploaded_on, beschrijving) VALUES ('".$fileName."', NOW(), '".$beschrijving."')"); 
                if($insert){ 
                    $statusMsg = "The file ".$fileName. " has been uploaded successfully."; 
                    // Redirect to upload_success.php after successful upload
                    header("Location: ../db/upload_success.php");
                    exit();
                }else{ 
                    $statusMsg = "File upload failed, please try again."; 
                }  
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file."; 
            } 
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = 'Please select a file to upload.'; 
    } 
} 
 
// Display status message 
echo $statusMsg; 
?>
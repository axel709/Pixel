<?php 

include_once '../conf/dbconn.php'; 
 
$statusMsg = ''; 
 

$targetDir = "../foto upload/uploads/"; 

if(isset($_POST["submit"])){ 
    if(!empty($_FILES["file"]["name"])){ 
        if ($_FILES["file"]["size"] <= 20000000) {
        $fileName = basename($_FILES["file"]["name"]); 
        $fileName =  $fileName;        
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
        
        
        $beschrijving = $_POST["description"];
     
        
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                
                $insert = $db->query("INSERT INTO images (file_name, uploaded_on, beschrijving) VALUES ('".$fileName."', NOW(), '".$beschrijving."')"); 
                if($insert){ 
                    $statusMsg = "The file ".$fileName. " has been uploaded successfully."; 
                    
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
    }else{
        $statusMsg = 'Sorry, your file is too large.';
    }
} 
 

echo $statusMsg; 
?>
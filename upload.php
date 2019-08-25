<?php
/***************************************
 *** author: yigit.yildirim@boun.edu.tr
 ***************************************/

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Allow certain file formats
if ($fileType != "xlsx") {
    echo "Only .xlsx files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>
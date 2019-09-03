<?php
/***************************************
 *** author: yigit.yildirim@boun.edu.tr
 ***************************************/

session_start();
if(!isset($_SESSION['login'])) {
    header('LOCATION:index.php'); die();
}

require_once "Classes/PHPExcel.php";

function findCol($sheet){
    $col = -1;
    $mailRowStart = -1;
    $lastRow = $sheet->getHighestRow();
    $lastCol = min(PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn()), 100); //highestColumn() returns interesting numbers. 100 is$
    for($i = 0; $i < $lastCol; $i++) {  //col starts from 0
        for ($j = 1; $j <= $lastRow; $j++) {    //row starts from 1 and first 2 rows are for the headers
            $data = $sheet->getCellByColumnAndRow($i, $j)->getValue();
            if (filter_var($data, FILTER_VALIDATE_EMAIL)){  // found the column of mail addresses
                $col = $i;
                $mailRowStart = $j;
                break;
            }
        }
        if($col !== -1){
            break;
        }
    }
    return array($col, $mailRowStart, $lastRow);
}

function extractMailAddresses($sheet, $col, $rowStart, $rowEnd){
    $mailArray = array();
    for ($i = $rowStart; $i <= $rowEnd; $i++) {
        $data = $sheet->getCellByColumnAndRow($col, $i)->getValue();
        array_push($mailArray, $data);
    }
    return $mailArray;
}


$targetDir = "data/";
$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Allow certain file formats
if ($fileType != "xlsx") {
    echo "Only .xlsx files are allowed.";
    $uploadOk = 0;
}
else die("NO");
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
}
else {
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        $xlReader = PHPExcel_IOFactory::createReaderForFile($targetFile);
        $xlObj = $xlReader->load($targetFile);
        $mailCol = -1;
        foreach ($xlObj->getAllSheets() as $sheet){
            list($mailCol, $mailrs, $mailre) = findCol($sheet);
            if($mailCol >= 0){  // appropriate sheet, extract mails
                $mails = extractMailAddresses($sheet,$mailCol, $mailrs, $mailre);
                break;
            }
        }
        if($mailCol < 0)
            die("Email column not found!");
        else{
            $listName = $_POST['list'];

            // archive the xlsx
            $newFolder = 'data/archive/'.$listName."-".date('Ymd-His');
            mkdir($newFolder);
            rename($targetFile, $newFolder.'/uploaded.xlsx');

            $command = escapeshellcmd('/var/www/html/panel/list_members '.$listName);
            $oldMembersFilePath = $newFolder. "/old_members.txt";
            $output = shell_exec("python " .$command. " > ".$oldMembersFilePath);

            $newMembersFilePath = $newFolder . "/new_members.txt";
            $newMembersFile = fopen($newMembersFilePath, "w");

            foreach ($mails as $mail)
                fwrite($newMembersFile, $mail."\n");
            fclose($newMembersFile);

            $removeCommand = escapeshellcmd('/var/www/html/panel/remove_members --nouserack --noadminack -f '. $oldMembersFilePath ." ".$listName);
            $removeCmdOutput = shell_exec("python ".$removeCommand);

            $addCommand = escapeshellcmd('/var/www/html/panel/add_members -r '. $newMembersFilePath ." ".$listName);
            $addCmdOutput = shell_exec("python ".$addCommand);

        }

    }
    else{
        echo "Sorry, there was an error uploading your file.";
    }
}

?>

?>
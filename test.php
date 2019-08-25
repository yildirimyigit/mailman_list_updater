<?php
/*
    require_once "Classes/PHPExcel.php";

    function findCol($sheet){
        $col = -1;
        $mailRowStart = -1;
        $lastRow = $sheet->getHighestRow();
        $lastCol = min(PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn()), 100);
        echo $lastRow ."\n";
        echo $lastCol ."\n";
        for($i = 0; $i < $lastCol; $i++) {  //col starts from 0
            for ($j = 1; $j <= $lastRow; $j++) {    //row starts from 1 and first 2 rows are for the headers
                $data = $sheet->getCellByColumnAndRow($i, $j)->getValue();
                if (filter_var($data, FILTER_VALIDATE_EMAIL)){
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

    $fname = "phd.xlsx";
    $xlReader = PHPExcel_IOFactory::createReaderForFile($fname);
    $xlObj = $xlReader->load($fname);
    $mailCol = -1;
    foreach ($xlObj->getAllSheets() as $sheet){
        list($mailCol, $mailrs, $mailre) = findCol($sheet);
        if($mailCol >= 0){
            $mails = extractMailAddresses($sheet,$mailCol, $mailrs, $mailre);
            break;
        }
    }
    if($mailCol < 0)
        die("Email column not found!");
    else{
        print_r($mails);
    }*/
?>

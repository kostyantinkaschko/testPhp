<?php
function readCvs($fileName, $mode = "r")
{
    $data = [];
    if (file_exists($fileName)) {
        $cvsFile = fopen($fileName, $mode);
        while (($row = fgetcsv($cvsFile)) !== false) {
            $data[] = $row;
        }
        fclose($cvsFile);
    }
    return $data;
}
        

function writeCvs($fileName, $data, $mode = "a")
{
    $result = false;
    if (file_exists($fileName)) {
        $cvsFile = fopen($fileName, $mode);
        fputcsv($cvsFile, $data);
        fclose($cvsFile);
        $result = true;
    }
    return $result;
}
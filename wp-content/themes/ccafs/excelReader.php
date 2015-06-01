<?php

/*
 * PHP Excel - Read a simple 2007 XLSX Excel file
 */

/** Set default timezone (will throw a notice otherwise) */
date_default_timezone_set('America/Los_Angeles');
require_once ("/lib/PHPExcel/PHPExcel.php");
//include '/lib/PHPExcel/IOFactory.php';

$inputFileName = 'D:\My Documents\Sample F3 data\SAMPLES data input template_Ole_test.xlsx';

//  Read your Excel workbook
try {
  $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
  $objReader = PHPExcel_IOFactory::createReader($inputFileType);
  $objPHPExcel = $objReader->load($inputFileName);
} catch (Exception $e) {
  die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
          . '": ' . $e->getMessage());
}

//  Get worksheet dimensions
$sheets = $objPHPExcel->getAllSheets();
foreach ($sheets as $key => $sheet) {
//$sheet = $objPHPExcel->getSheet(1);
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
  for ($row = 1; $row <= $highestRow; $row++) {
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
    foreach ($rowData[0] as $k => $v) {
      if ($v)
        echo "Row: " . $row . "- Col: " . ($k + 1) . " = " . $v . "<br />";
    }
  }
  echo "//////////////////////////////////////////////////////////$key - ".$sheet->getTitle()."<br>";
}
?>
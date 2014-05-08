<?php

require_once("inc/config.php");
require_once("inc/database.php");



ini_set("auto_detect_line_endings", true);
function readCSV($csvFile){
       $data = fopen($csvFile, 'r');
       while (!feof($data) ) {
               $line_of_text[] = fgetcsv($data, 1024);
       }
       fclose($data);
       return $line_of_text;
}

// Set path to CSV file
$csvFile = 'test.csv';

$csv = readCSV($csvFile);

$db->beginTransaction();

$sql = $db->prepare('INSERT IGNORE INTO tbl_merchants(email, first_name, last_name, company) VALUES(:a, :b, :c, :d)');

foreach ($csv as $insert_row)
{
  $sql->bindValue(':a', $insert_row[0]);
  $sql->bindValue(':b', $insert_row[1]);
  $sql->bindValue(':c', $insert_row[2]);
  $sql->bindValue(':d', $insert_row[3]);
  $sql->execute();
}


$db->commit();

?>
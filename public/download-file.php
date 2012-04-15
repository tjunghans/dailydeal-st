<?php
session_start();
require_once('../application/bootstrap.php');

$csv_data = array();

if (!isset($_GET['q'])) {
    header('location: /');
    exit;
}

$date = htmlspecialchars($_GET['q']);

$date_parts = explode('-', $date);

// $date should have yyyy-mm-dd format
if (strlen($date) !== 10 || count($date_parts) !== 3) {
    header('location: /');
    exit;
}

$csv_file_name = $date . '-dailydeal.csv';

function outputCSV($data) {
    $outstream = fopen("php://output", "w");
    function __outputCSV(&$vals, $key, $filehandler) {
        fputcsv($filehandler, $vals); // add parameters if you want
    }
    array_walk($data, "__outputCSV", $outstream);
    fclose($outstream);
}

// CSV Headers

header('Content-Encoding: UTF-8');
header("Content-type: application/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=" . $csv_file_name);
header("Pragma: no-cache");
header("Expires: 0");
echo "\xEF\xBB\xBF"; // UTF-8 BOM
/**/

// Fetch data from table and convert to csv
$query = 'SELECT dailydealvoucherId, title, firstname, lastname, street, housenumber, postalcode, city, email, vouchernumber, telephone, newsletter, `timestamp` FROM tblDailyDealVoucher WHERE date(`timestamp`) = STR_TO_DATE("' . $date . '", "%Y-%m-%d")';
$result = $dbh::getConnection()->query($query);

$resut_csv_array = array();

// Add column names to first row
array_push($resut_csv_array, $dbh::getDailyDealVoucherColumnNames());

while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    array_push($resut_csv_array, $row);
}

outputCSV($resut_csv_array);
exit;
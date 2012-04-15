<?php
require_once(dirname(__FILE__) . '/../../test/simpletest/autorun.php');
require_once(dirname(__FILE__) . '/../../application/libs/DatabaseHelper.php');

class TestOfDatabaseHelper extends UnitTestCase {
    function testBuildInsertSqlForDailyDealVoucher() {
        $arrayValues = array("Herr","Mike","November","Octoberstreet","12a", 1234, "Big Apple","mike.november@example.com","1234-5678-XHA","1234 44 55 66","yes");
        $sqlInsert = 'INSERT INTO tblDailyDealVoucher (title, firstname, lastname, street, housenumber, postalcode, city, email, vouchernumber, telephone, newsletter)' .
                    ' VALUES ("Herr","Mike","November","Octoberstreet","12a",1234,"Big Apple","mike.november@example.com","1234-5678-XHA","1234 44 55 66","yes")';

        $this->assertTrue(DatabaseHelper::buildInsertSqlForDailyDealVoucher($arrayValues) == $sqlInsert);

    }


}
?>
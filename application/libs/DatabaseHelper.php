<?php
class DatabaseHelper {
    private static $instance;
    private $count = 0;
    
    private static $connection = null;

    private function __construct($dsn, $user, $password)
    {
        self::$connection = new PDO($dsn, $user, $password);
    }

    public static function getInstance($dsn, $user, $password)
    {

        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className($dsn, $user, $password);
        }
        return self::$instance;
    }

    /**
     * Returns PDO instance
     * @method getConnection
     * @static
     * @return null|PDO
     */
    public static function getConnection() {
        return self::$connection;
    }

    /**
     * @method buildInsertSqlForDailyDealVoucher
     * @static
     * @param $arrayValues
     * @return string
     */
    public static function buildInsertSqlForDailyDealVoucher($arrayValues) {
        if (count($arrayValues) !== 11) {
            die('Incorrect number of values.');
        }

        $sqlInsert = 'INSERT INTO tblDailyDealVoucher (title, firstname, lastname, street, housenumber, postalcode, city, email, vouchernumber, telephone, newsletter)' .
            ' VALUES ("' . $arrayValues[0] . '",' .
            '"' . $arrayValues[1] . '",' .
            '"' . $arrayValues[2] . '",' .
            '"' . $arrayValues[3] . '",' .
            '"' . $arrayValues[4] . '",' .
            $arrayValues[5] . ',' .
            '"' . $arrayValues[6] . '",' .
            '"' . $arrayValues[7] . '",' .
            '"' . $arrayValues[8] . '",' .
            '"' . $arrayValues[9] . '",' .
            '"' . $arrayValues[10] . '")';
        return $sqlInsert;
    }

    /**
     * @method createDailyDealVoucher
     * @static
     * @param $arrayValues
     * @return int
     */
    public static function createDailyDealVoucher($arrayValues) {
        return self::getConnection()->exec(self::buildInsertSqlForDailyDealVoucher($arrayValues));
    }

    /**
     * @method getDailyDealVoucherColumnNames
     * @static
     * @return array
     */
    public static function getDailyDealVoucherColumnNames() {
        $query_columnnames = self::getConnection()->prepare("DESCRIBE tblDailyDealVoucher");
        $query_columnnames->execute();
        return $query_columnnames->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function getDailyVoucherByDate($date) {
        //return self::getConnection()->query('');
    }


    public function increment()
    {
        return $this->count++;
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }
}

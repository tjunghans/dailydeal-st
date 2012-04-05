<?php

 
class FormHelper {
    public static function isValidEmail($email) {
        return (filter_var($email, FILTER_VALIDATE_EMAIL) == false) ? false : true;
    }

    public static function isValidName($name) {
        return (preg_match('/^.+$/', trim($name)) == 0 ? false : true);
    }

    public static function isValidVoucherCode($vouchercode) {

        $voucher_length = strlen($vouchercode);
 
        if ($voucher_length < 8 || $voucher_length > 16) {
            return false;
        }

        // Handle Umlaut
        setLocale(LC_CTYPE, 'CH_de.UTF-8');
        $vouchercode_ascii = iconv('UTF-8', 'ASCII//TRANSLIT', $vouchercode);
        
        // Remove - and the double quotes caused by iconv conversion
        $aValid = array('-', "\"");
        if (!ctype_alnum(str_replace($aValid, '', $vouchercode_ascii))) {
           return false;
        }

        return true;
    }

    public static function clean($text) {
        $text = strip_tags($text);
        $text = htmlspecialchars($text, ENT_QUOTES);
        return ($text);
    }

    public static function json_response($response) {
        // Convert to JSON
        $json = json_encode($response);

        // Set content type
        header('Content-type: application/json');

        // Prevent caching
        header('Expires: 0');

        // Send Response
        print($json);
        exit;
    }
}

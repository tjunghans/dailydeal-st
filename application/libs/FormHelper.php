<?php

 
class FormHelper {
    public static function isValidEmail($email) {
        return (filter_var($email, FILTER_VALIDATE_EMAIL) == false) ? false : true;
    }

    public static function isValidName($name) {
        return (preg_match('/^.+$/', trim($name)) == 0 ? false : true);
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

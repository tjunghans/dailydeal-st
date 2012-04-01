<?php

 
class FormHelper {
    public static function isValidEmail($email) {
        return (filter_var($email, FILTER_VALIDATE_EMAIL) == false) ? false : true;
    }

    public static function isValidName($name) {
        return (preg_match('/^.+$/', trim($name)) == 0 ? false : true);
    }
}

<?php
require_once('../application/libs/ConfigHelper.php');
require_once('../application/libs/FormHelper.php');
require_once('../application/libs/recaptchalib.php');
$ch = ConfigHelper::getInstance();

$privatekey = $ch->getConfig()->recaptcha_privatekey;

if ($ch->getEnvironmnent() != 'dev') {
    $resp = recaptcha_check_answer($privatekey,
       $_SERVER["REMOTE_ADDR"],
       $_POST["recaptcha_challenge_field"],
       $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) {
        // What happens when the CAPTCHA was entered incorrectly
        die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
             "(reCAPTCHA said: " . $resp->error . ")");
    } else {
        //success
    }
} else {
    // success

    // 1. Validate Data
    $isValidForm = true;
    $inValidElements = array();

    if (!FormHelper::isValidName($_POST['firstname'])) {
        $isValidForm = false;
        $inValidElements[] = 'firstname';
    }

    if (!FormHelper::isValidName($_POST['lastname'])) {
        $isValidForm = false;
        $inValidElements[] = 'lastname';
    }

    if (!FormHelper::isValidName($_POST['street'])) {
        $isValidForm = false;
        $inValidElements[] = 'street';
    }

    if (!FormHelper::isValidName($_POST['housenumber'])) {
        $isValidForm = false;
        $inValidElements[] = 'housenumber';
    }

    if (!FormHelper::isValidName($_POST['postalcode'])) {
        $isValidForm = false;
        $inValidElements[] = 'postalcode';
    }

    if (!FormHelper::isValidName($_POST['city'])) {
        $isValidForm = false;
        $inValidElements[] = 'city';
    }

    if (!FormHelper::isValidEmail($_POST['email'])) {
        $isValidForm = false;
        $inValidElements[] = 'email';
    }

    if (!FormHelper::isValidEmail($_POST['vouchernumber'])) {
        $isValidForm = false;
        $inValidElements[] = 'vouchernumber';
    }

    If ($isValidForm == false) {
        $response = array(
            "responseType" => "error",
            "invalidElements" => $inValidElements
        );

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
?>
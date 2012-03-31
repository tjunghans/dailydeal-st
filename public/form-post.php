<?php
require_once('../application/libs/ConfigHelper.php');
require_once('../application/libs/recaptchalib.php');
$ch = ConfigHelper::getInstance();

$privatekey = $ch->getConfig()->recaptcha_privatekey;

$resp = recaptcha_check_answer($privatekey,
   $_SERVER["REMOTE_ADDR"],
   $_POST["recaptcha_challenge_field"],
   $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
} else {
    var_dump($_POST);
}

?>
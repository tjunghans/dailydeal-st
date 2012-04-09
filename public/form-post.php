<?php
session_start();
require_once('../application/bootstrap.php');
require_once('../application/libs/ConfigHelper.php');
require_once('../application/libs/FormHelper.php');
require_once('../application/libs/recaptchalib.php');
require_once('../application/libs/Swift/lib/swift_required.php');
$ch = ConfigHelper::getInstance();
require_once('../application/libs/LabelHelper.php');
$lh = LabelHelper::getInstance();

// Sessionid and form input should be the same
if (session_id() != $_POST['sess']) {
    $response = array(
        "responseType" => "error",
        "responseText" => $lh->getLabel('INVALID_SESSION')
    );

    FormHelper::json_response($response);
}

$privatekey = $ch->getConfig()->recaptcha_privatekey;

if ($ch->getEnvironmnent() != 'dev') {
    $resp = recaptcha_check_answer($privatekey,
       $_SERVER["REMOTE_ADDR"],
       $_POST["recaptcha_challenge_field"],
       $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) {
        // What happens when the CAPTCHA was entered incorrectly
        //die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
             //"(reCAPTCHA said: " . $resp->error . ")");
        $response = array(
            "responseType" => "error",
            "responseText" => $lh->getLabel('INCORRECT_CAPTCHA'),
            "invalidCaptcha" => "true"
        );

        FormHelper::json_response($response);
    }
}


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

if (!FormHelper::isValidVoucherCode($_POST['vouchernumber'])) {
    $isValidForm = false;
    $inValidElements[] = 'vouchernumber';
}

// On keyup validation, the field "sendform" is sent as well. The form should only be posted if all fields are valid
// AND the user clicks on submit.
if ($isValidForm == false || isset($_POST['sendform']) && $_POST['sendform'] == "false") {
    $response = array(
        "responseType" => "error",
        "responseText" => "Invalid elements",
        "invalidElements" => $inValidElements
    );

    FormHelper::json_response($response);
} else {

    // Santize data
    $csvFields = array(
        FormHelper::clean($_POST['title']),
        FormHelper::clean($_POST['firstname']),
        FormHelper::clean($_POST['lastname']),
        FormHelper::clean($_POST['street']),
        FormHelper::clean($_POST['housenumber']),
        FormHelper::clean($_POST['postalcode']),
        FormHelper::clean($_POST['city']),
        FormHelper::clean($_POST['email']),
        FormHelper::clean($_POST['vouchernumber']),
        FormHelper::clean($_POST['telephone']),
        FormHelper::clean($_POST['newsletter']),
        $date = date('d.m.Y H:i:s', time())
    );

    // Create csv file
    $csvFileName = tempnam($ch->getTempPath(), 'csv');
    // Write to csv file
    $csvFileHandle = fopen($csvFileName, 'w+');
    fputcsv($csvFileHandle, $csvFields);
    fseek($csvFileHandle, 0);
    fclose($csvFileHandle);


    // E-mail csv file to st
    $transport = Swift_SmtpTransport::newInstance($ch->getConfig()->smtp->server, $ch->getConfig()->smtp->port)
      ->setUsername($ch->getConfig()->smtp->username)
      ->setPassword($ch->getConfig()->smtp->password)
      ;

    $mailer = Swift_Mailer::newInstance($transport);

    // $title and $lastname are used by partial include
    $title = $csvFields[0];
    $lastname = $csvFields[2];
    ob_start ();
    require('../application/partials/emailbody-client.phtml');
    $body = ob_get_contents();
    ob_end_clean();

    // Client E-Mail
    $message = Swift_Message::newInstance()

      // Give the message a subject
      ->setSubject($lh->getLabel('DD_CLIENT_EMAIL_SUBJECT'))

      // Set the From address with an associative array
      ->setFrom(array($ch->getConfig()->dailymail->fromMail => $ch->getConfig()->dailymail->fromName))

      // Set the To addressesiative array with an assoc
      ->setTo(array($csvFields[7] => $csvFields[1] . ' ' . $csvFields[2]))

      // Give it a body
      ->setBody($body)

      // And optionally an alternative body
      ->addPart($body, 'text/html')

        ->setCharset('utf-8');
      ;
    $numSent = $mailer->send($message);


    // ST E-Mail
    ob_start ();
    require('../application/partials/emailbody-st.phtml');
    $body = ob_get_contents();
    ob_end_clean();

    $message = Swift_Message::newInstance()

      // Give the message a subject
      ->setSubject($lh->getLabel('DD_ST_EMAIL_SUBJECT'))

      // Set the From address with an associative array
      ->setFrom(array($ch->getConfig()->dailymail->fromMail => $ch->getConfig()->dailymail->fromName))

      // Set the To addresses with an associative array
      ->setTo(array($ch->getConfig()->dailymail->toMail => $ch->getConfig()->dailymail->toName))

      // Give it a body
      ->setBody($body)

      // And optionally an alternative body
      ->addPart($body, 'text/html')

      // Optionally add any attachments
      ->attach(Swift_Attachment::fromPath($csvFileName))

        ->setCharset('utf-8');
      ;
    $numSent = $mailer->send($message);

    session_start();
    // Store date in session so it can be used on confirmation page
    $_SESSION['post'] = $csvFields;

    $response = array(
        "responseType" => "success",
        "responseText" => "Success",
        "email" => $numSent,
        "post" => $csvFields
    );

    FormHelper::json_response($response);

}
?>
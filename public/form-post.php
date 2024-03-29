<?php
session_start();
require_once('../application/bootstrap.php');
require_once('../application/libs/Swift/lib/swift_required.php');

// Sessionid and form input should be the same
if (session_id() != $_POST['sess']) {
    $response = array(
        "responseType" => "error",
        "responseText" => $lh->getLabel('INVALID_SESSION')
    );

    FormHelper::json_response($response);
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
} else {
    // Need a variable for vouchernumber in case multiple vouchers have been added
    $vouchernumber = $_POST['vouchernumber'];
}

if (isset($_POST['addvouchernumber'])) {
    // Only the first voucher code is checked
    $addVoucherNumber = count($_POST['addvouchernumber']) ? $_POST['addvouchernumber'] : array();
    $additionalVoucherNumbers = count($addVoucherNumber) ? implode(',', $addVoucherNumber) : '';
    $vouchernumber .= ', ' . $additionalVoucherNumbers;
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
    $fields = array(
        FormHelper::clean($_POST['title']),
        FormHelper::clean($_POST['firstname']),
        FormHelper::clean($_POST['lastname']),
        FormHelper::clean($_POST['street']),
        FormHelper::clean($_POST['housenumber']),
        FormHelper::clean($_POST['postalcode']),
        FormHelper::clean($_POST['city']),
        FormHelper::clean($_POST['email']),
        FormHelper::clean($vouchernumber),
        FormHelper::clean($_POST['telephone']),
        FormHelper::clean($_POST['newsletter'])
    );

    // Create db entry
    $dbh::createDailyDealVoucher($fields);

    // E-mail csv file to st
    $transport = Swift_SmtpTransport::newInstance($ch->getConfig()->smtp->server, $ch->getConfig()->smtp->port)
      ->setUsername($ch->getConfig()->smtp->username)
      ->setPassword($ch->getConfig()->smtp->password)
      ;

    $mailer = Swift_Mailer::newInstance($transport);

    // This variables are used in the required .phtml
    $title = $fields[0];
    $firstname = $fields[1];
    $lastname = $fields[2];
    $street = $fields[3];
    $housenumber = $fields[4];
    $postalcode = $fields[5];
    $city = $fields[6];
    $email = $fields[7];
    $vouchernumber = $fields[8];
    $telephone = $fields[9];
    $newsletter = $fields[10];

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
      ->setTo(array($fields[7] => $fields[1] . ' ' . $fields[2]))

      // Give it a body
      ->setBody($body)

      // And optionally an alternative body
      ->addPart($body, 'text/html')

        ->setCharset('utf-8');
      ;
    $numSent = $mailer->send($message);


    // ST E-Mail
    ob_start ();
    require('../application/partials/emailbody-client.phtml'); // same email is sent to Silvio Tossi as client
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
 //     ->attach(Swift_Attachment::fromPath($csvFileName))

        ->setCharset('utf-8');
      ;
    $numSent = $mailer->send($message);

    session_start();
    // Store date in session so it can be used on confirmation page
    $_SESSION['post'] = $fields;

    $response = array(
        "responseType" => "success",
        "responseText" => "Success",
        "email" => $numSent,
        "post" => $fields
    );

    FormHelper::json_response($response);

}
?>
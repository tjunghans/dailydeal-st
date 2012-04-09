<?php
session_start();
require_once('../application/bootstrap.php');
if (!isset($_SESSION['post'])) {
    header('location: index.php');
    exit;
}

?><!DOCTYPE html>
<html>
<head>
    <title><?php echo $lh->getLabel('TITLE');?></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="language" content="de-ch, de">  
    <link href="/images/favicon.ico" rel="shortcut icon">
    <link href="/stylesheets/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/stylesheets/base.css" media="all" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container">
        <?php include_once($ch->getPartialsPath() . '/header.phtml');?>
        <div class="row">
            <div class="span12">
                <section class="content">
                    <h1>Vielen Dank!</h1>
                    <p>Sie werden in Kürze eine E-Mail von Silvio Tossi erhalten.</p>
                    <p>Ihre Angaben:<br/>

                    <?php
                    $sess_post = $_SESSION['post'];
                    $output = array(
                            "Anrede" => $sess_post[0],
                            "Vorname" => $sess_post[1],
                            "Nachname" => $sess_post[2],
                            "Strasse" => $sess_post[3],
                            "Hausnummer" => $sess_post[4],
                            "PLZ" => $sess_post[5],
                            "Ort" => $sess_post[6],
                            "E-Mail-Adresse" => $sess_post[7],
                            "Gutscheinnummer" => $sess_post[8],
                            "Telefon" => $sess_post[9],
                            "Newsletter" => $sess_post[10],
                        );
                    ?>

                    <dl class="dl-horizontal">
                    <?php
                    foreach($output as $dt => $dd) {
                    ?>
                        <dt><?php echo $dt;?></dt><dd><?php echo $dd;?></dd>
                     <?php
                    }
                    ?>

                    </dl>
  
                    </p>
                    <p>
                        <a href="/">Zurück zum Formular</a> | <a href="http://www.silviotossi.com">Zu Silvio Tossi</a>
                    </p>
                </section>
            </div>
        </div>
        <?php include_once($ch->getPartialsPath() . '/footer.phtml');?>
        <script type="text/javascript" src="/javascripts/libraries/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="/javascripts/libraries/terrific-1.1.0.min.js"></script>
        <script type="text/javascript" src="/javascripts/project/Tc.bootstrap.js"></script>
    </div>
</body>
</html><?php
// Clear session
session_unset();
session_destroy();
session_write_close();
?>


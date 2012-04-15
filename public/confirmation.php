<?php
session_start();
require_once('../application/bootstrap.php');
if (!isset($_SESSION['post'])) {
    header('location: index.php');
    exit;
}

$page_title = 'Confirmation';
?><?php include_once($ch->getPartialsPath() . '/page-header.phtml');?>
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
        <?php include_once($ch->getPartialsPath() . '/page-js.phtml');?>
    </div>
</body>
</html><?php
// Clear session
session_unset();
session_destroy();
session_write_close();
?>


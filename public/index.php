<?php
session_start();
require_once('../application/bootstrap.php');
$page_title = 'Form';
?><?php include_once($ch->getPartialsPath() . '/page-header.phtml');?>
<body>
    <div class="container">
        <?php include_once($ch->getPartialsPath() . '/header.phtml');?>
        <div class="row">
            <div class="span12">

                <?php include_once($ch->getPartialsPath() . '/form.phtml');?>

            </div>
        </div>
        <?php include_once($ch->getPartialsPath() . '/footer.phtml');?>
        <?php include_once($ch->getPartialsPath() . '/page-js.phtml');?>
    </div>
    <?php include_once($ch->getPartialsPath() . '/ga.phtml');?>
</body>
</html>


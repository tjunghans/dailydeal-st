<?php
session_start();
require_once('../application/bootstrap.php');

?><!DOCTYPE html>
<html>
<head>
    <title><?php echo $ch->getConfig()->labels->title;?></title>
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

                <?php include_once($ch->getPartialsPath() . '/form.phtml');?>

            </div>
        </div>
        <?php include_once($ch->getPartialsPath() . '/footer.phtml');?>
        <script type="text/javascript" src="/javascripts/libraries/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="/javascripts/libraries/terrific-1.1.0.min.js"></script>
        <script type="text/javascript" src="/javascripts/project/Tc.bootstrap.js"></script>
        <script type="text/javascript" src="/javascripts/project/Tc.Module.Form.js"></script>

    </div>
    <?php include_once($ch->getPartialsPath() . '/ga.phtml');?>
</body>
</html>


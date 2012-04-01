<?php
session_start();
require_once('../application/bootstrap.php');
require_once('../application/libs/ConfigHelper.php');
$ch = ConfigHelper::getInstance();
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
        <?php

        print_r($_SESSION['post']);
        ?>
        <h1>Vielen Dank!</h1>
        <p>Sie werden in Kürze eine E-Mail von Silvio Tossi erhalten.</p>

        <script type="text/javascript" src="/javascripts/libraries/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="/javascripts/libraries/terrific-1.1.0.min.js"></script>
        <script type="text/javascript" src="/javascripts/project/Tc.bootstrap.js"></script>
    </div>
</body>
</html>


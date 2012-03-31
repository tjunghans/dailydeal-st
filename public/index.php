<?php
require_once('../application/libs/ConfigHelper.php');
$ch = ConfigHelper::getInstance();
?><!DOCTYPE html>
<html>
<head>
    <title>Silvio Tossi Daily Deal</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="language" content="de-ch, de">  
    <link href="/images/favicon.ico" rel="shortcut icon">
    <link href="/stylesheets/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/stylesheets/base.css" media="all" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container">
        <?php
        $config = json_decode(file_get_contents('../application/configs/config.json'));
        //print_r($config->env);
        ?>

        <?php include_once('../application/partials/form.phtml');?>

        <script type="text/javascript" src="/javascripts/libraries/jquery-1.7.2.min.js"></script>

    </div>
</body>
</html>


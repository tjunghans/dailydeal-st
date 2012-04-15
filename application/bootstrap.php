<?php
date_default_timezone_set('Europe/Zurich');

require_once('../application/libs/ConfigHelper.php');
$ch = ConfigHelper::getInstance();

require_once('../application/libs/FormHelper.php');

require_once('../application/libs/DatabaseHelper.php');
$dbh = DatabaseHelper::getInstance($ch->getConfig()->db->dsn, $ch->getConfig()->db->username, $ch->getConfig()->db->password);

require_once('../application/libs/LabelHelper.php');
$lh = LabelHelper::getInstance();


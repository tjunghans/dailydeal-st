<?php
require_once('../application/bootstrap.php');

define(AUTH_PASSWORD, hash($ch->getConfig()->hash_algorithm, $ch->getConfig()->auth_password));

session_start();
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

if (isset($_POST['password'])) {
    if (hash($ch->getConfig()->hash_algorithm, $_POST['password']) == AUTH_PASSWORD) {
        $_SESSION['loggedIn'] = true;
    } else {
        die ('Incorrect password');
    }
}

if (!$_SESSION['loggedIn']): ?>
<?php
$page_title = 'Authenticate';
?><?php include_once($ch->getPartialsPath() . '/page-header.phtml');?>
<body>
    <div class="container">
        <?php include_once($ch->getPartialsPath() . '/header.phtml');?>
        <div class="row">
            <div class="span12">
                <div class="content">
                    <form method="post" class="form-inline">
                      Password: <input type="password" name="password" />
                      <input type="submit" name="submit" value="Login" class="btn" />
                    </form>
                </div>
            </div>
        </div>
        <?php include_once($ch->getPartialsPath() . '/footer.phtml');?>
        <?php include_once($ch->getPartialsPath() . '/page-js.phtml');?>
    </div>
    <?php include_once($ch->getPartialsPath() . '/ga.phtml');?>
</body>
</html>
<?php
exit();
endif;
?>


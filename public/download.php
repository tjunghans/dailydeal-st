<?php
session_start();
require_once('../application/bootstrap.php');

$page_title = 'CSV Download';
?><?php include_once($ch->getPartialsPath() . '/page-header.phtml');?>
<body>
    <div class="container">
        <?php include_once($ch->getPartialsPath() . '/header.phtml');?>
        <div class="row">
            <div class="span12">
                <div class="content">
                    
                    <h1>CSV herunterladen</h1>
                    <?php
                    $query = "SELECT date(timestamp) as querydate, DATE_FORMAT(timestamp, '%d.%m.%Y') as displaydate FROM tblDailyDealVoucher GROUP BY date(timestamp) ORDER BY timestamp DESC";
                    $result = $dbh::getConnection()->query($query);
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<a href="/download-file.php?q=' . $row['querydate'] . '">' . $row['displaydate'] . '</a><br/>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php include_once($ch->getPartialsPath() . '/footer.phtml');?>
        <?php include_once($ch->getPartialsPath() . '/page-js.phtml');?>
    </div>
    <?php include_once($ch->getPartialsPath() . '/ga.phtml');?>
</body>
</html>


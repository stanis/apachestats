<?php
include(WEB_PATH . '/views/header.php');
foreach($stats->getDates() as $date) {
?>
<h4><? echo $date; ?></h4>
<p>Visitors: <?php echo $stats->getVisitorsByDate($date); ?></p>
<p>Hits: <?php echo $stats->getHitsByDate($date); ?></p>
<?php
}
?>
<h4>Averages</h4>
<p>Visitors:<?php echo $stats->average_visitors; ?></p>
<p>Hits:<?php echo $stats->average_hits; ?></p>
<?php
include(WEB_PATH . '/views/footer.php');
?>

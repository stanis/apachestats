<?php
define('LIB_PATH', realpath(dirname(__FILE__) . '/../lib'));
require_once LIB_PATH . '/RegexParser.php';
require_once LIB_PATH . '/ApacheLogRegexParser.php';
require_once LIB_PATH . '/ApacheLogStatsCollector.php';

$dto = ApacheLogStatsCollector::collect('access.log');

echo "Total: ", $dto->total, "\nAverage hits: ", $dto->average_hits, "\nAverage visitors: ", $dto->average_visitors, "\n";

foreach ($dto->getDates() as $date) {
	echo $date, "\n";
	echo "-- hits: ", $dto->getHitsByDate($date), "\n";
	echo "-- visitors: ", $dto->getVisitorsByDate($date), "\n";
}

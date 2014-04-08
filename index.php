<?php

define('WEB_PATH', realpath(dirname(__FILE__)));

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']['tmp_name'])) {
	require_once WEB_PATH . '/lib/RegexParser.php';
	require_once WEB_PATH . '/lib/ApacheLogRegexParser.php';
	require_once WEB_PATH . '/lib/ApacheLogStatsCollector.php';
	$stats = ApacheLogStatsCollector::collect($_FILES['userfile']['tmp_name']);
	require WEB_PATH . '/views/results.php';
} else {
	require WEB_PATH . '/views/form.php';
}

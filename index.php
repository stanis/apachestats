<?php

define('WEB_PATH', realpath(dirname(__FILE__)));

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	require WEB_PATH . 'views/form.php';
} else {
	require_once WEB_PATH . '/lib/RegexParser.php';
	require_once WEB_PATH . '/lib/ApacheLogRegexParser.php';
	require_once WEB_PATH . '/lib/ApacheLogStatsCollector.php';
	
	require WEB_PATH . '/views/results.php';
}

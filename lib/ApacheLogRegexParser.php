<?php
/**
* Parses Apache Combined logs
* @link http://httpd.apache.org/docs/1.3/logs.html#combined
* @see RegexParser
*/
class ApacheLogRegexParser extends RegexParser {
	const COMBINED_REGEX = '^(?P<ip>\S+) (?P<ident>\S+) (?P<user>\S+) (?P<time>\[([^\]]+)\]) (?P<request>"([A-Z]+)[^"]*") (?P<status>\d+) (?P<size>\d+) (?P<referer>"[^"]*") (?P<useragent>"([^"]*)")$';

	function __construct() {
		parent::__construct(self::COMBINED_REGEX);
	}

	// We need to extract the date here
	function parseLine($line) {
		$data = parent::parseLine($line);
		$data['date'] = substr(split(":", $data['time'])[0], 1);
		return $data;
	}
}

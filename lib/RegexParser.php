<?php
/**
* Parses the input lines using a given regular expression
*
* @see RegexParser
*/
class RegexParser {
	/**
	* Parses the line
	* @param string $line a line to parse
	* @throws InvalidArgumentException regex doesn't match an argument
	*/
	public function parseLine($line) {
		if (preg_match("/{$this->regex}/", $line, $matches)) {
			return($matches);
		} else 
			throw new InvalidArgumentException("The regex {$this->regex} doesn't match the line {$line}");
	}

	/**
	* Constructor
	* @param string $regex
	*/
	public function __construct($regex) {
		$this->regex = $regex;
	}

}


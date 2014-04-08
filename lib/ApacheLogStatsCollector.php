<?php
/**
* Allows to move the data between the layers
*/
class ApacheLogStatsDTO {
	public $total;
	public $average_hits;
	public $average_visitors;
	/**
	* This internal structure contains an array of form
	* 'day/mon/year' => array (
	*    'hits' => 393,
	*    'addresses' => array(
	*	ip2long1 => number of visits 1,
		ip2long2 => number of visits 2,
	* ),
	* ...
	*/
	private $dates=array();
	private $_lastDate = '';

	/**
	* Get the dates of the log entries
	*
	* @return array
	*/
	public function getDates() {
		return array_keys($this->dates);
	}

	/**
	* Creates an array for a new date
	*
	* @param string $date new date
	*/
	private function _createDateArray($date) {
		$this->dates[$date] = array(
			'addresses'	=> array(),
			'hits'		=> 0
		);
	}

	/**
	* Adds a record to the object
	*
	* @param array $parsedLine
	*/
	public function addRecord($parsedLine) {
		$this->total++;
		if ($this->_lastDate != $parsedLine['date']) {
			$this->_lastDate = $parsedLine['date'];
			$this->_createDateArray($this->_lastDate);
		}
		$date_arr = &$this->dates[$this->_lastDate];
		if (isset($date_arr['addresses'][$parsedLine['ip']])) {
			$date_arr['addresses'][$parsedLine['ip']]++;
		} else {
			$date_arr['addresses'][$parsedLine['ip']] = 1;
		}
		$date_arr['hits']++;
	}

	/**
	* @param string $date
	*/
	public function getHitsByDate($date) {
		return $this->dates[$date]['hits'];
	}

	/**
	* @param string $date
	*/
	public function getVisitorsByDate($date) {
		return count($this->dates[$date]['addresses']);
	}

	/**
	* Returns the average values of hits and visitors
	*
	* @return array a hash of averages of hits and visitors
	*/
	public function calculateAverages() {
		$count = count($this->dates);
		if ($count == 0) return;
		$hits = 0;
		$visitors = 0;
		foreach($this->dates as $arr) {
			$hits += $arr['hits'];
			$visitors += count($arr['addresses']);
		}
		$this->average_hits = $hits / $count;
		$this->average_visitors = $visitors / $count;
	}
}

/**
* Collects the stats
*/
class ApacheLogStatsCollector {
	/**
	* Parses the file with apache combined log file and collects the stats
	*
	* @param string $fname the name of the file
	* @param bool $suppressException 
	* @throws InvalidArgumentException (if $suppressException is set)
	* @return ApacheLogStatsDTO
	*/
	public static function collect($fname, $suppressException = true) {
		$fh = fopen($fname, 'r'); if (!$fh) throw new RuntimeException("Can't open $fname");
		$p = new ApacheLogRegexParser();
		$stats = new ApacheLogStatsDTO();
		try {
			while ($line = fgets($fh)) {
				$stats->addRecord($p->parseLine($line));
			}
		} catch (Exception $e) {
			if (!$suppressException) {
				fclose($fh); // I need 5.5 again!
				throw $e;
			}
		}
		fclose($fh);
		$stats->calculateAverages();
		return $stats;
	}
}



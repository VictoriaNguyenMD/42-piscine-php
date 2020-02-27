#!/usr/bin/php
<?php
if ($argc >= 2) {
	$regex = "/^(\w+)\s([0-9]{1,2})\s(\w+)\s([0-9]{4})\s((?:[0-1]?[0-9])|(?:2[0-3])):([0-5][0-9]):([0-5][0-9])$/i";
	if (preg_match($regex, $argv[1], $matches)){
		$dict_dates = array_flip (array ("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"));
		
		$day = $matches[2];
		$month =  $dict_dates[strtolower($matches[3])] + 1;
		$year =  $matches[4];
		$hour = $matches[5]; #Normally -1 to account for daylight saving. No need to since list begins at 0.
		$minute = $matches[6];
		$second = $matches[7];

		#echo mktime(11, 2, 21, 11, 12, 2013);
		echo mktime($hour, $minute, $second, $month, $day, $year) . "\n";
	} else {
		echo "Wrong Format\n";
	}
}
?>
<?php

require "Provider.php" ;


function init($array) {
	$providers
	foreach ($array as $provider => $value) {
		$providers[$provider] = new Provider($value[0],$value[1],$value[2],$value[3],$value[4]) ;
	}
	return $providers ;
}
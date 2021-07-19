<?php

require "Provider.php" ;

function init($array) {
	$providers = [] ;
	foreach ($array as $provider => $value) {
		$providers[$provider] = new Provider($value["clientID"],$value["clientSecret"],$value["urlAuth"],$value["urlToken"],$value["urlResult"]) ;
	}
	return $providers ;
}
<?php

require "Provider.php" ;

function init($array) {
	$providers = [] ;
	foreach ($array as $provider => $value) {
	    if(!isset($value["scope"]))
		    $providers[$provider] = new Provider($value["clientID"],$value["clientSecret"],$value["urlAuth"],$value["urlToken"],$value["urlResult"],$value['redirectUri']) ;
	    else
            $providers[$provider] = new Provider($value["clientID"],$value["clientSecret"],$value["urlAuth"],$value["urlToken"],$value["urlResult"],$value['redirectUri'],$value['scope']) ;
	}
	return $providers ;
}
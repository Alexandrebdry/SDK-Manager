<?php

require "Provider.php" ;

function init($array) {
    $providers = [] ;
    foreach ($array as $provider => $value) {
        $scope = "basic" ;
        if(isset($value["scope"]))
            $scope = $value['scope'] ;
        $state = "dsdsfsfds" ;
        if(isset($value['state']))
            $state = $value['state'];

        $providers[$provider] = new Provider($value["clientID"],$value["clientSecret"],$value["urlAuth"],$value["urlToken"],$value["urlResult"],$value['redirectUri'],$scope,$state) ;
    }
    return $providers ;
}
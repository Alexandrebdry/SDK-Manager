<?php

Class Provider {

	private $user ; 

	public function getUser(array $params, string $url, string $urlResult, string $clientID, string $clientSecret) {

		$result = file_get_contents(
			$url . "client_id=" . $client_id 
			. "&client_secret=" . $clientSecret
			. "&" . http_build_query($params)
		);
		
		$token = json_decode($result,true)["access_token"] ;

		//Getting user by Token
		$context = stream_context_create([
			"http"=>
				[
					"method"=>"GET",
					"header"=>"
						Authorization:
						Bearer " . $token
				]
		]);

		$result = file_get_contents($urlResult, false, $context);

		$this->user = json_decode($result,true) ; 
		var_dump($this->user) ;
	}
}
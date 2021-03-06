<?php

Class Provider {


	private $clientID ;
	private $clientSecret ;
	private $urlAuth ;
	private $urlToken;
	private $urlResult;
	private $redirectUri ;
	private $scope ;
	private $state ;

	public function __construct(string $clientID, string $clientSecret,string $urlAuth, string $urlToken, string $urlResult, string $redirectUri = null, string $scope = "basic", string $state ="dsdsfsfds"){
		$this->clientID = $clientID ;
		$this->clientSecret = $clientSecret;
		$this->urlAuth = $urlAuth;
		$this->urlToken = $urlToken ;
		$this->urlResult = $urlResult ;
		$this->redirectUri = $redirectUri ;
		$this->scope = $scope ;
		$this->state = $state ;
	}

	public function getUser(array $params) {

	    var_dump($this->urlToken . "client_id=" . $this->clientID
            . "&client_secret=" . $this->clientSecret
            . "&" . http_build_query($params));
		$result = file_get_contents(
			$this->urlToken . "client_id=" . $this->clientID
			. "&client_secret=" . $this->clientSecret
			. "&" . http_build_query($params)
		);

		echo($result);
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

		$result = file_get_contents($this->urlResult, false, $context);

		$user = json_decode($result,true) ; 
		var_dump($user) ;
	}

	public function getUrlAuth() {
		return $this->urlAuth ;
	}

	public function getClientId() {
		return $this->clientID ;
	}

	public function getRedirectUri() {
	    return '&redirect_uri=' . $this->redirectUri ;
    }

    public function getScope() {
	    return '&scope=' . $this->scope ;
    }

    public function getState() {
	    return '&state=' . $this->state ;
    }
}
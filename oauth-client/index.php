<?php

require "ProviderInit.php" ;

$providerArray = [
    "basic"=>
        [
            "clientID"=>"client_606c5bfe886e14.91787997",
            "clientSecret"=>"2ce690b11c94aca36d9ec493d9121f9dbd5c96a5",
            "urlAuth"=>"http://localhost:8081/auth?",
            "urlToken"=>"http://oauth-server:8081/token?",
            "urlResult"=>"http://oauth-server:8081/api",
            "redirectUri"=>null
        ],
    "discord"=>
        [
            "clientID"=>"866742283759648788",
            "clientSecret"=>"4KzIHbZBbQoDiLZD_ZABNKqe4LERzP5p",
            "urlAuth"=>"https://discord.com/api/oauth2/authorize?",
            "urlToken"=>"https://discord.com/api/oauth2/token?",
            "urlResult"=>"https://discord.com/oauth2/@me?" ,
            "redirectUri"=>null
        ]
] ;


$providers = init($providerArray) ;

$route = strtok($_SERVER['REQUEST_URI'], '?');
switch ($route) {
    case '/auth-code':
        // Gérer le workflow "authorization_code" jusqu'à afficher les données utilisateurs
        echo '<h1>Login with Auth-Code</h1>';
      /*  echo "<a href='http://localhost:8081/auth?"
            . "response_type=code"
            . "&client_id=" . CLIENT_ID
            . "&scope=basic&state=dsdsfsfds'>Login with oauth-server</a>";
        echo "<a href='https://facebook.com/v2.10/dialog/oauth?"
            . "response_type=code"
            . "&client_id=" . FBCLIENT_ID
            . "&redirect_uri=https://localhost/fb-success"
            . "&scope=email&state=dsdsfsfds'>Login with facebook</a>";*/
        foreach ($providers as $providerName => $provider) {

            echo "<a href=" . $provider->getUrlAuth() . "response_type=code"
            . "&client_id=" . $provider->getClientId()
            . "&redirect_uri=" .$provider->getRedirectUri()
            . "&scope=basic&state=dsdsfsfds'>Login with " . $providerName . "</a><br>" ;
        }
        break;
    case '/success':
        // GET CODE
        ["code" => $code, "state" => $state] = $_GET;
        // ECHANGE CODE => TOKEN
        getUser([
            "grant_type" => "authorization_code",
            "code" => $code
        ]);
        break;
    case '/fb-success':
        // GET CODE
        ["code" => $code, "state" => $state] = $_GET;
        // ECHANGE CODE => TOKEN
        getFbUser([
            "grant_type" => "authorization_code",
            "code" => $code
        ]);
        break;
    case '/error':
        ["state" => $state] = $_GET;
        echo "Auth request with state {$state} has been declined";
        break;
    case '/password':
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            ['username' => $username, 'password' => $password] = $_POST;
            getUser([
                "grant_type" => "password",
                "username" => $username,
                "password" => $password,
            ]);
        } else {
            // Gérer le workflow "password" jusqu'à afficher les données utilisateurs
            echo "<form method='post'>";
            echo "Username <input name='username'>";
            echo "Password <input name='password'>";
            echo "<input type='submit' value='Submit'>";
            echo "</form>";
        }
        break;
    default:
        echo 'not_found';
        break;
}




//$sdk = new OauthSDK([
//    "facebook" => [
//        "app_id",
//        "app_secret"
//    ],
//    "oauth-server" => [
//        "app_id",
//        "app_secret"
//    ]
//    ]);
//
//$sdk->getLinks() => [
//    "facebook" => "https://",
//    "oauth-server" => "http://localhost:8081/auth"
//]
//
//$token = $sdk->handleCallback();
//$sdk->getUser();
// return [
//     "firstname"=>$facebookUSer["firstname"],
//     "lastname"=>$facebookUSer["lastname"],
//     "email"=>$facebookUSer["email"],
//     "phone" =>$facebookUSer["phone_number"]
// ];

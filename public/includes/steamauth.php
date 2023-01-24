<?php
date_default_timezone_set('Europe/Moscow');
ob_start(); // ???

if(!isset($_SESSION)){
	session_start();
}

if (isset($_GET['login-vk'])) {
	require './config.php';

	$oauth_params = [
	'client_id' => $auth['client-id'],
	'redirect_uri' => $auth['homepage'] + basename($_SERVER["SCRIPT_FILENAME"], '.php'),
	'response_type' => 'code',
	'display' => 'page',
	'scope' => implode(',', $auth['vk-premissions'])
	];
	header('Location: https:/oauth.vk.com/authorize?' . http_build_query($oauth_params));

}

if (isset($_GET['login-steam'])){
	require 'openid.php';
	try {
		require './config.php';
		$openid = new LightOpenID($auth['homepage']);
		
		if(!$openid->mode)
		{
			$openid->identity = 'http://steamcommunity.com/openid';
			header('Location: ' . $openid->authUrl());
		}
		elseif ($openid->mode != 'cancel' && $openid->validate())
		{
			$id = $openid->identity;
			$ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
			preg_match($ptn, $id, $matches);
			
			$_SESSION['uid'] = $matches[1];

			$url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$auth['apikey-steam']."&steamids=".$matches[1];
            $json_object = file_get_contents($url);
            $json_decoded = json_decode($json_object);
			$_SESSION['username'] = $json_decoded->response->players[0]->personaname;
			$_SESSION['avatar'] = $json_decoded->response->players[0]->avatar;
			header('Location: '.$auth['homepage']);
			exit;
		}
	} catch(ErrorException $e) {
		echo $e->getMessage();
	}
}

if (isset($_GET['logout'])){
	require './config.php';
	session_unset();
	session_destroy();
	header('Location: '.$auth['logoutpage']);
	exit;
}

?>

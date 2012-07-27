<?php

/* Session handling */
if(!$shead)
{
	require_once "dbc.php";
	require_once "classes/user.php";
	require_once "classes/openid.php";
	
	session_start();

	if($_GET[logout])
	{
		session_destroy();
		session_start();
	}

	$currentUser = User::getInstance($_SESSION['userid']);
	
	if (!$currentUser)
	{
		try {
			$openid = new LightOpenID('skrivihop.net' );
			if(!$openid->mode) {
				if(isset($_POST['openid_identifier'])) {
					$openid->identity = $_POST['openid_identifier'];
					$openid->optional = array('contact/email', 'namePerson', 'namePerson/friendly');
					header('Location: ' . $openid->authUrl());
				}
			} elseif($openid->mode == 'cancel') {
				$errorMessage = '<p>Inloggning avbruten</p>';
			} elseif(!$openid->validate()) {
				$errorMessage = '<p>Felaktiga inloggningsuppgifter</p>';
			} else {
				// Successful authentication
				session_regenerate_id();
				$identityUrl = $openid->identity;
				$user = User::fromOpenID($identityUrl);
				
				// User already exists, set the user ID and return to where the login was intiated
				if ($user)
				{
					$_SESSION['userid'] = $user->id;
					header('Location: ' . $_SERVER['PHP_SELF']);
				}
				// Unknown user, redirect to the signup page
				else 
				{
					// Set attributes returned from the OpenID call
					$_SESSION['openid_identity'] = $openid->identity;
					$_SESSION['openid_attributes'] = $openid->getAttributes();
					header('Location: signup.php');
				}
			}
		} catch(ErrorException $e) {
			$errorMessage = $e->getMessage();
		}
	}
	
	date_default_timezone_set('Europe/Stockholm');

	// include functions
	include "functions/general.php";

	// include standards
	include "functions/logedin.php";
// include "functions/latestpost.php";

/*
	if($_SESSION[loggedin]!=md5('N0H0tD0gBuns')){
		//session_destroy();
	}
*/

}
// set heads true so it will not repeate itself
$shead = true;
?>
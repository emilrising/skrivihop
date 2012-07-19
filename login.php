<?php
//THIS FILE: Checks login information, creates session and directs to start.php
include "functions/validatemail.php";
	//Start session
	session_start();
date_default_timezone_set('Europe/Stockholm');
		
	//Array to store validation errors
	$error = array();
	
	//Validation error flag
	$errorflag = false;

// only reachable by POST.
	if ($_SERVER["REQUEST_METHOD"] <> "POST"){
		$errormsg_arr[] = 'Sluta gör så. Logga via formuläret istället.';
		$errorflag = true;
	}	
	
	
	//Connect to mysql server
	require("dbc.php");
	
	if($_POST['npw_email']){
		include "functions/newpassword.php";
		exit();
	}
	
	//Define $username and $password
	$username = mysql_real_escape_string($_REQUEST['username']);
	$password = mysql_real_escape_string($_REQUEST['password']); 
	
	//Input Validations
	if($username == '' OR check_email($username, TRUE) == FALSE) {
		$errormsg_arr[] = 'Ditt användarnamn skall vara din e-postadress.';
		$errorflag = true;
	}
	if($password == '') {
		$errormsg_arr[] = 'Du skrev inget lösenord, det är kontraproduktivt.';
		$errorflag = true;
	}


	$requirePassword = "AND password='".md5($password)."'";
	
	
	//If there are input validations, redirect back to the login form
	if($errorflag) {
		 
		include "index.php";

			// Finally, destroy the session and exit.
			session_destroy();
			exit();
	}
	
	//Create query
	
	
	$qry="SELECT * FROM users WHERE users.username = '".$username."' ".$requirePassword." ";
	$result=mysql_query($qry);
	
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful - Generate SESSION[user] 
			
			$user = mysql_fetch_assoc($result);
			if($user['active'] == 'yes'){
					//CREATE SESSION

	
				
					$_SESSION['logedin'] = md5('N0H0tD0gBuns'); //Secure session
					$_SESSION['userid'] = $user['id'];
					$_SESSION['username'] = $user['username'];
					$_SESSION['lastlogin'] = $user['lastlogin'];
					
					
					$sql_log = "UPDATE `users` SET `lastlogin` = '".date('Y-m-d H:i:s')."', `lastloginfrom` = '".$_SERVER['REMOTE_ADDR']."' WHERE `users`.`id` = '".$user['id']."' LIMIT 1 ;";
					mysql_query($sql_log);

	
			//CHECK defaults and fileloads.
				// set cookie
				setcookie(md5("usern"), base64_encode($username), time()+(7*24*60*60));
			
				?>
					<script>
						parent.location="player.php?id=<?=$user['id']?>";
					</script>
				<?php
				exit();
			}
			else{
				$errormsg_arr[] = 'Ditt konto är inte aktiverat, kolla din mail.';
		 		$errorflag = true;
				
						include "index.php";
			

					exit();
			}
		}else {
			$sql = "SELECT * FROM users WHERE users.username = '".$username."'";
			$res = mysql_query($sql);
			$num = mysql_num_rows($res);
				if($num < 1){
						$errorflag = TRUE;
						$create_new_user['username'] = $username;
						$create_new_user['password'] = $password;
						include "index.php";					

					exit();
				}else{
					//Login failed - password and username did not match - goto index.php
					if(mysql_num_rows($result) < 1 ) {
					$errormsg_arr[] = 'Fel lösenord, kunde inte logga in med användarnamn: <i>'.$username.'</i>.';
					$errormsg_arr[] = 'Om du har glömt ditt lösenord kan du <a href="#" onclick="$(\'#newpassword\').load(\'functions/newpassword.php?newpasswordplease=true&username='.$username.'\');">få ett nytt</a>
					<div id="newpassword">fbffb</div>';
		 			$errorflag = true;
				
						include "index.php";
			

					exit();
				}
				}

			}
	}else {
		session_destroy();
		die("Login failed");
	}
?>
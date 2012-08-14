<?php
include "i/shead.php";

/* TODO: Replace with SQL stored procedure?
 * TODO: Replace with static function in User class?
 */
function createUser($name, $openId)
{
	global $pdo;
	
	try
	{
		$pdo->beginTransaction();

		$alreadyExistsQuery = $pdo->prepare('SELECT COUNT(*) FROM users WHERE name = :Name');
		$alreadyExistsQuery->execute(array(':Name' => $_POST['name']));
			
		if ($alreadyExistsQuery->fetchColumn(0) > 0)
		{
			throw new Exception("Det finns redan en användare med det här namnet", 1);
		}

		$insertUser = $pdo->prepare("INSERT INTO users (
				username,
				name,
				lastloginfrom,
				createddate,
				lastlogin
			)
			VALUES (
				:Email, :Name, :Ip, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
			)");
			
		if (!$insertUser->execute(array(':Email' => $email, ':Name' => $name, ':Ip' => $_SERVER['REMOTE_ADDR'])))
		{
			$error = $insertUser->errorInfo();
			throw new Exception($error[2], $error[0]); 
		}

		$fetchUser = $pdo->prepare("SELECT * FROM users WHERE name = :Name");
		if (!$fetchUser->execute(array(':Name' => $name)))
		{
			$error = $insertUser->errorInfo();
			throw new Exception($error[2], $error[0]); 			
		}
		$fetchUser->setFetchMode(PDO::FETCH_CLASS, User);
		$newUser = $fetchUser->fetch();

		if (!$newUser)
		{
			throw new Exception('Kunde inte hämta tillbaka ny användare', 1);
		}
			
		$insertOpenID = $pdo->prepare("INSERT INTO openid_mapping (userid, url) VALUES (:Id, :Url)");
		$insertOpenID->execute(array(':Id' => $newUser->id, ':Url' => $openId));

		$pdo->commit();
		return $newUser;
	}
	catch (exception $ex) 
	{
		$pdo->rollBack();
		throw $ex;
	}	
}

if ($currentUser || !isset($_SESSION['openid_identity']))
{
	header('Location: index.php');
}
else
{
	$errorMessage = '';
	
	if ($_POST)
	{
		try {
			$newUser = createUser($_POST['name'], $_SESSION['openid_identity']);
			
			if ($newUser)
			{
				// Recycle session
				session_destroy();
				session_start();
				session_regenerate_id();
				$_SESSION['userid'] = $newUser->id;
				header('Location: index.php');
				exit();
			}
			else 
			{
				$errorMessage = 'Hm, något annat gick fel. Försök igen?';
			}
		}
		catch (exception $ex) 
		{
			$errorMessage = $ex->getMessage();
		}
	}

	include "i/head.php";
	include "i/header.php";
	
	if ($_POST['name']) {
		$name = $_POST['name'];
	} elseif ($_SESSION['openid_attributes']['namePerson/Friendly'])
	{
		$name = $_SESSION['openid_attributes']['namePerson/Friendly'];
	}
	elseif ($_SESSION['openid_attributes']['namePerson'])
	{
		$name = $_SESSION['openid_attributes']['namePerson'];
	} 
?>
	<img src="images/logosmallbeta.png" class="toplogo"> 
	<h2>Registrera författare</h2>
	<p>
		Du har loggat in med OpenID, nu behöver du bara knyta ihop din inloggning med en Författare:
	</p>
	<form action="" method="post">
		<p>
			<label for="name">Namn</label><input type=text name="name" value="<?= $name ?>"><br>
			<input type="submit" value="Fortsätt">
		</p>
	</form>
	<div class="error"><?= $errorMessage ?></div>
	<p>
		<i>OpenID <?= $_SESSION['openid_identity'] ?></i>
	</p>
<?
	
	include "i/footer.php";
	include "i/foot.php";
} 
?>
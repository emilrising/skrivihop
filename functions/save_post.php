<?php
include "shead.php";


if(logged_in()){
	if($_POST){


		if($_POST['type'] == 'write'){
			$sql = "INSERT INTO `post` 
					( 
					`id` , 
					`chronicleid` , 
					`body` , 
					`createddate` , 
					`editeddate` , 
					`createdby` , 
					`active` 
					)
					VALUES 
					(
					NULL , 
					'".$_POST['chronicle']."', 
					'".insert_ready($_POST['body'])."', 
					'".date('Y-m-d H:i:s')."', 
					NULL , 
					'".$_SESSION['userid']."', 
					'yes'
					);
			";
			mysql_query($sql);
		}
		elseif($_POST['type'] == 'comment'){
					$sql = "INSERT INTO `comments` 
							(  
							`chronicleid` , 
							`body` , 
							`createddate` , 
							`editeddate` , 
							`createdby` , 
							`postid` , 
							`active` 
							)
							VALUES (
							'".$_POST['chronicle']."', 
							'".insert_ready($_POST['body'])."', 
							'".date('Y-m-d H:i:s')."' , 
							NULL , 
							'".$_SESSION['userid']."', 
							'".$_POST['post']."', 
							'yes'
							);
							";
			mysql_query($sql);
		}
		elseif($_POST['type'] == 'block'){
			
					$sql = "INSERT INTO `comments` 
							(  
							`chronicleid` , 
							`body` , 
							`createddate` , 
							`editeddate` , 
							`createdby` , 
							`postid` , 
							`active` 
							)
							VALUES (
							'".$_POST['chronicle']."', 
							'ANMÄLAN: ".insert_ready($_POST['body'])."', 
							'".date('Y-m-d H:i:s')."' , 
							NULL , 
							'".$_SESSION['userid']."', 
							'".$_POST['post']."', 
							'yes'
							);
							";
				mysql_query($sql);
					$sql2 ="UPDATE `post` SET `editeddate` = '".date('Y-m-d H:i:s')."' ,
							`active` = 'blocked' 
							WHERE 
							`post`.`id` = '".$_POST['post']."' LIMIT 1 ;
							";
				mysql_query($sql2);
		}
		elseif($_POST['type'] == 'newchronicle'){
					$sql = "INSERT INTO `chronicles` 
							( 
							`name` , 
							`shortdesc` , 
							`longdesc` , 
							`createdby` , 
							`createddate` 
							)
							VALUES (
							'".insert_ready($_POST['name'])."', 
							'".insert_ready($_POST['shortdesc'])."', 
							'".insert_ready($_POST['longdesc'])."', 
							'".$_SESSION['userid']."',
							'".date('Y-m-d H:i:s')."'
							);
							";
				mysql_query($sql);

		}
		elseif($_POST['type'] == 'editchronicle'){
			//Save Categories
			$categories = explode(',',$_POST['categories']);

			foreach($categories as $key => $category){
				if(strlen($category)> 2){
					$sql = "SELECT `id` FROM `categories` WHERE name = '".trim($category)."'";
					$res = mysql_query($sql);
					$categoryid = mysql_fetch_assoc($res);

					$num = mysql_num_rows($res);
					if($num > 0){
						$sql1 = "INSERT INTO `categoryrelations` 
								(
								`toid` , 
								`categoryid` ,
								`type`
								)
								VALUES (
								 '".$_POST['chronicle']."', 
								 '".$categoryid['id']."',
								 'chronicle'
								);";
						mysql_query($sql1);
					}
					else{
							//Create new Category
								$sql2 = "INSERT INTO `categories` 
								(
								`name` 
								)
								VALUES (
								 '".insert_ready(trim(ucwords($category)))."'
								);";
						mysql_query($sql2);
							//And add it to this chronicle
								$sql1 = "INSERT INTO `categoryrelations` 
								(
								`toid` , 
								`categoryid` ,
								`type`
								)
								VALUES (
								 '".$_POST['chronicle']."', 
								 '".mysql_insert_id()."',
								 'chronicle'
								);";
						mysql_query($sql1);
					}
				}
			}
					$sql = "UPDATE `chronicles` SET 
							`name` = '".insert_ready($_POST['name'])."',
							`shortdesc` = '".insert_ready($_POST['shortdesc'])."',
							`longdesc` = '".insert_ready($_POST['longdesc'])."' 
							WHERE `chronicles`.`id` = '".$_POST['chronicle']."' 
							LIMIT 1 ;
							";
				mysql_query($sql);

		}
		elseif($_POST['type'] == 'newchar'){
					$sql = "INSERT INTO `characters` 
							( 
							`name` , 
							`longdesc` , 
							`createdby` , 
							`createddate`,
							`active` 
							)
							VALUES (
							'".insert_ready($_POST['name'])."', 
							'".insert_ready($_POST['longdesc'])."', 
							'".$_SESSION['userid']."',
							'".date('Y-m-d H:i:s')."',
							'yes'
							);
							";
				mysql_query($sql);

		}
		elseif($_POST['type'] == 'editplayer'){
					$sql = "UPDATE `users` 
							SET 
							`name` = '".insert_ready($_POST['name'])."',
							`description` = '".insert_ready($_POST['description'])."' ,
							`avatar` = '".insert_ready($_POST['avatar'])."'
							WHERE `users`.`id` = '".$_POST['player']."' LIMIT 1 ;
							";
				mysql_query($sql);

		}
		elseif($_POST['type'] == 'editchar'){
					$sql = "UPDATE `characters` 
							SET 
							`name` = '".insert_ready($_POST['name'])."',
							`longdesc` = '".insert_ready($_POST['longdesc'])."'
							WHERE `characters`.`id` = '".$_POST['char']."' LIMIT 1 ;
							";
				mysql_query($sql);

		}
		elseif($_POST['type'] == 'editpost'){
					$sql = "UPDATE `post` 
							SET 
							`body` = '".insert_ready($_POST['body'])."',
							`editeddate` = '".date('Y-m-d H:i:s')."'
							WHERE `post`.`id` = '".$_POST['post']."' LIMIT 1 ;
							";
				mysql_query($sql);

		}
		elseif($_POST['npw_email']){
			$sql = "SELECT id,username, name FROM users WHERE username = '".mysql_real_escape_string($_POST['npw_email'])."' LIMIT 1";
			$res = mysql_query($sql);
			$num = mysql_num_rows($res);
						
			if($num > 0){
				$rad = mysql_fetch_assoc($res);
   							$sql_activate = "UPDATE `users` SET `active` = 'no'
							WHERE 
							`users`.`id` = '".$rad['id']."' 
							LIMIT 1 ;";
							
			if(mysql_query($sql_activate)){
								// to
				$to  = $rad['username']; 
				
				// subject
				$subject = 'Du har begärt en lösenordsändring på Skrivihop.net';
				
				// message
				$message = '
				<html>
				<head>
				  <title>'.$subject.'</title>
				</head>
				<body style="background-color: #efefec; margin:0; padding: 0;">
				  <div style="width: 100%;	height: 40px;	background-color: #687a79;	text-align: center;"></div>
				  <div style="margin-left: 5%;">
					<p>
					<img src="data:image/png;base64,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" alt="">
					</p>
					<h1 style="color: #3d4746;	font-weight: 100;	margin: 0 auto;">Hej '.$rad['name'].' du kan nu ändra ditt lösenord</h1>
					<p>
					Vi har deaktiverat ditt konto tillfälligt tills du sätter ett nytt lösenord.
					</p>
					<p>
					Klicka på länken här nedanför, där kan du skriva in ett nytt lösenord för ditt konto, går det inte att klicka på den testa att kopiera adressen och klistra in i din webbläsare.
					</p>
					<p>
					<a href="http://skrivihop.net/templates/signup.php?newpassword='.base64_encode($rad['username'].'#:#'.md5('N0H0tD0gBuns')).'">http://skrivihop.net/templates/signup.php?newpassword='.base64_encode($rad['username'].'#:#'.md5('N0H0tD0gBuns')).'</a>
					</p>
					<p>
					Om det av någon anledning inte var du som begärde en ändring av ditt lösenord, eller något annat är fel, hör av dig till ed@skrivihop.net.
					</p>
					</div>
					<div style="width: 100% height: 40px; background-color: #687a79;	text-align: center;">
					<p style="color: #fff; font-size: 10px;">
					Det här mailet skickades till '.$rad['username'].' från Skrivihop.net, mailet är autogenererat och en del av lösenordsåterställnings processen.
					</p>
					</div>
				</html>
				';
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				
				// Additional headers
				$headers .= 'To: '.$rad['name'].' <'.$rad['username'].'>' . "\r\n";
				$headers .= 'From: Skrivihop.net <ed@skrivihop.net>' . "\r\n";
				
				
				// Mail it
				mail($to, $subject, $message, $headers);
				unset($_POST['npw_email']);
				
				$changed_your_pwd = '
						<div class="box info">
							<div class="arrowup">
								<!-- -->
							</div>
						<h2>Vi har skickat mail till: '.$rad['username'].'</h2>
						<p>Vi har tillfälligt deaktiverat ditt konto tills du sätter ett nytt lösenord, kolla din mail, klicka på länken du fått av oss. Där kan du sätta ett nytt lösenord.<br />
						Ditt konto kommer fungera tills du loggar ut.</p>
						</div>';
				

				

			}
			}
		}
	}
	
	
}




?>
<?php

if($currentUser && $_POST)
{
	switch ($_POST['type'])
	{
		case 'write':
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
			break;

		case 'comment':
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
			break;
			
		case 'block':
			
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
			break;
			
		case 'newchronicle':
			$stmt = $pdo->prepare("INSERT INTO `chronicles` 
						(
							`name` , 
							`shortdesc` , 
							`longdesc` , 
							`createdby` , 
							`createddate` 
						)
						VALUES (
							:Name, 
							:Short, 
							:Long, 
							:CreatedBy,
							CURRENT_TIMESTAMP
							);
							");
				$stmt->execute(array(':Name' => $_POST['name'], ':Short' => $_POST['shortdesc'], ':Long' => $_POST['longdesc'], ':CreatedBy' => $currentUser->id));
			break;
			
		case 'editchronicle':
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

		break;
		
		case 'newchar':
			$stmt = $pdo->prepare("INSERT INTO characters (
				`name` , 
				`longdesc` , 
				`createdby` , 
				`createddate`,
				`active` 
			)
			VALUES (
				:Name, :Description, :CreatedBy, CURRENT_TIMESTAMP, 'yes'
			)");
			
			if(!$stmt->execute(array(':Name' => $_POST['name'], ':Description' => $_POST['longdesc'], ':CreatedBy' => $currentUser->id)))
			{
				$error = $stmt->errorInfo();
				throw new Exception($error[2], $error[0]); 
			}
			
			break;
			
		case 'editplayer':
			$stmt = $pdo->prepare("UPDATE users SET name = :name, description = :description, avatar = :avatar WHERE id = :id");
			$stmt->execute(array(':id' => $currentPlayer->id, ':name' => $_POST['name'], ':description' => $_POST['description'], ':avatar' => $_POST['avatar']));		
			break;
			
		case 'editchar':
					$sql = "UPDATE `characters` 
							SET 
							`name` = '".insert_ready($_POST['name'])."',
							`longdesc` = '".insert_ready($_POST['longdesc'])."'
							WHERE `characters`.`id` = '".$_POST['char']."' LIMIT 1 ;
							";
				mysql_query($sql);
			break;
		case 'editpost':
					$sql = "UPDATE `post` 
							SET 
							`body` = '".insert_ready($_POST['body'])."',
							`editeddate` = '".date('Y-m-d H:i:s')."'
							WHERE `post`.`id` = '".$_POST['post']."' LIMIT 1 ;
							";
				mysql_query($sql);
			break;
	}
}
?>
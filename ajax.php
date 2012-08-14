<?

require_once "i/shead.php";
require_once "functions/show_info_in_chronicle.php";
require_once "functions/write.php";

if ($currentUser)
{
	switch ($_GET['action'])
	{
		case "hidecomments":
			$_SESSION['showcomments'] = FALSE;
			break;
			
		case "fetchcomments":
			$_SESSION['showcomments'] = TRUE;
			list($id) = sscanf($_GET['id'], "comments_%d");
			show_comments($id);
			break;
			
		case "hidewriter":
			$_SESSION['showwriter'] = FALSE;
			break;
			
		case "showwriter":
			$_SESSION['showwriter'] = TRUE;
			list($id) = sscanf($_GET['id'], "writer_%d");
			show_writer($id);
			break;
	
		case "newcharacter":
			do_new_char_simple();
			break;
			
		case "newchronicle":
			do_new_chronicle_simple();
			break;
			
		case "editpost":
			edit_post_simple($_GET['id']);
			break;
		
		case "commentpost":
			comment_post_simple($_GET['id']);
			break;
			
		case "blockpost":
			block_post_simple($_GET['id']);
			break;
	}
}
?>
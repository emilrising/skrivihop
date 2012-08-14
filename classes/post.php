<?

require_once "classes/chronicle.php";
require_once "classes/user.php";
require_once "classes/comment.php";

class Post
{
	public $chronicleid;
	public $createdby;
	public $createddate;
	public $editeddate;
	public $body;
	public $active;
	
	public function creator()
	{
		return User::getInstance($this->createdby);
	}
	
	public function chronicle()
	{
		return Chronicle::getInstance($this->chronicleid);
	}
	
	public function countComments()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT COUNT(*) FROM `comments` WHERE `postid` = :id");
		$stmt->execute(array('id' => $this->id));
		return $stmt->fetchColumn(0);
	}
	
	public function enumerateComments()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `comments` WHERE `postid` = :id");
		$stmt->execute(array('id' => $this->id));
		$stmt->setFetchMode(PDO::FETCH_INTO, new Comment);
		return $stmt;
	}
	
	public static function latest()
	{
		global $pdo;
		
		$stmt = $pdo->query("SELECT * FROM `post` WHERE post.Active = 'yes' ORDER BY `CreatedDate` DESC LIMIT 1");
		$stmt->setFetchMode(PDO::FETCH_CLASS, Post);
		return $stmt->fetch();
	}
	
	public static function getInstance($id)
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `post` WHERE id = :Id");
		$stmt->execute(array(':Id' => $id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, Post);
		return $stmt->fetch();
	}
}

?>
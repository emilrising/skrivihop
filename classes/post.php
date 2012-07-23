<?

require_once "classes/chronicle.php";
require_once "classes/user.php";

class Post
{
	public $chronicleid;
	public $createdby;
	public $createddate;
	public $editeddate;
	public $body;
	public $active;
	
	public function user()
	{
		return User::getInstance($this->createdby);
	}
	
	public function chronicle()
	{
		return Chronicle::getInstance($this->chronicleid);
	}
	
	public static function latest()
	{
		global $pdo;
		
		$stmt = $pdo->query("SELECT * FROM `post` WHERE post.Active = 'yes' ORDER BY `CreatedDate` DESC LIMIT 1");
		$stmt->setFetchMode(PDO::FETCH_CLASS, Post);
		return $stmt->fetch();
	}
}

?>
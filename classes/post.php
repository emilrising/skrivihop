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
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `users` WHERE id = :id");
		$stmt->execute(array(':id' => (int) $this->createdby));
		$stmt->setFetchMode(PDO::FETCH_CLASS, User);
		return $stmt->fetch();
	}
	
	public function chronicle()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `chronicles` WHERE id = :id");
		$stmt->execute(array(':id' => $this->chronicleid));
		$stmt->setFetchMode(PDO::FETCH_CLASS, Chronicle);
		return $stmt->fetch();
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
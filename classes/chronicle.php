<?

require_once "classes/category.php";
require_once "classes/user.php";

class Chronicle
{
	public $id;
	public $name;
	public $createdby;
	public $shortdesc;
	public $createddate;
	public $longdesc;
	
	public function url()
	{
		return "<a href=\"chronicle.php?id=$this->id\">$this->name</a>";
	}
	
	public function countPosts()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT COUNT(*) FROM `post` WHERE `chronicleid` = :id");
		$stmt->execute(array('id' => $this->id));
		return $stmt->fetchColumn(0);
	}
	
	public function countComments() { 
		global $pdo;

		$stmt = $pdo->prepare("SELECT COUNT(*) FROM `comments` WHERE `chronicleid` = :id");
		$stmt->execute(array('id' => $this->id));
		return $stmt->fetchColumn(0);
 	}

	public function enumerateCategories()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT categories.id as id, name FROM `categories` JOIN `categoryrelations` ON categoryid = categories.id WHERE toid = :id");
		$stmt->execute(array('id' => $this->id));
		$stmt->setFetchMode(PDO::FETCH_INTO, new Category);
		
		return $stmt;
	}
	
	public function creator()
	{
		return User::getInstance($this->createdby);	
	}
	
	public function last_post()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `post` WHERE post.Active = 'yes' AND `chronicleid` = :id ORDER BY `CreatedDate` DESC LIMIT 1");
		$stmt->execute(array('id' => $this->id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, Post);
		return $stmt->fetch();
	}
	
	public static function getInstance($id)
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `chronicles` WHERE id = :id");
		$stmt->execute(array(':id' => $id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, Chronicle);
		return $stmt->fetch();
	}
}

?>
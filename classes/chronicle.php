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
	
	public function total_posts()
	{
		global $pdo;
		static $total_posts;
		
//		if (!$total_posts)
//		{
			$stmt = $pdo->prepare("SELECT COUNT(*) FROM `post` WHERE `chronicleid` = :id");
			$stmt->execute(array('id' => $this->id));
			$total_posts = $stmt->fetchColumn(0);
//		}
		
		return $total_posts;
	}
	
	public function total_comments() { 
		global $pdo;
		static $total_comments;
		
//		if (!$total_comments)
//		{
			$stmt = $pdo->prepare("SELECT COUNT(*) FROM `comments` WHERE `chronicleid` = :id");
			$stmt->execute(array('id' => $this->id));
			$total_comments = $stmt->fetchColumn(0);
//		}
		
		return $total_comments;
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
		return User::build_object($this->createdby);	
	}
	
	public function last_post()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `post` WHERE post.Active = 'yes' AND `chronicleid` = :id ORDER BY `CreatedDate` DESC LIMIT 1");
		$stmt->execute(array('id' => $this->id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, Post);
		return $stmt->fetch();
	}
	
	public static function build_object($id)
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `chronicles` WHERE id = :id");
		$stmt->execute(array(':id' => $id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, Chronicle);
		return $stmt->fetch();
	}
}

?>
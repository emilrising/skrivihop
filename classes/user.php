<?

require_once "dbc.php";
require_once "classes/post.php";
require_once "classes/character.php";

class User
{
	public $id;
	public $name;
	public $lastlogin;
	public $avatar;
	public $description;
	
	public function url()
	{
		return "<a href=\"player.php?id=$this->id\">$this->name</a>";
	}
	
	public function formatted_description()
	{
		$formatted_description = htmlentities($this->description, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
		$formatted_description = nl2br($formatted_description);
		
		// Replace web addresses with actual links
		$formatted_description = preg_replace("/(http:\/\/[^\s<]+)/","<a href='$1' target='_blank'>$1</a>",$formatted_description);
		$formatted_description = preg_replace("/(www\.[^\s<]+)/","<a href='http://$1' target='_blank'>$1</a>",$formatted_description);
		$formatted_description = preg_replace("/(https:\/\/[^\s<]+)/","<a href='$1' target='_blank'>$1</a>",$formatted_description);
		
		// Replace strings of the format 'name@domain' with mailto links
		$formatted_description = preg_replace("/([^\s>]+@[^\s<]+)/", "<a href='mailto:$1'>$1</a>", $formatted_description);
		
		// Replace strings of the format '@name' with Twitter links
	    $formatted_description = preg_replace("/(\s@)([^\s<]+)/","<a href='https://twitter.com/#!/$2' target='_blank'>$1$2</a>",$formatted_description);		
		
	    return $formatted_description;
	}
	
	public function latestpost()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `post` WHERE post.Active = 'yes' AND `CreatedBy` = :Id ORDER BY `CreatedDate` DESC LIMIT 1");
		$stmt->execute(array(':Id' => $this->id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, Post);
		return $stmt->fetch();
	}
	
	public function enumerateCharacters()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `characters` WHERE `createdby` = :id");
		$stmt->execute(array(':id' => $this->id));
		$stmt->setFetchMode(PDO::FETCH_INTO, new Character);
		
		return $stmt;	
	}
	
	public function enumerateChronicles()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `chronicles` WHERE `createdby` = :id");
		$stmt->execute(array(':id' => $this->id));
		$stmt->setFetchMode(PDO::FETCH_INTO, new Chronicle);
		return $stmt;
	}
	
	public function update()
	{
		global $pdo;
		
		$stmt = $pdo->prepare("UPDATE users SET name = :name, description = :description, avatar = :avatar WHERE id = :id");
		return $stmt->execute(array(':id' => $this->id, ':name' => $this->name, ':description' => $this->description, ':avatar' => $this->avatar));		
	}
	
	public function isCurrentUser()
	{
		global $currentUser;
		
		return $currentUser && $currentUser->id == $this->id;
	}
	
	public static function getInstance($id)
	{
		global $pdo;

		$stmt = $pdo->prepare("SELECT * FROM `users` WHERE id = :id");
		$stmt->execute(array(':id' => $id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, User);
		return $stmt->fetch();
	}
	
	public static function fromOpenID($identityUrl)
	{
		global $pdo;

		$stmt = $pdo->prepare("SELECT * FROM users JOIN openid_mapping ON users.id = userid WHERE url = :Url");
		$stmt->execute(array(':Url' => $identityUrl));
		$stmt->setFetchMode(PDO::FETCH_CLASS, User);
		return $stmt->fetch();
	}
}

?>
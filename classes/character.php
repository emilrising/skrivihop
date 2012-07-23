<?

require_once("classes/user.php");

class Character
{
	public $id;
	public $name;
	public $longdesc;
	public $createdby;
	public $createddate;
	
	public function url()
	{
		return "<a href=\"character.php?id=$this->id\">$this->name</a>";
	}
	
	public function creator()
	{
		return User::getInstance($this->createdby);
	}
	
	public static function getInstance($id)
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `characters` WHERE id = :id");
		$stmt->execute(array(':id' => $id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, Character);
		return $stmt->fetch();
	}
	
}

?>
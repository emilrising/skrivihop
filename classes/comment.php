<?

class Comment
{
	public $id;
	public $chronicleid;
	public $body;
	public $createddate;
	public $editeddate;
	public $createdby;
	public $postid;
	
	public function creator()
	{
		return User::getInstance($this->createdby);
	}
	
	public static function getInstance($id)
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT * FROM `comments` WHERE id = :id");
		$stmt->execute(array(':id' => $id));
		$stmt->setFetchMode(PDO::FETCH_CLASS, Comment);
		return $stmt->fetch();
	}
	
}

?>
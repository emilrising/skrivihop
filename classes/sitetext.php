<?

class SiteText 
{
	public $heading;
	public $text;
	
	public static function getInstance($name)
	{
		global $pdo;
		static $stmt;
		
		if (!$stmt)
		{
			$stmt = $pdo->prepare("SELECT * FROM sitetexts WHERE name = :Name");
			$stmt->setFetchMode(PDO::FETCH_INTO, new SiteText);
		}
		
		$stmt->execute(array(":Name" => $name));
		return $stmt->fetch();
	}
}

?>
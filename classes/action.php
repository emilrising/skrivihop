<?php

class Action
{	
	const NewCharacter = 1;
	const NewChronicle = 2;
	
	public static function CreateActionLink($type)
	{
		$id = "unknown";
		$text = "Unknown Action";
		
		switch ($type)
		{
			case Action::NewCharacter:
				$id = 'do_new_char';
				$text = 'Ny Karaktär';
				break;
				
			case Action::NewChronicle:
				$id = 'do_new_chronicle';
				$text = 'Ny Krönika';
				break;
		}
		
		return "<a id=\"$id\">$text</a>";
	}
}

?>
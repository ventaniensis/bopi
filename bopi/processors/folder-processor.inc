<?php

class FolderProcessor
{
	var $pattern;
	
	function FolderProcessor($f_pattern)
	{
		$this->pattern = $f_pattern;
	}	
	
	function traverse_folder($folder,$function)
	{
		$files = scandir($folder);
		foreach($files as $file)
		{
			if (strpos($file,$this->pattern))
			{
				$function($folder,$file);				
			}
		}
	}
}// End of class

?>
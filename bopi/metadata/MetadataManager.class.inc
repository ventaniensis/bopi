<?php

/**
 * Filename
 * 
 * @author davidreyblanco
 *
 */
class MetadataManager
{
	var $metadata_filename;
	var $metadata;
	
	function MetadataManager($file_name) 
	{
		$this->metadata_filename = $file_name;
		$this->parse_file();
	}	
	
	/**
	 * Parse metadata filename
	 */
	function parse_file()
	{
		$dictionary = file_get_contents($this->metadata_filename);
		$rules = explode("\n",$dictionary);
		$result = array();		
		foreach($rules as $rule)
		{
			$rule = trim($rule);
		
			if ($rule !== '' && $rule[0] !== '#' || trim($rule) === '')
			{
				if ($this->verbose) print('	Processing rule: '.$rule."#\n");
		
				$parts = explode('=',$rule);
				$parts[1] = explode(',',$parts[1]);
		
				$left_part = explode('.',$parts[0]);
				$namespace = $left_part[0];
				$block = $left_part[1];
				if (trim($block) !== '')
				{
					$namespace = $left_part[0];
		
					if (!array_key_exists($namespace,$result))
					{
						$result[$namespace] = array();
					}
					
					$table = $left_part[1];
					
					$result[$namespace][$table] = array();
							
					for($i = 2; $i < count($parts[1]); $i++)
					{
						if ($parts[1][$i][0] === '$')
						{
							$result[$namespace][$table][substr($parts[1][$i],1)] = 'M';
						}
						else 
						{
							$result[$namespace][$table][$parts[1][$i]] = 'S';
						}
					}
				}
				}
				}
		$this->metadata = $result;
	}
	
	function is_multiple($namespace,$table,$field)
	{
		return $this->metadata[$namespace][$table][$field] === 'M';
	}
}
?>
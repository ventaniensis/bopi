<?php

define('L1_ESCAPED','@L1@');
define('L2_ESCAPED','@L2@');

/**
 * This class dump the contents of a file in a CSV format
 * 
 * @author davidreyblanco
 *
 */
class CSVDumper
{
	var $separator = ';';
	var $separator_2 = '#';
	
	function CSVDumper($sep = ';',$sep_2 = '#')
	{
		$this->separator = $sep;	
		$this->separator_2 = $sep_2;		
	}
	
	function escape_characters($value)
	{
		$value = str_replace("\n", " ", $value);
		$value = str_replace($this->separator, L1_ESCAPED, $value);	
		$value = str_replace($this->separator_2, L2_ESCAPED, $value);
		return $value;
	}
	
	function serialize_value($value)
	{
		if (is_array($value))
		{
			//print_r($value);
			$result = '';
			foreach($value as $item)
			{
				if ($i > 0) 
				{
					$result .= $this->separator_2;
				}
				$result .= $this->escape_characters($item);
				$i++;
			}
		}	
		else 
		{
			$result = $this->escape_characters($value);
		}
		
		return $result;
	}
	
	function dump_contents($year,$month,$day,$section,$subsection,$data,$dump_header = true)
	{
		$record_count = 0;	
		if (!is_array($data) || !is_array($data[$section]) || !is_array($data[$section][$subsection]) || count($data[$section][$subsection]) == 0 || !is_array($data[$section][$subsection][0]))
		{
			return;
		}
//		print_r($data[$section][$subsection]);
		$keys = array_keys($data[$section][$subsection][0]);
		if ($dump_header)
		{
			print('YEAR'.$this->separator.'MONTH'.$this->separator.'DAY');
			foreach($keys as $key)
			{
				print($this->separator);
				print(strtoupper($key));
			}			
			print("\n");
		}
		
		$count = count($data[$section][$subsection]);
		for($i = 0; $i < $count; $i++)
		{
			print($year.$this->separator.$month.$this->separator.$day);
							
			foreach($keys as $key)
			{
				print($this->separator);
				$value = $this->serialize_value($data[$section][$subsection][$i][$key]);
				print($value);
			}
			print("\n");
			$record_count++;
		}
		return $record_count;
	}
}

?>
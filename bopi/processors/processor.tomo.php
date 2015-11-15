<?php 
//require_once('util/ImageRemover.inc');

/**
 * 
 * @author davidreyblanco
 *
 */
class BopiProcessor
{
	var $cache_folder = false;
	var $data;
	var $metadata_filename;
	var $file_name;
	var $verbose;

	function BopiProcessor($v_cache_folder,$file_name,$metadata,$vVerbose = false)
	{
		$this->verbose = $vVerbose;
		$this->cache_folder = $v_cache_folder;
		$this->file_name = $file_name;
		$this->metadata_filename = 'metadata/'.$metadata;
	}

	function get_record($xmlDoc,$xpath,$clase_suspenso,$tag_suspenso,$field_list)
	{
		$tbody = $xmlDoc->getElementsByTagName($clase_suspenso)->item(0);
		$consulta = '//tns:'.$tag_suspenso;
		$entradas = $xpath->query($consulta, $tbody);
	
		$result = array();
		foreach ($entradas as $entrada)
		{
			$record = array();
			foreach($field_list as $field)
			{
				if ($field[0] === '$')
				{
					// Multivalue
					$field_name = substr($field, 1);
					$record[$field_name] = array();
					foreach ($entrada->getElementsByTagName($field_name) as $item)
					{
						array_push($record[$field_name],$item->nodeValue);					
					}
				}
				else
				{
					$record[$field] = $entrada->getElementsByTagName($field)->item(0)->nodeValue;
				}
			}
			array_push($result,$record);
		}
		return $result;
	}
	
	
	// http://www.oepm.es/robots.txt
	function process($year,$month,$day)
	{
		if ($year === '' || $month === '' || $day ==='' || intval($year) < 1990 || intval($month) < 1 || intval($month) > 12 || intval($day) < 1 && intval($day) > 31)
		{
			return 'ko';
		}
		$index = 0;
		$yyyymmdd = $year.$month.$date;
		if (!file_exists($this->cache_folder))
		{
			mkdir($this->cache_folder);
			if ($this->verbose)
			{
				print('	Creating folder: '.$this->cache_folder."\n");
			}
		}
		$fname = $this->cache_folder.'/'.$year.$month.$day.'_bopi';
		
		$fname_xml = $fname.'.'.$this->file_name.'.xml';
		
		if (file_exists($fname_xml.'.gz'))
		{
			if ($this->verbose) print('	Unzipping: '.$fname_xml.'.gz'."\n");
			shell_exec('gunzip '.$fname_xml.'.gz');
		}
		
		$result = array();
		$result['status'] = 'ok';
		
		if (file_exists($fname_xml) && filesize($fname_xml) > 0)
		{
			if ($this->verbose) print('	File exists and isnt empty: '.$fname_xml."\n");				
			//ImageRemover::remove_images($fname.'.tomo1.xml','Marcas');				
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($fname_xml);
			$xpath = new DOMXPath($xmlDoc);
				
			//Load all data from data dictionary
			if ($this->verbose) print('	Get dictionary: '.$this->metadata_filename."\n");
				
			$dictionary = file_get_contents($this->metadata_filename);
			$rules = explode("\n",$dictionary);
				
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
						
						$fields = array();
						for($i = 2; $i < count($parts[1]); $i++)
						{
						array_push($fields,$parts[1][$i]);
						}
						$result[$namespace][$block] = $this->get_record($xmlDoc,$xpath,$parts[1][0],$parts[1][1],$fields);
						
					}
				}
			}
		}
		else
		{
			$result['status'] = 'ko';
		}
		
		shell_exec('gzip '.$fname_xml);	
		return $result;
	}
}

?>
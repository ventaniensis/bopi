<?php 

class ImageRemover
{
	function remove_images($filename,$tag_base,$verbose = false)
	{
		if (!file_exists($filename))
		{
			return;
		}
		if ($verbose) print("----------------------------\n");
		
		if ($verbose) print("Removing images file:".$filename."\n");
			
		// If it is gzipped, unzip and process
		$is_gzipped = strpos($filename,'.gz');
		if ($is_gzipped)
		{
			if ($verbose) print("Gunzipping file:".$filename."\n");
			shell_exec('gunzip '.$filename);
			$filename = str_replace('.gz', '', $filename);
		}
		
		if (filesize($filename) > 0)
		{
			$size_1 = filesize($filename);
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($filename);
			$tbody = $xmlDoc->getElementsByTagName($tag_base)->item(0);
			$xpath = new DOMXPath($xmlDoc);
			$consulta = '//tns:imagen';
			$entradas = $xpath->query($consulta, $tbody);
			$removals = 0;
			foreach ($entradas as $entrada)
			{
				$entrada->parentNode->removeChild($entrada);
				$removals++;
			}
						
			$xmlDoc->save($filename);
			$size_2 = filesize($filename);
				
			if ($verbose) print("Removing images [".$filename."] tag:".$tag_base." Removals:".$removals." size/size:".$size_1."/".$size_2."\n");
				
		}
		
		// Bring it back to gzip if it was gzipped
		if ($is_gzipped)
		{
			if ($verbose) print("Zipping file:".$filename."\n");
			shell_exec('gzip '.$filename);
		}	
	}
}

?>
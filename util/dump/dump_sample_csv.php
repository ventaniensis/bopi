<?php

	
$filename = $argv[1];
$columns = explode(',',$argv[2]);//YEAR;NOMBRETITULAR
// Filter a filename

function select_columns($filename,$records = 3, $dump_header = true)
{
	$header = array();
	$line_count = 0;
	$handle = fopen($filename, "r");
	$columns = array();
	if ($handle) 
	{
		while (($line = fgets($handle)) !== false) 
		{
			$data = explode(';',$line);
			
			if ($line_count === 0)
			{
				$i = 0;
				foreach($data as $k)
				{
					$column = strtoupper($k);
					array_push($columns,$column);
					$header[$column] = $i;
					$i++;
				}
			}
			else
			{
				//print_r($data);
				$item = array();
				foreach($columns as $k)
				{
					$column = strtoupper($k);
					$item[$column] = $data[$header[$column]];
				}	
				print_r($item);
			}
			$line_count++;
			if ($line_count >= $records)
			{
				break;
			}			
		}
		fclose($handle);
	} 
	else 
	{
		// error opening the file.
	}
}

select_columns($filename,3,true);
?>

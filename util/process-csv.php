<?php

	
$filename = $argv[1];
$columns = explode(',',$argv[2]);//YEAR;NOMBRETITULAR
// Filter a filename

function select_columns($filename,$columns,$dump_header = true)
{
	//print_r($columns);
	$header = array();
	$line_count = 0;
	$handle = fopen($filename, "r");
	if ($handle) 
	{
		while (($line = fgets($handle)) !== false) 
		{
			//print($line);
			$data = explode(';',$line);
			
			if ($line_count === 0)
			{
				$i = 0;
				foreach($data as $k)
				{
					$column = trim(strtoupper($k));
					$header[$column] = $i;
					$i++;
				}
				if ($dump_header)
				{				
					$i = 0;
					foreach($columns as $k)
					{
						$column = strtoupper($k);
						if ($i > 0) { print(";");}
						if ($column[0] === '^')
						{
							$field = substr($column, 1);
							print($field);
						}
						else
						{
							print($column);
						}
						$i++;
					}
					print("\n");
				}				
			}
			else
			{
				$i = 0;
				//print_r($data);
				//print_r($header);
				foreach($columns as $k)
				{
					$column = strtoupper($k);
					if ($i > 0) { print(";");}
					if ($column[0] === '^')
					{
						$field = substr($column, 1);
						print(trim($data[$header[$field]]));
					}
					else
					{
						print(trim($data[$header[$column]]));
					}
					$i++;	
				}		
				print("\n");
			}
			$line_count++;
		}
		fclose($handle);
	} 
	else 
	{
		// error opening the file.
	}
}

select_columns($filename,$columns,true);
?>

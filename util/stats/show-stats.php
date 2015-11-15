<?php

require_once('bopi/processors/folder-processor.inc');
require_once('bopi/processors/util/ImageRemover.inc');
require_once('bopi/processors/processor.factory.inc');

error_reporting(E_ERROR | E_PARSE);


function stats_process_iteration($folder,$file)
{
	$tomo_1 = $folder.'/'.$file;
	$tomo_2 = str_replace('tomo1','tomo2',$tomo_1);
	$tomo_3 = str_replace('tomo1','tomo2',$tomo_1);
	
	
	$date = substr($file, 0,8);
	$year = substr($file, 0,4);
	$month = substr($file, 4,2);
	$day = substr($file, 6,2);
	
	$util = BopiProcessorFactory::getBopiProcessorTomo1($folder);
	if (file_exists($tomo_1))
	{
		$result = $util->process($year,$month,$day);
		if ($result['status'] === 'ok')
		{
			foreach($result as $namespace => $tables)
			{
				foreach($tables as $tablename => $records)
				{
					print($year.';'.$month.';'.$day.';TOMO1;'.$namespace.';'.$tablename.';'.count($records)."\n");
				}
			}
		}
		$util = BopiProcessorFactory::getBopiProcessorTomo2($folder);
		$result = $util->process($year,$month,$day);
		if ($result['status'] === 'ok')
		{
			foreach($result as $namespace => $tables)
			{
				foreach($tables as $tablename => $records)
				{
					print($year.';'.$month.';'.$day.';TOMO2;'.$namespace.';'.$tablename.';'.count($records)."\n");
				}
			}
		}
		$util = BopiProcessorFactory::getBopiProcessorTomo3($folder);
		$result = $util->process($year,$month,$day);
		if ($result['status'] === 'ok')
		{
			foreach($result as $namespace => $tables)
			{
				foreach($tables as $tablename => $records)
				{
					print($year.';'.$month.';'.$day.';TOMO3;'.$namespace.';'.$tablename.';'.count($records)."\n");
				}
			}
		}
		
	}
}

function dump_stats()
{
	$processor = new FolderProcessor('tomo1');
	print("year;month;day;block;namespace;tablename;count\n");
	$processor->traverse_folder('cache.bopi',stats_process_iteration);
}



dump_stats();


?>

<?php

require_once('../bopi/processors/folder-processor.inc');
require_once('../bopi/processors/util/ImageRemover.inc');
require_once('../bopi/processors/processor.factory.inc');

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
	
	$util = BopiProcessorFactory::getBopiProcessorTomo2($working_folder);
	//$util = BopiProcessorFactory::getBopiProcessorTomo3($working_folder);
	//$util = BopiProcessorFactory::getBopiProcessorTomo1($working_folder);
	
	$result = $util->process($year,$month,$day);
	
	foreach($result as $namespace => $tables)
	{
		foreach($tables as $tablename => $records)
		{
			print($year.';'.$month.';'.$date.';'.$processor->metadata_filename.';'.$namespace.';'.$tablename.';'.count($records)."\n");
		}
	}
}

function dump_stats()
{
	$processor = new FolderProcessor('tomo1');
	print("year;month;day;block;namespace;tablename;count\n");
	$processor->traverse_folder('../cache.bopi',stats_process_iteration);
}



dump_stats();


?>

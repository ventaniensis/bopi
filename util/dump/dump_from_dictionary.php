<?php

require_once('bopi/processors/processor.factory.inc');
require_once('bopi/processors/folder-processor.inc');
require_once('bopi/metadata/MetadataManager.class.inc');
require_once('bopi/dumpers/CSVDumper.php');

//error_reporting(E_ERROR | E_PARSE);

// DUMP Complete database from data dictionary

$working_folder = $argv[1];
$out_directory = $argv[2];
$tomo = $argv[3];
$subject_type = "";

$GLOBALS['tomo'] = $tomo !== '' ? $tomo : "1";
$GLOBALS['dump_header'] = true;
$GLOBALS['section'] = $section;
$GLOBALS['subsection'] = $subsection;
$GLOBALS['handlers'] = array();

function open_handlers($folder,$metadata)
{
	$GLOBALS['handlers'] = array();
	foreach($metadata as $namespace => $items)
	{
		$GLOBALS['handlers'][$namespace] = array();
		foreach($items as $tablename => $fields)
		{
			// Close handler
			$filename = $folder.'/'.$tablename.'.txt';
			$handler = fopen($filename,'w');
			$GLOBALS['handlers'][$namespace][$tablename] = $handler;
			// Write headers
			fwrite($handler, 'YEAR;MONTH;DAY');
			foreach($fields as $field_name => $type)
			{
				fwrite($handler, ";");
				fwrite($handler, $field_name);
			}
			fwrite($handler, "\n");
		}
	}
	
}

function close_handlers()
{
	foreach($GLOBALS['handlers'] as $namespace => $items)
	{
		foreach($items as $tablename => $fields)
		{
			// Close handler
			fclose($GLOBALS['handlers'][$namespace][$tablename]);
		}
	}
}

function dump_data_iteration($folder,$file)
{
	$dumper = new CSVDumper(';');
	$tomo_1 = $folder.'/'.$file;
	print('Processing: '.$tomo_1."\n");
	
	$date = substr($file, 0,8);
	$year = substr($file, 0,4);
	$month = substr($file, 4,2);
	$day = substr($file, 6,2);
	
	$util = $GLOBALS['processor'];
	if (file_exists($tomo_1))
	{
		$result = $util->process($year,$month,$day);
		if ($result['status'] === 'ok')
		{
//			print_r($GLOBALS['handlers']);
			foreach($GLOBALS['metadata']->metadata as $namespace => $tables)
			{
				//print("-- NAMESPACE:".$tablename."\n");
				
				foreach($tables as $tablename => $fields)
				{
					//print("\tTABLE:".$tablename."\n");
					$handler = $GLOBALS['handlers'][$namespace][$tablename];
					//continue;
					if (is_array($result[$namespace][$tablename]) && count($result[$namespace][$tablename]) > 0 )
					{
						foreach($result[$namespace][$tablename] as $record)
						{
								// Write DATE
								fwrite($handler, $year.";".$month.';'.$day);
								foreach($fields as $field_name => $type)
								{
									fwrite($handler, ";");
									$value = key_exists($field_name, $record) ? $record[$field_name] : '';
									$value = $dumper->serialize_value($value);
									//print("\t\tFIELD:".$field_name.':'.$value."\n");
									// if serializable
									fwrite($handler, $value);
								}
								//print_r($record);
								fwrite($handler, "\n");
						}
					}
					// Print line
				}
			}
			//exit;
		}//if	
	}//if
}

function dump_data($working_folder,$tomo)
{
	$processor = new FolderProcessor('tomo'.$tomo);
	$processor->traverse_folder($working_folder,dump_data_iteration);
}
$metadata = new MetadataManager('metadata/data.dictionary.tomo'.$GLOBALS['tomo'].'.txt');
$GLOBALS['metadata'] = $metadata;
open_handlers($out_directory,$metadata->metadata);
$GLOBALS['processor'] = BopiProcessorFactory::getProcessorByNumber($working_folder,$tomo,false);
dump_data($working_folder,$tomo);
close_handlers($out_directory);


?>

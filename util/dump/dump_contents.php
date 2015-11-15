<?php

require_once('bopi/processors/processor.factory.inc');
require_once('bopi/processors/folder-processor.inc');
require_once('bopi/dumpers/CSVDumper.php');

error_reporting(E_ERROR | E_PARSE);

$working_folder = $argv[1];
$section = $argv[2];
$subsection = $argv[3];

$GLOBALS['dump_header'] = true;
$GLOBALS['section'] = $section;
$GLOBALS['subsection'] = $subsection;

function dump_data_iteration($folder,$file)
{
	$util = BopiProcessorFactory::getBopiProcessorTomo1($folder);
	$result = $util->process(substr($file, 0,4),substr($file, 4,2),substr($file, 6,2));
	$dumper = new CSVDumper(';');
	$records = $dumper->dump_contents(substr($file, 0,4),substr($file, 4,2),substr($file, 6,2), $GLOBALS['section'],$GLOBALS['subsection'], $result,$GLOBALS['dump_header']);
	if ($GLOBALS['dump_header'] && $records > 0)
	{
		$GLOBALS['dump_header'] = false;
	}	
}

function dump_data($working_folder)
{
	$processor = new FolderProcessor('tomo1');
	$processor->traverse_folder($working_folder,dump_data_iteration);
}

dump_data($working_folder);


?>

<?php

require_once('bopi/processors/processor.factory.inc');
require_once('bopi/dumpers/CSVDumper.php');

//$working_folder = 'sandbox';
$working_folder = 'cache.bopi';

error_reporting(E_ERROR | E_PARSE);

$year = $argv[1];
$month = $argv[2];
$day = $argv[3];

$tomo = $argc == 3 ? 1 : $argv[4];
// Get an instance
switch($tomo)
{
	case 2 :
		$util = BopiProcessorFactory::getBopiProcessorTomo2($working_folder);
		break;
	case 3 :
		$util = BopiProcessorFactory::getBopiProcessorTomo3($working_folder);
		break;
	case 1 :
	default:
		$util = BopiProcessorFactory::getBopiProcessorTomo1($working_folder);
		break;
		
}

$result = $util->process($year,$month,$day);

print_r($result);

//print('Solicitudes marcas:'.count($result['marcas']['solicitudes'])."\n");
//print('Solicitudes nombres:'.count($result['nombres_comerciales']['solicitudes'])."\n");

//$dumper = new CSVDumper(';');
//$dumper->dump_contents($year.$month.$day, 'marcas','solicitudes', $result);

//print_r($result['marcas']['renovacion_denegada_marca']);
//print('Result: '.$result."\n");

?>

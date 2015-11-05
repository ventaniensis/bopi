<?php

require_once('bopi/processors/processor.tomo1.php');

error_reporting(E_ERROR | E_PARSE);

$year = $argv[1];
$month = $argv[2];
$day = $argv[3];
$util = new BopiProcessorTomo1('cache.bopi',false);
$result = $util->process($year,$month,$day);
print_r($result);
//print_r($result['marcas']['renovacion_denegada_marca']);
//print('Result: '.$result."\n");

?>

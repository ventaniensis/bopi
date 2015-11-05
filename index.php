<?php

require_once('bopi/bopi.downloader.inc');
require_once('network_patch.inc');
//error_reporting(E_ERROR | E_PARSE);

$year = $argv[1];
$month = $argv[2];
$day = $argv[3];

extract($_POST);
$ch = curl_init();
//set the url, number of POST vars, POST data
$url = 'https://sede.oepm.gob.es/bopiweb/descargaPublicaciones/resultBusqueda.action?fecha='.$day.'-'.$month.'-'.$year;
print($url."\n");
curl_setopt($ch,CURLOPT_URL, $url);
$fields = array('fecha' => $day.'-'.$month.'-'.$year);
$fields_string='fecha='.$day.'-'.$month.'-'.$year;
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
$result = curl_exec($ch);
print_r($result);
curl_close($ch);

//$response = http_post_fields("https://sede.oepm.gob.es/bopiweb/descargaPublicaciones/resultBusqueda.action", array('fecha' => $day.'-'.$month.'-'.$year));

$util = new BopiDownloader('cache.bopi',false);
$result = $util->bopi_daily_downloader($year,$month,$day);

print('Result: '.$result."\n");

?>

<?php

require_once('bopi/bopi.downloader.inc');

$year = $argv[1];
$month = $argv[2];
$day = $argv[3];
$util = new BopiDownloader('cache.bopi',false);
$result = $util->bopi_daily_downloader($year,$month,$day);

print('Result: '.$result."\n");

?>

<?php

require_once('bopi/bopi.downloader.inc');
require_once('network_patch.inc');
//error_reporting(E_ERROR | E_PARSE);

$year = $argv[1];
for($v_month = 9; $v_month <= 12; $v_month++)
{
	for($v_day = 1; $v_day <= 30; $v_day++)
	{
		/*
		if ($month == 2 && $day = 30)
		{
			break;
		}
		*/
		$util = new BopiDownloader('cache.bopi',false);
		$month = $v_month;
		if ($v_month < 10)
		{
			$month = '0'.$month;
		}
		$day = $v_day;
		if ($v_day < 10)
		{
			$day = '0'.$day;
		}
		
		$result = $util->bopi_daily_downloader($year,$month,$day);
		print('Result: '.$year.'-'.$month.'-'.$day.'->'.$result."\n");
		
	}
}

?>

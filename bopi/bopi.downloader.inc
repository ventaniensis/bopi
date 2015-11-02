<?php 

class BopiDownloader
{
	var $verbose = false;
	var $cache_folder = false;
	
	function BopiDownloader($v_cache_folder,$vVerbose = false)
	{
		$this->verbose = $vVerbose;
		$this->cache_folder = $v_cache_folder;
	}
	
	// http://www.oepm.es/robots.txt
	function bopi_daily_downloader($year,$month,$day)
	{
		if ($year === '' || $month === '' || $day ==='' || intval($year) < 1990 || intval($month) < 1 || intval($month) > 12 || intval($day) < 1 && intval($day) > 31)
		{
			return 'ko';
		}
		$index = 0;
		$yyyymmdd = $year.$month.$date;
		if (!file_exists($this->cache_folder))
		{
			mkdir($this->cache_folder);
			if ($this->verbose)
			{
				print('	Creating folder: '.$this->cache_folder."\n");
			}
		}
		$fname = $this->cache_folder.'/'.$year.$month.$day.'_bopi';
		$code = 'ok';
	
		if (!file_exists($fname.'.tomo1.xml') || filesize($fname.'.tomo1.xml') == 0)
		{
	
			$url = 'https://sede.oepm.gob.es/bopidiario/TOMO1_'.$day.'-'.$month.'-'.$year.'.xml';
			if ($this->verbose)
			{
				print('	Downloading: '.$url."\n");
			}
			try 
			{
				$texto = file_get_contents($url);
				file_put_contents($fname.'.tomo1.xml',$texto); // Save file with zero bytes to prevent more downloads
				if (trim($texto) !== '' && $texto !== null)
				{
					// Contains text
						
					$url = 'https://sede.oepm.gob.es/bopidiario/TOMO2_'.$day.'-'.$month.'-'.$year.'.xml';
					if ($this->verbose)
					{
						print('	Downloading: '.$url."\n");
					}
				
					$texto = file_get_contents($url);
					file_put_contents($fname.'.tomo2.xml',$texto);
						
					$url = 'https://sede.oepm.gob.es/bopidiario/TOMO3_'.$day.'-'.$month.'-'.$year.'.xml';
					if ($this->verbose)
					{
						print('	Downloading: '.$url."\n");
					}
				
					$texto = file_get_contents($url);
					file_put_contents($fname.'.tomo3.xml',$texto);
						
					$code = 'ok';
				}
				else
				{
					$code = 'ko';
				}
				
			}
			catch (Exception $e)
			{
				// Not found
				file_put_contents($fname.'.tomo1.xml','not_found'); // Save file with zero bytes to prevent more downloads
			}
		}
		// Unzip
	
		return $code;
	}
}

?>
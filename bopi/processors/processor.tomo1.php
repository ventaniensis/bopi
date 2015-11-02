<?php 
/*
	<tns:Marcas>...</tns:Marcas>
	<tns:NombresComerciales>...</tns:NombresComerciales>
	<tns:RotulosEstablecimiento>...</tns:RotulosEstablecimiento>
	<tns:MarcasInternacionales>...</tns:MarcasInternacionales>
	<tns:CesionesLicenciasYCambiosNombreTitulares>...</tns:CesionesLicenciasYCambiosNombreTitulares>
	<tns:RecursosAdministrativos>...</tns:RecursosAdministrativos>
	<tns:Tribunales>...</tns:Tribunales>
	<tns:CumplimientoDeSentencias>...</tns:CumplimientoDeSentencias>
	<tns:RestablecimientoDeDerechos>...</tns:RestablecimientoDeDerechos>
	<tns:Rectificaciones>...</tns:Rectificaciones>
 * 
 */
class BopiProcessorTomo1
{
	var $cache_folder = false;
	var $data;
	
	function BopiProcessorTomo1($v_cache_folder,$vVerbose = false)
	{
		$this->verbose = $vVerbose;
		$this->cache_folder = $v_cache_folder;
	}
	
	// http://www.oepm.es/robots.txt
	function process($year,$month,$day)
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
		$result = array();
		$result['status'] = 'ok';
		
		if (file_exists($fname.'.tomo1.xml') && filesize($fname.'.tomo1.xml') > 0)
		{
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($fname.'.tomo1.xml');

			$result['payload'] = $xmlDoc;				
		}
		else
		{
			$result['status'] = 'ko';
		}
		return $result;
	}
}

?>
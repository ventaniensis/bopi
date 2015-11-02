<?php 
/*
	<tns:Marcas>...</tns:Marcas>
	
	  <tns:Marcas><tns:SolicitudesMarcas><tns:SolicitudMarca>
	  <tns:PublicacionId>2693729</tns:PublicacionId>
	  <tns:Modalidad>M</tns:Modalidad>
	  <tns:p21_NumSolicitud>3570215</tns:p21_NumSolicitud>
	  <tns:Bis>  </tns:Bis>
	  <tns:DigitoControl>X</tns:DigitoControl>
	  <tns:ApellidosTitular>F.J. SANCHEZ SUCESORES S.A.U.</tns:ApellidosTitular>
	  <tns:FechaDepositoRegular>08/07/2015</tns:FechaDepositoRegular>
	  <tns:TipoSigno>G</tns:TipoSigno>
	  <tns:Domicilio>CALLE CAMPANARIO S/N</tns:Domicilio>
	  <tns:CodigoPostal>04270</tns:CodigoPostal>
	  <tns:PaisDeResidencia>ES</tns:PaisDeResidencia>
	  <tns:Localidad>SORBAS</tns:Localidad>
	  <tns:Provincia>ALMERIA</tns:Provincia>
	  <tns:ClasificacionesElementosFigurativos>260404260415260416260422290103</tns:ClasificacionesElementosFigurativos>
	  <tns:ProductosServiciosActividades>29-ACEITES Y GRASAS COMESTIBLES. </tns:ProductosServiciosActividades>
	  <tns:IndicacionColores>PANTONES VERDE CLARO 371C, VERDE OSCURO 583C CUATRICROMIA</tns:IndicacionColores>
	  <tns:imagen>/9j/4AAQSkZJRgABAgAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAUxA6wDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3+iiigAooooAKKKKACiiigAooooAKKKKACiioTIPOWLDb
	                
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
			/*
			$consulta = '//tns:Tomo1/tns:Marcas';
			$xpath = new DOMXPath($xmlDoc);
			$entradas = $xpath->query($consulta);

foreach ($entradas as $entrada) {
    echo "Se encotr— {$entrada->previousSibling->previousSibling->nodeValue}," .
         " por {$entrada->previousSibling->nodeValue}\n";
}
*/
			$tbody = $xmlDoc->getElementsByTagName('Marcas')->item(0);
			$xpath = new DOMXPath($xmlDoc);
			$consulta = '/tns:Marcas/tns:SolicitudesMarcas';
			$consulta = '//tns:SolicitudMarca';
			$entradas = $xpath->query($consulta, $tbody);

			$result['payload'] = array();
			$result['payload']['marcas'] = array();
				
			foreach ($entradas as $entrada) 
			{
				// Marcas
				$record = array();
				$record['PublicacionId'] = $entrada->getElementsByTagName('PublicacionId')->item(0)->nodeValue;
				$record['NombreTitular'] = $entrada->getElementsByTagName('NombreTitular')->item(0)->nodeValue;
				$record['ApellidosTitular'] = $entrada->getElementsByTagName('ApellidosTitular')->item(0)->nodeValue;
				$record['Modalidad'] = $entrada->getElementsByTagName('Modalidad')->item(0)->nodeValue;
				$record['p21_NumSolicitud'] = $entrada->getElementsByTagName('p21_NumSolicitud')->item(0)->nodeValue;
				$record['TipoSigno'] = $entrada->getElementsByTagName('TipoSigno')->item(0)->nodeValue;
				$record['FechaDepositoRegular'] = $entrada->getElementsByTagName('FechaDepositoRegular')->item(0)->nodeValue;
				$record['Domicilio'] = $entrada->getElementsByTagName('Domicilio')->item(0)->nodeValue;
				$record['CodigoPostal'] = $entrada->getElementsByTagName('CodigoPostal')->item(0)->nodeValue;
				$record['PaisDeResidencia'] = $entrada->getElementsByTagName('PaisDeResidencia')->item(0)->nodeValue;
				$record['Localidad'] = $entrada->getElementsByTagName('Localidad')->item(0)->nodeValue;
				$record['Provincia'] = $entrada->getElementsByTagName('Provincia')->item(0)->nodeValue;
				$record['ClasificacionesElementosFigurativos'] = $entrada->getElementsByTagName('ClasificacionesElementosFigurativos')->item(0)->nodeValue;
				$record['ProductosServiciosActividades'] = $entrada->getElementsByTagName('ProductosServiciosActividades')->item(0)->nodeValue;
				$record['IndicacionColores'] = $entrada->getElementsByTagName('IndicacionColores')->item(0)->nodeValue;
				
				
				array_push($result['payload']['marcas'],$record);
			}
				
		}
		else
		{
			$result['status'] = 'ko';
		}
		return $result;
	}
}

?>
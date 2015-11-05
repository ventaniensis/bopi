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
	
	function get_record($xmlDoc,$xpath,$clase_suspenso,$tag_suspenso,$field_list)
	{
		$tbody = $xmlDoc->getElementsByTagName($clase_suspenso)->item(0);
		$consulta = '//tns:'.$tag_suspenso;
		$entradas = $xpath->query($consulta, $tbody);
	
		$result = array();
		foreach ($entradas as $entrada)
		{
			$record = array();
			foreach($field_list as $field)
			{
				if ($field[0] === '$')
				{
					// Multivalue
					$field_name = substr($field, 1);
					$record[$field_name] = array();
					foreach ($entrada->getElementsByTagName($field_name) as $item)
					{
						array_push($record[$field_name],$item->nodeValue);
					
					}
				}
				else
				{
					$record[$field] = $entrada->getElementsByTagName($field)->item(0)->nodeValue;
				}
			}
			array_push($result,$record);
		}
		return $result;
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
			// Remove image
			/*
			$consulta = '//tns:Tomo1/tns:Marcas';
			$xpath = new DOMXPath($xmlDoc);
			$entradas = $xpath->query($consulta);

foreach ($entradas as $entrada) {
    echo "Se encotr— {$entrada->previousSibling->previousSibling->nodeValue}," .
         " por {$entrada->previousSibling->nodeValue}\n";
}
*/
			// Remove images
			$tbody = $xmlDoc->getElementsByTagName('Marcas')->item(0);
			$xpath = new DOMXPath($xmlDoc);

			/**
				Load all data from data dictionary
			 */
			$dictionary = file_get_contents('data.dictionary.txt');
			$rules = explode("\n",$dictionary);
				
			foreach($rules as $rule)
			{
				if ($rule[0] !== '#')
				{
					$parts = explode('=',$rule);
					$parts[1] = explode(',',$parts[1]);
						
					$left_part = explode('.',$parts[0]);
					$namespace = $left_part[0];
					$block = $left_part[1];
					$namespace = $left_part[0];

					if (!array_key_exists($namespace,$result))
					{
						$result[$namespace] = array();
					}
				
					$fields = array();
					for($i = 2; $i < count($parts[1]); $i++)
					{
						array_push($fields,$parts[1][$i]);
					}
					$result[$namespace][$block] = $this->get_record($xmlDoc,$xpath,$parts[1][0],$parts[1][1],$fields);
				}
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
<?php 
require_once('processor.tomo.php');

/**
 * 
 * @author davidreyblanco
 *
 */
class BopiProcessorFactory
{
	
	function getBopiProcessorTomo1($v_cache_folder,$vVerbose = false)
	{
		$instance = new BopiProcessor($v_cache_folder,'tomo1','data.dictionary.tomo1.txt',$vVerbose);
		return $instance;		
	}
	
	function getBopiProcessorTomo2($v_cache_folder,$vVerbose = false)
	{
		$instance = new BopiProcessor($v_cache_folder,'tomo2','data.dictionary.tomo2.txt',$vVerbose);
		return $instance;
	}

	function getBopiProcessorTomo3($v_cache_folder,$vVerbose = false)
	{
		$instance = new BopiProcessor($v_cache_folder,'tomo3','data.dictionary.tomo3.txt',$vVerbose);
		return $instance;
	}
	
	function getProcessorByNumber($v_cache_folder,$tomo,$vVerbose = false)
	{
		switch($tomo)
		{
			case '3':
				$instance = BopiProcessorFactory::getBopiProcessorTomo3($v_cache_folder,$vVerbose);
				break;
			case '2':
				$instance = BopiProcessorFactory::getBopiProcessorTomo2($v_cache_folder,$vVerbose);
				break;
			case '1':
			default:
				$instance = BopiProcessorFactory::getBopiProcessorTomo1($v_cache_folder,$vVerbose);
				
		}
		return $instance;
	}
}//End of class

?>
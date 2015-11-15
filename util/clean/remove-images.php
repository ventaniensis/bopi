<?php

require_once('../bopi/processors/folder-processor.inc');
require_once('../bopi/processors/util/ImageRemover.inc');

error_reporting(E_ERROR | E_PARSE);

function clean_images_iteration($folder,$file)
{
	$tomo_1 = $folder.'/'.$file;
	$tomo_2 = str_replace('tomo1','tomo2',$tomo_1);
	$tomo_3 = str_replace('tomo1','tomo3',$tomo_1);
	
	// Remove all images
	ImageRemover::remove_images($tomo_1,'Marcas',true);
	ImageRemover::remove_images($tomo_2,'PatenteNacional',true);
	ImageRemover::remove_images($tomo_3,'DisenyoIndustrial',true);
	
	//exit;
}

function clean_images()
{
	$processor = new FolderProcessor('tomo1');
	$processor->traverse_folder('../cache.bopi',clean_images_iteration);
}
//dump_stats();
if ($argc >= 3)
{
	$tomo_1 = '../cache.bopi/'.$argv[1].$argv[2].$argv[3].'_bopi.tomo1.xml';
	if (!file_exists($tomo1))
	{
		$tomo1 = str_replace('.xml','.xml.gz',$tomo1);
	}
	print($tomo1);
	$tomo_2 = str_replace('tomo1','tomo2',$tomo_1);
	$tomo_3 = str_replace('tomo1','tomo3',$tomo_1);
	
	// Remove all images
	ImageRemover::remove_images($tomo_1,'Marcas',true);
	ImageRemover::remove_images($tomo_2,'PatenteNacional',true);
	ImageRemover::remove_images($tomo_3,'DisenyoIndustrial',true);
	
}
else
{
	clean_images();
}


?>

<?php

require_once('../../bopi/metadata/MetadataManager.class.inc');

/** 
 * Dump metadata in CSV format
 * 
 * @param unknown $file
 * @param unknown $metadata
 * @param string $header
 */
function dump_metadata($file,$metadata,$header = false)
{
	if ($header)
	{
		print("FILE;NAMESPACE;TABLE;FIELD;TYPE\n");
	}	
	foreach($metadata as $namespace => $items)
	{
		foreach($items as $tablename => $fields)
		{
			foreach($fields as $field_name => $type)
			{
				print($file.';'.$namespace.';'.$tablename.';');
				print($field_name.';'.$type."\n");	
			}
		}
	}	
}

// Tomo 1
$file = "data.dictionary.tomo1.txt";
$metadata = new MetadataManager('../../metadata/'.$file);
dump_metadata($file,$metadata->metadata,true);
// Tomo 2
$file = "data.dictionary.tomo2.txt";
$metadata = new MetadataManager('../../metadata/'.$file);
dump_metadata($file,$metadata->metadata,false);
// Tomo 3
$file = "data.dictionary.tomo3.txt";
$metadata = new MetadataManager('../../metadata/'.$file);
dump_metadata($file,$metadata->metadata,false);

?>
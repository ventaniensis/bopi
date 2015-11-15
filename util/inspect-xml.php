<?php

	
$fname_xml = $argv[1];

function dump_contents($fname_xml)
{
	$xmlDoc = new DOMDocument();
	$xmlDoc->load($fname_xml);
	$xpath = new DOMXPath($xmlDoc);

	$tbody = $xmlDoc->getElementsByTagName('PublicacionId');
	// Dump all publications
	foreach ($tbody as $item)
	{
		$pub_id = $item->nodeValue;
		$container = str_replace('tns:', '',$item->parentNode->nodeName);
		$container_list = str_replace('tns:', '',$item->parentNode->parentNode->nodeName);
		$go = true;
		$current = $item->parentNode->parentNode;
		print($container_list.' '.$container.' '.$pub_id."\n");
	}
}


function extract_metadata($fname_xml)
{	
$xmlDoc = new DOMDocument();
$xmlDoc->load($fname_xml);
$xpath = new DOMXPath($xmlDoc);

$tbody = $xmlDoc->getElementsByTagName('PublicacionId');
$dictonary = array();
$route = array();
// Dump all publications
foreach ($tbody as $item)
{
	$pub_id = $item->nodeValue;
	$container = str_replace('tns:', '',$item->parentNode->nodeName);
	$container_list = str_replace('tns:', '',$item->parentNode->parentNode->nodeName);
	
	$current = $item->parentNode->parentNode;
	$trace = array();
	do
	{
		array_push($trace,$current->nodeName);
		$current = $current->parentNode;
	}
	while ($current->nodeName != '#document');
	$namespace = str_replace('.', '_',strtolower(str_replace('tns:', '',$trace[1])));
	$table_name = str_replace('.', '_',strtolower($container_list));
	$route[$namespace.'.'.$table_name] = $container_list.','.$container;
	if (!key_exists($namespace, $dictonary))
	{
		$dictonary[$namespace] = array();
	}
	if (!key_exists($table_name, $dictonary[$namespace] ))
	{
		$dictonary[$namespace][$table_name] = array();
	}
	$keys = array();
	
	foreach($item->parentNode->childNodes as $child)
	{
		$key = str_replace('tns:', '',$child->nodeName);
		if (!key_exists($key, $dictonary[$namespace][$table_name] ))
		{
			$dictonary[$namespace][$table_name][$key] = 'S';
		}		
		// If the element is repeated then create a list
		$dictonary[$namespace][$table_name][$key] = in_array($key,$keys) ? 'M' : $dictonary[$namespace][$table_name][$key];
		// Control the keys seen
		array_push($keys,$key); 		
	}
}
// Generate data Dictionary
date_default_timezone_set('Europe/Madrid');
print("----------------------------------------\n");
print("--	DATA DICTIONARY MACHINE GENERATED\n");
print("--	Generation date: ".date('Y-m-d')."\n");
print("----------------------------------------\n");
print("\n");

foreach($dictonary as $namespace => $table)
{
	print("----------------------------------------\n");
	print("--		".$namespace."\n");
	print("----------------------------------------\n");
	
	foreach($table as $table_name => $fields)
	{
		print($namespace.'.'.$table_name.'='.$route[$namespace.'.'.$table_name]);
		foreach($fields as $field_name => $type)
		{
			print(',');
			if ($type === 'M')
			{
				print('$');
			}
			print($field_name);
		}
		print("\n");		
	}
	print("\n");
}
//print_r($dictonary);
}

//dump_contents($fname_xml);
extract_metadata($fname_xml);

?>

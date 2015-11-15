<?php
require_once('../../bopi/metadata/MetadataManager.class.inc');

$manager = new MetadataManager('../../metadata/data.dictionary.tomo1.txt');
print_r($manager->metadata);

?>
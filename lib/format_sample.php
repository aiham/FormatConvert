<?php

require_once 'CsvFormat.php';
require_once 'JsonFormat.php';
require_once 'XmlFormat.php';
require_once 'SerializeFormat.php';

$string = "first,second,third\na,b,c\nd,e,f\ng,h,i";

$csv = CsvFormat::fromString($string, true);
echo $csv->toString() . "\n\n";

$json = $csv->convert('json');
echo $json->toString() . "\n\n";

$xml = $csv->convert('xml');
echo $xml->toString() . "\n\n";

$serialize = $csv->convert('serialize');
echo $serialize->toString() . "\n\n";

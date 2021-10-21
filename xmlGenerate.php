<?php
// Генерируем xml-файл необходимого размера

$xml = new SimpleXMLElement('<xml/>');

for ($i = 1; $i <= 2500000; ++$i) {
    $test = $xml->addChild('test');
    $test->addChild('name', "name $i");
    $test->addChild('description', "description $i");
}

Header('Content-type: text/xml');
print($xml->asXML());

?>
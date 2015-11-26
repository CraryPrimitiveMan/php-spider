<?php
require(__DIR__ . '/../vendor/autoload.php');

$html = Requests::get('https://github.com/CraryPrimitiveMan');
$doc = phpQuery::newDocument($html->body);
//$('[itemprop=worksFor]').text()
foreach ($doc['.repo'] as $key => $value) {
    var_dump($value->nodeValue);
}

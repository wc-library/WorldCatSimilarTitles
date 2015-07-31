<?php

require_once "autoloader.php";

/**
 * @author Brandon Garcia <brandon.garcia@my.wheaton.edu>
 */


require_once "autoloader.php";

/**
 * @author Brandon Garcia <brandon.garcia@my.wheaton.edu>
 */

$outputType = 'xml';
$format = 'isbn';

$exampleData = explode("\n",
    file_get_contents('exampleData.txt')
);

$input = array();
foreach ($exampleData as $id) {
    $input[] = intval($id);
}
$input = array_unique($data);

$worldCat = new WorldCatService();

$output = array();
foreach($input as $id) {
    $output[$id] = $worldCat->{$type}->getEditions($id);
}

echo ExportFactory::makeExporter($outputType)->getFrom($format,$output);
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-type: text/xml");
require_once 'autoloader.php';

if (!isset($_POST['csv'])) {
    header("location: index.php");
}

$list = explode(',',$_POST['csv']);
$n = count($list);
for ($i=0; $i<$n; ++$i) {
    if ($list[$i]==FALSE) {
        unset($list[$i]);
    } else {
        $list[$i] = intval($list[$i]);
    }
}
$list = array_unique($list,SORT_NUMERIC);

$worldCat = new WorldCatService();

$output = array();
foreach($list as $id) {
    $output[$id] = $worldCat->{'isbn'}->getEditions($id);
}

echo ExportFactory::makeExporter('xml')->getFrom('isbn',$output);



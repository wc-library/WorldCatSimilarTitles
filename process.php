<?php
require_once 'autoloader.php';

#\util\PHPProfiler::run();

if (!isset($_POST['idlist'])) {
    header("location: index.php");
}

$list = explode(',', $_POST['idlist']);
$idtype = strtoupper($_POST['idtype']);
$outputFormat = $_POST['outputFormat'];
$flag_hide_unique = $_POST['hideunique']==1;

$n = count($list);
for ($i = 0; $i < $n; ++$i) {
    if ($list[$i] == FALSE) {
        unset($list[$i]);
    } else {
        $list[$i] = intval($list[$i]);
    }
}
$list = array_unique($list, SORT_NUMERIC);

$resultset = \oclc\WorldCatCatalogSearch::batchLookup($idtype,$list,$flag_hide_unique);
\output\FormatFactory::make($outputFormat)->display('Results',$resultset);
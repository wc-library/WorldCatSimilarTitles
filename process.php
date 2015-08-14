<?php
require_once 'autoloader.php';

//\util\PHPProfiler::run();

if (!isset($_POST['idlist'])) {
    header("location: index.php");
}

$list = explode(',', $_POST['idlist']);
$idtype = $_POST['idtype'];
$outputFormat = $_POST['outputFormat'];

$n = count($list);
for ($i = 0; $i < $n; ++$i) {
    if ($list[$i] == FALSE) {
        unset($list[$i]);
    } else {
        $list[$i] = intval($list[$i]);
    }
}
$list = array_unique($list, SORT_NUMERIC);

$worldCat = new \oclc\WorldCatService();
$resultset = $worldCat->batchLookup($idtype, $list);
\output\FormatFactory::make($outputFormat)->display('Results',$resultset);
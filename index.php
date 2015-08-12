<?php
require_once "autoloader.php";
$html_header = new \html\Header;
$html_header
    ->title("WorldCat Similar Titles")
    ->css("normalize.css")
    ->css("bootstrap.min.css")
    ->css("bootstrap-theme.min.css")
    ->css("style.css")
    ->js('jquery.min.js')
    ->js('bootstrap.min.js');

?>
<!DOCTYPE html>
<html lang="en"><?php
    echo $html_header->html();
        ?>
    <body><div class="container">
        <?php

if (isset($_POST['submit'])) {
    $params = array();

    $idlist = "";
    if (isset($_POST['idlist_textarea'])) {
        $txtdata =\util\Misc::cleanCSV($_POST['idlist_textarea']);
        $parms['idlist_textarea'] = $_POST['idlist_textarea'];
    }

    $file = new \input\FileUpload('idlist_file');
    if ( ($txt = $file->read()) !== FALSE) {
        $fdata = \util\Misc::cleanCSV($txt);
    }

    if (isset($txtdata,$fdata)) {
        $idlist .= "$txtdata, $fdata";
    }


    $idtype = $_POST['idtype'];
    $outputFormat = $_POST['outputFormat'];

    $params['idtype'] = $idtype;
    $params['outputFormat'] = $outputFormat;

    if (trim($idlist)=="") {
        $params['errormsg'] = "Cannot submit without IDs!";
        echo \html\Form::makeHiddenForm("CSVForm","index.php",$params);
    } else {
        $params = array(
            'idlist' => $idlist,
            'idtype' => $idtype,
            'outputFormat' => $outputFormat
            );
        echo \html\Form::makeHiddenForm("CSVForm","process.php",$params);
    }
 } else {
     $form = new \html\Form("WorldCat Similar Titles Search","");
     if (isset($_POST['errormsg'])) {
         $form->error($_POST['errormsg']);
     }
     echo $form
         ->select('idtype','ID Type',true)
             ->option('oclc','OCLC Numbers')
             ->option('isbn','ISBN Numbers')
             ->option('issn','ISSN Numbers')
             ->option('sn','Standard Numbers')
         ->select('outputFormat','Output Format',true)
             ->option('html','HTML')
             ->option('xml','XML')
         ->file('idlist_file','Import IDs (CSV or line breaks)')
         ->textarea('idlist_textarea','ID List (CSV or line breaks)')
         ->button('submit','Submit','btn btn-primary')
         ->html();
 }

        ?>
        </div></body>
</html>

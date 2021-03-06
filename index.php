<?php
require_once "autoloader.php";

$html_header = new \html\Header(array(
	'title' => "WorldCat Similar Titles",
	'css'   => array("style.min.css"),
	'js'    => array('jquery.min.js','bootstrap.min.js')
));

?><!DOCTYPE html>
<html lang="en">
<?php echo $html_header->html(); ?>
<body><?php

if (isset($_POST['submit'])) {
    $params = array();

    $idlist = "";
    if (isset($_POST['idlist_textarea'])) {
        $idlist = \util\Misc::cleanCSV($_POST['idlist_textarea']);
        $parms['idlist_textarea'] = $_POST['idlist_textarea'];
    }

    $file = new \util\FileUpload('idlist_file');
    if ( ($txt = $file->read()) !== FALSE) {
        if ($idlist) {
            $idlist .= ", ".\util\Misc::cleanCSV($txt);
        } else {
            $idlist = \util\Misc::cleanCSV($txt);
        }
    }

    $idtype = $_POST['idtype'];
    $outputFormat = $_POST['outputFormat'];

    $params['idtype'] = $idtype;
    $params['outputFormat'] = $outputFormat;
	$params['hideunique'] = isset($_POST['hide_unique'])?1:0;

    if (trim($idlist)=="") {
        $params['errormsg'] = "Cannot submit without IDs!";
        echo \html\FormPanel::makeHiddenForm("CSVForm","index.php",$params);
    } else {
        $params = array(
            'idlist' => $idlist,
            'idtype' => $idtype,
            'outputFormat' => $outputFormat,
			'hideunique' => isset($_POST['hideunique'])?1:0
            );
        echo \html\FormPanel::makeHiddenForm("CSVForm","process.php",$params);
    }
} else {
    $form = new \html\FormPanel("WorldCat Similar Titles Search","form-panel",'md-10',"form-horizontal","");
    if (isset($_POST['errormsg'])) {
        $form->error($_POST['errormsg']);
    }
    $form
        ->select('idtype','ID Type',true,array(
            'isbn'=>'ISBN Numbers',
            'issn'=>'ISSN Numbers'))
//            'oclc'=>'OCLC Numbers',
//            'sn'=>'Standard Numbers'))
        ->select('outputFormat','Output Format',true,array(
            'html'=>'HTML',
            'xml'=>'XML'))
        ->file('idlist_file','Import IDs (CSV or line breaks)')
        ->textarea('idlist_textarea','ID List (CSV or line breaks)')
		->checkbox("hideunique","Ignore entries w/o related titles")
        ->button('submit','Submit','btn btn-primary');

    $container = new \html\GridDiv("container");
    $container
        ->row()
            ->column('md-1')
            ->column('md-10',null,$form->html())
            ->column('md-1');

    echo $container->html();
}

?></body>
</html>

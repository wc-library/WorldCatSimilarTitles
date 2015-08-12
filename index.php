<?php
require_once "autoloader.php";
?>
<!DOCTYPE html>
<html lang="en"><?php
    $html_header = new \html\Header;
    echo $html_header
        ->title("WorldCat Similar Titles")
        ->css("normalize.css")
        ->css("bootstrap.min.css")
        ->css("bootstrap-theme.min.css")
        ->css("style.css")
        ->js('jquery.js')
        ->html();
        ?>
    <body>
        <?php
        if (!isset($_POST['submit'])) {
$form = new \html\Form("WorldCat Similar Titles Search","");
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

        } else {
            $idlist = "";
            if (isset($_POST['idlist_textarea'])) {
                $idlist .= \util\Misc::cleanCSV($_POST['idlist_textarea']);
            }

            if (isset($_POST['idlist_textarea']) && isset($_FILES['idlist_file'])) {
                $idlist .= ',';
            }

            if (isset($_FILES['idlist_file'])) {
                $file = new \input\FileUpload('idlist_file');
                $txt = $file->read();
                $idlist .= \util\Misc::cleanCSV($txt);
            }

            if (isset($_POST['idtype'])) {
                $idtype = $_POST['idtype'];
            } else {
                error_log("form param 'idtype' was not set!");
            }

            if (isset($_POST['outputFormat'])) {
                $outputFormat = $_POST['outputFormat'];
            } else {
                error_log("form param 'outputFormat' was not set!");
            }

            if ($idlist==="") {
                error_log("form does not contain any IDs");
            }

            $params = array(
                'idlist' => $idlist,
                'idtype' => $idtype,
                'outputFormat' => $outputFormat
                );
            echo \html\Form::makeHiddenForm("CSVForm","process.php",$params);

            echo "<form id=\"CSVForm\" action=\"process.php\" method=\"post\">
            <input type=\"hidden\" name=\"idlist\" value=\"$idlist\" />
            <input type=\"hidden\" name=\"idtype\" value=\"$idtype\" />
            <input type=\"hidden\" name=\"outputFormat\" value=\"$outputFormat\" />

            <script type='text/javascript'>
                $(document).ready(function () {
                    $('#CSVForm').submit();
                });
            </script>";
        }
        ?>
    </body>
</html>

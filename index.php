<?php
require_once "autoloader.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta content="text/html; charset=UTF-8">
        <title>WorldCat Similar Titles</title>
        <link type="text/css" rel="stylesheet" href="css/normalize.css" />
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="css/bootstrap-theme.min.css" />
        <script type='text/javascript' src='js/jquery.js'></script>
    </head>
    <body>
        <?php
        if (!isset($_POST['submit'])) { ?>


<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>WorldCat Similar Titles Search</legend>

<!-- Select Classification Type -->
<div class="form-group">
  <label class="col-md-4 control-label" for="idtype">ID Type</label>
  <div class="col-md-4">
    <select id="idtype" name="idtype" class="form-control" required>
      <option value="oclc">OCLC Numbers</option>
      <option value="isbn">ISBN Numbers</option>
      <option value="issn">ISSN Numbers</option>
      <option value="sn">Standard Numbers</option>
    </select>
  </div>
</div>

<!-- Select Output Format -->
<div class="form-group">
  <label class="col-md-4 control-label" for="outputFormat">Output Format</label>
  <div class="col-md-4">
    <select id="outputFormat" name="outputFormat" class="form-control" required>
      <option value="xml">XML</option>
    </select>
  </div>
</div>

<!-- Import IDs from file -->
<div class="form-group">
  <label class="col-md-4 control-label" for="idlist_file">Import IDs (CSV or line breaks)</label>
  <div class="col-md-4">
    <input id="idlist_file" name="idlist_file" class="input-file" type="file">
  </div>
</div>

<!-- Textarea for ID entry -->
<div class="form-group">
  <label class="col-md-4 control-label" for="idlist_textarea">ID List (CSV or line breaks)</label>
  <div class="col-md-4">
    <textarea class="form-control" id="idlist_textarea" name="idlist_textarea"></textarea>
  </div>
</div>

<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>


        <?php
        } else {
            $idlist = "";
            if (isset($_POST['idlist_textarea'])) {
                $idlist .= \util\Misc::cleanCSV($_POST['idlist_textarea']);
            }

            if (isset($_POST['idlist_textarea']) && isset($_FILES['idlist_file'])) {
                $idlist .= ',';
            }

            if (isset($_FILES['idlist_file'])) {
                $idlist .= \util\Misc::cleanCSV(file_get_contents($_FILES['idlist_file']['name']));
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

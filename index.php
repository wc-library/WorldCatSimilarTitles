<?php
require_once "autoloader.php";
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>WorldCat Similar Titles</title>
        <script type='text/javascript' src='js/jquery.js'></script>
    </head>
    <body>
        <?php
        $txtInput = new \input\Text;
        $fileInput = new \input\File;

        if (!isset($_POST['submit'])) {
            echo"<div>
                <form action='{$_SERVER['PHP_SELF']}' method='post' enctype='multipart/form-data'>
                   <div colspan='2'>".$txtInput->formElement()."</div>
                       <br /><br /><br />
                   ".$fileInput->formElement()."
                   <input type='submit' name='submit' />
                </div>";
        } else {
            $txtData = $txtInput->getString();
            $fileData = $fileInput->getString();

            $values = "";
            if ($txtData!=FALSE) {
                $values .= $txtData;
            }

            if ($txtData!=FALSE && $fileData!=FALSE)
                $values .= ',';

            if ($fileData!=FALSE) {
                $values .= $fileData;
            }

            echo "<form id=\"CSVForm\" action=\"process.php\" method=\"post\">
            <input type=\"hidden\" name=\"csv\" value=\"$values\" />";

            ?><script type='text/javascript'>
                $(document).ready(function() {
                    $("#CSVForm").submit();
                });
            </script><?php
        }
        ?>
    </body>
</html>

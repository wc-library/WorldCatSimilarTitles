<?php

namespace output;

class Html {
    public function display($title,$data) {
        $this->idtype = $_POST['idtype'];
        $this->results = $data['query'];
        $this->libinfo = $data['library'];
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta content="text/html; charset=UTF-8">
        <title>WorldCat Similar Titles</title>
        <link type="text/css" rel="stylesheet" href="css/normalize.css" />
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="css/bootstrap-theme.min.css" />
        <script type='text/javascript' src='js/jquery.js'></script>
    </head>
    <body>
        <?php
        echo "<div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-6\">
            <table class=\"table table-condensed table-bordered\">
            <caption>library info</caption>
            <tbody>
            <tr><th>Institution Name</th><td>{$this->libinfo['institutionName']}</td></tr>
            <tr><th>OCLC Symbol</th><td>{$this->libinfo['oclcSymbol']}</td></tr>
            <tr><th>City</th><td>{$this->libinfo['city']}</td></tr>
            <tr><th>State</th><td>{$this->libinfo['state']}</td></tr>
            <tr><th>Country</th><td>{$this->libinfo['country']}</td></tr>
            <tr><th>Postal Code</th><td>{$this->libinfo['postalCode']}</td></tr>
            </tbody>
            </table>
            </div>
            <div class=\"col-md-4\"></div>
            </div>";

        echo "<div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-8\">
            <table class=\"table table-bordered table-hover table-condensed\">
            <caption>$title</caption>",
            $this->display_thead(),
            $this->display_tbody(),
            "</table>
            </div>
            <div class=\"col-md-2\"></div>
            </div>";
        ?>
    </body>
</html>
<?php
    }

    protected function displayLibraryInfo() {

    }

    protected function display_thead() {
        echo "<thead>
        <th>$this->idtype#</th>
        <th>Title</th>
        <th>Author</th>
        <th>Publisher</th>
        <th>Date</th>
        <th>Related $this->idtype#s</th>
        </thead>";
    }

    protected function display_tbody() {
        echo "<tbody>";
        foreach ($this->results as $query) {
            $id = $query['id'];
            $rowcls = "";
            if ($query['url']) {
                $id = "<a href=\"{$query['url']}\">$id</a>";
                $rowcls = "class='success'";
            }

            echo "<tr $rowcls>
                <td>$id</td>
                <td>{$query['title']}</td>
                <td>{$query['author']}</td>
                <td>{$query['publisher']}</td>
                <td>{$query['date']}</td>
                <td>". \implode("&nbsp;<br>",$query['related'])."</td>
                </tr>";
        }
        echo "</tbody>";
    }
}
